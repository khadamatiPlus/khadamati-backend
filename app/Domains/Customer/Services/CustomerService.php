<?php

namespace App\Domains\Customer\Services;

use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Domains\Customer\Models\Customer;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerService extends BaseService
{

    /**
     * @var string $entityName
     */
    protected $entityName = 'Customer';

    /**
     * @var UserService $userService
     */
    protected $userService;



    /**
     * @var StorageManagerService $storageManagerService
     */
    protected $storageManagerService;

    public function __construct(Customer $customer, UserService $userService,StorageManagerService $storageManagerService)
    {
        $this->model = $customer;
        $this->userService = $userService;
        $this->storageManagerService = $storageManagerService;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws GeneralException
     * @throws \Throwable
     */
    public function register(array $data = [])
    {
//        echo $data['cities'];exit();
        DB::beginTransaction();

        try {
            $customerUser = $this->userService->registerUser([
                'type' => User::TYPE_USER,
                'name' => $data['name'],
                'mobile_number' => $data['mobile_number'],
                'timezone' => $data['timezone'] ?? env('DEFAULT_TIMEZONE','Asia/Amman')

            ]);



            $customerUser->syncRoles([3]);

            if(!auth()->check()){
                auth()->loginUsingId($customerUser->id);
            }

            $data['profile_id'] = $customerUser->id;

            $captain = $this->store($data);

            $customerUser->fill([
                'customer_id' => $captain->id ?? null,
            ])->save();

            $customerUser = $customerUser->refresh();

        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            throw new GeneralException(__('There was a problem registering the captain. Please try again.'));
        }

        event(new UserCreated($customerUser));
        DB::commit();

        //TODO uncomment the below line to send verification email
//        $merchantAdmin->sendEmailVerificationNotification();

        return $captain;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = [])
    {

        $data['is_verified'] = false;

        if(!empty($data['personal_photo']) && request()->hasFile('personal_photo')){
            try {
                $this->upload($data,'personal_photo');
            } catch (\Exception $e) {
                throw $e;
            }
        }

        if(!empty($data['profile_pic']) && request()->hasFile('profile_pic')){
            try {
                $data = $this->upload($data,'profile_pic', 'captain/identity_cards/profile_pic');
            } catch (\Exception $e) {
                throw $e;
            }
        }

        $customer = parent::store($data);


        return $customer;
    }

    public function update($entity, array $data = [])
    {
        $data = array_filter($data);

        $customer = $this->getById($entity);
        $customerUser=$this->userService->where('id',$customer->profile_id)->firstOrFail();
        if(isset($data['name'])) {
            $customerUser->update([
                'name' => $data['name'],
            ]);
        }

        if(!empty($data['profile_pic']) && request()->hasFile('profile_pic')){
            try {
                $this->storageManagerService->deletePublicFile($customer->profile_pic,'customer/identity_cards/profile_pic');
                $data = $this->upload($data,'profile_pic', 'customer/identity_cards/profile_pic');
            } catch (\Exception $e) {
                throw $e;
            }
        }

        if(isset($data['is_verified'])){
            $data['is_verified'] = 1;
        }
        else{
            $data['is_verified'] = $customer->is_verified;
        }
        return parent::update($entity, $data);
    }

    /**
     * @param $entity
     * @return bool
     * @throws \Exception
     */
    public function destroy($entity): bool
    {
        $customer = $this->getById($entity);
        $customer->profile()->delete();
        return $this->deleteById($entity);
    }

    /**
     * @param array $data
     * @param $fileColumn
     * @param string $directory
     * @return array
     * @throws \Exception
     */
    private function upload(array &$data, $fileColumn, string $directory = 'customer/personal_photos'): array
    {
        try{
            $data[$fileColumn] = $this->storageManagerService->uploadPublicFile($data[$fileColumn],$directory);
            return $data;
        }
        catch (\Exception $exception){
            throw $exception;
        }
    }

    /**
     * @param Request $request
     */
    public function updateStatus(Request $request)
    {

        $customer = Customer::query()->findOrFail($request->input('customerId'));
        if($customer->is_verified){
            $customer->is_verified = 0;
        }
        else{
            $customer->is_verified = 1;
        }
        $customer->update();

    }

}
