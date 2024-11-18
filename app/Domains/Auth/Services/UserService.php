<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Events\User\UserDeleted;
use App\Domains\Auth\Events\User\UserDestroyed;
use App\Domains\Auth\Events\User\UserLoggedIn;
use App\Domains\Auth\Events\User\UserRestored;
use App\Domains\Auth\Events\User\UserStatusChanged;
use App\Domains\Auth\Events\User\UserUpdated;
use App\Domains\Auth\Http\Transformers\UserTransformer;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Domains\Captain\Http\Transformers\CaptainTransformer;
use App\Domains\Customer\Http\Transformers\CustomerTransformer;
use App\Domains\Merchant\Http\Transformers\MerchantBranchTransformer;
use App\Domains\Merchant\Http\Transformers\MerchantTransformer;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService.
 */
class UserService extends BaseService
{
    /**
     * UserService constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * @param $type
     * @param  bool|int  $perPage
     * @return mixed
     */
    public function getByType($type, $perPage = false)
    {
        if (is_numeric($perPage)) {
            return $this->model::byType($type)->paginate($perPage);
        }

        return $this->model::byType($type)->get();
    }

    /**
     * @param  array  $data
     * @return mixed
     *
     * @throws GeneralException
     */
    public function registerUser(array $data = []): User
    {
        DB::beginTransaction();

        try {
            $user = $this->createUser($data);
        } catch (Exception $e) {

            DB::rollBack();

            throw new GeneralException(__('There was a problem creating your account.'));
        }

        DB::commit();

        return $user;
    }

    /**
     * @param $info
     * @param $provider
     * @return mixed
     *
     * @throws GeneralException
     */
    public function registerProvider($info, $provider): User
    {
        $user = $this->model::where('provider_id', $info->id)->first();

        if (! $user) {
            DB::beginTransaction();

            try {
                $user = $this->createUser([
                    'name' => $info->name,
                    'email' => $info->email,
                    'provider' => $provider,
                    'provider_id' => $info->id,
                    'email_verified_at' => now(),
                ]);
            } catch (Exception $e) {
                DB::rollBack();

                throw new GeneralException(__('There was a problem connecting to :provider', ['provider' => $provider]));
            }

            DB::commit();
        }

        return $user;
    }

    /**
     * @param  array  $data
     * @return User
     *
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = []): User
    {
        DB::beginTransaction();

        try {
            $user = $this->createUser([
                'type' => $data['type'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'email_verified_at' => isset($data['email_verified']) && $data['email_verified'] === '1' ? now() : null,
                'active' => isset($data['active']) && $data['active'] === '1',
            ]);

            // Convert role IDs to names if necessary
            $roles = Role::whereIn('id', $data['roles'] ?? [])->pluck('name')->toArray();

            // Sync roles with the user
            $user->syncRoles($roles);
            if (! config('boilerplate.access.user.only_roles')) {
                $user->syncPermissions($data['permissions'] ?? []);
            }
        } catch (Exception $e) {
            // Log the error message for debugging
            \Log::error('Error creating user: ' . $e->getMessage());
            \Log::error($e->getTraceAsString()); // Log stack trace if needed

            // Or print it directly for debugging
            dd('Error creating user:', $e->getMessage());

            throw new GeneralException(__('There was a problem creating this user. Please try again.'));
        }

        DB::commit();

        if (! isset($data['email_verified']) && isset($data['send_confirmation_email']) && $data['send_confirmation_email'] === '1') {
            $user->sendEmailVerificationNotification();
        }

        return $user;
    }


    /**
     * @param  User  $user
     * @param  array  $data
     * @return User
     *
     * @throws \Throwable
     */
    public function update($user, array $data = []): User
    {
        DB::beginTransaction();

        try {
            $user->update([
                'type' => $user->isMasterAdmin() ? $this->model::TYPE_ADMIN : $data['type'] ?? $user->type,
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            if (! $user->isMasterAdmin()) {
                // Replace selected roles/permissions
                $user->syncRoles($data['roles'] ?? []);

                if (! config('boilerplate.access.user.only_roles')) {
                    $user->syncPermissions($data['permissions'] ?? []);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();

            throw new GeneralException(__('There was a problem updating this user. Please try again.'));
        }

        event(new UserUpdated($user));

        DB::commit();

        return $user;
    }

    /**
     * @param  User  $user
     * @param  array  $data
     * @return User
     */
    public function updateProfile(User $user, array $data = []): User
    {
        $user->name = $data['name'] ?? null;

        if ($user->canChangeEmail() && $user->email !== $data['email']) {
            $user->email = $data['email'];
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            session()->flash('resent', true);
        }

        return tap($user)->save();
    }

    /**
     * @param  User  $user
     * @param $data
     * @param  bool  $expired
     * @return User
     *
     * @throws \Throwable
     */
    public function updatePassword(User $user, $data, $expired = false): User
    {
        if (isset($data['current_password'])) {
            throw_if(
                ! Hash::check($data['current_password'], $user->password),
                new GeneralException(__('That is not your old password.'))
            );
        }

        // Reset the expiration clock
        if ($expired) {
            $user->password_changed_at = now();
        }

        $user->password = $data['password'];

        return tap($user)->update();
    }

    /**
     * @param  User  $user
     * @param $status
     * @return User
     *
     * @throws GeneralException
     */
    public function mark(User $user, $status): User
    {
        if ($status === 0 && auth()->id() === $user->id) {
            throw new GeneralException(__('You can not do that to yourself.'));
        }

        if ($status === 0 && $user->isMasterAdmin()) {
            throw new GeneralException(__('You can not deactivate the administrator account.'));
        }

        $user->active = $status;

        if ($user->save()) {
            event(new UserStatusChanged($user, $status));

            return $user;
        }

        throw new GeneralException(__('There was a problem updating this user. Please try again.'));
    }

    /**
     * @param  User  $user
     * @return User
     *
     * @throws GeneralException
     */
    public function delete($user): User
    {
        if ($user->id === auth()->id()) {
            throw new GeneralException(__('You can not delete yourself.'));
        }

        if ($this->deleteById($user->id)) {
            event(new UserDeleted($user));

            return $user;
        }

        throw new GeneralException('There was a problem deleting this user. Please try again.');
    }

    /**
     * @param  User  $user
     * @return User
     *
     * @throws GeneralException
     */
    public function restore(User $user): User
    {
        if ($user->restore()) {
            event(new UserRestored($user));

            return $user;
        }

        throw new GeneralException(__('There was a problem restoring this user. Please try again.'));
    }

    /**
     * @param  User  $user
     * @return bool
     *
     * @throws GeneralException
     */
    public function destroy($user): bool
    {
        if ($user->forceDelete()) {
            event(new UserDestroyed($user));

            return true;
        }

        throw new GeneralException(__('There was a problem permanently deleting this user. Please try again.'));
    }

    /**
     * @param  array  $data
     * @return User
     */
    protected function createUser(array $data = []): User
    {
        return $this->model::create([
            'type' => $data['type'] ?? $this->model::TYPE_USER,
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'password' => $data['password'] ?? null,
            'mobile_number' => $data['mobile_number'] ?? null,
            'provider' => $data['provider'] ?? null,
            'provider_id' => $data['provider_id'] ?? null,
            'email_verified_at' => $data['email_verified_at'] ?? null,
            'active' => $data['active'] ?? true,
        ]);
    }

    public function authenticateUserMobile($country_code,$mobile_number,$appVersionName, $password)
    {
        if($appVersionName =='khadamati_merchant_app'){
            $normalizedMobileNumber = ltrim($mobile_number, '0');

            // Query the user with the modified mobile number
            $user = $this->where('merchant_id', null, '!=')
                ->where('mobile_number', $normalizedMobileNumber)
                ->first();

        }
        if($appVersionName =='hayat_delivery_captain_app'){
            $user = $this->where('captain_id',null,'!=')
                ->where('mobile_number', $mobile_number)
                ->first();
        }


        if($user != null && Hash::check($password, $user->password)) {
            //TODO check if web admin
            if(!$user->isActive()){
                $user->tokens()->delete();
                $resp = new \stdClass();
                $resp->access_token = '';
                $resp->active = false;
                $resp->completed = true;
                return $resp;
            }

            $resp = new \stdClass();

            if($appVersionName =='khadamati_merchant_app' &&$user->isMerchantAdmin()){
                $merchant=$user->merchant;
                event(new UserLoggedIn($user));
                $user->tokens()->delete();
                $resp->access_token = $user->createToken('mobile')->plainTextToken;
                $resp->user = (new UserTransformer)->transform($user);
                $resp->active = true;
                $resp->completed = true;
                $resp->merchant = (new MerchantTransformer)->transform($merchant);
                $merchantId = $merchant->id;

            }


            elseif($appVersionName =='hayat_delivery_captain_app' &&$user->isCaptain() ){

                event(new UserLoggedIn($user));
                $user->tokens()->delete();
                $resp->access_token = $user->createToken('mobile')->plainTextToken;
                $resp->user = (new UserTransformer)->transform($user);
                $resp->active = true;
                $resp->completed = true;
                $resp->captain = (new CaptainTransformer)->transform($user->captain);
            }

            else{
//                if(($user->isMerchantAdmin() || $user->isMerchantBranchAdmin() || $user->isCustomer()) && ($appVersionName == 'bidi_captain_app_android' || $appVersionName == 'bidi_captain_app_ios')){
//                    $resp = new \stdClass();
//                    $resp->show_not_captain = true;
//
//                    return $resp;
//                }
//                if(($user->isCaptain() )){
//                    $resp = new \stdClass();
//                    $resp->show_not_merchant = true;
//                    return $resp;
//                }
//                else {
//                    if (($user->isMerchantAdmin() || $user->isMerchantBranchAdmin() || $user->isCaptain()) && ($appVersionName == 'bidi_customer_app_android' || $appVersionName == 'bidi_customer_app_ios')) {
//                        $resp = new \stdClass();
//                        $resp->show_not_customer = true;
//
//                        return $resp;
//                    }
//                }
                $resp = new \stdClass();
                $resp->access_token = '';
                $resp->user = null;
                $resp->active = false;
                return $resp;
            }

            return $resp;
        }

        return false;
    }
}
