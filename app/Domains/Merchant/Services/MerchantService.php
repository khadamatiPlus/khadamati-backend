<?php

namespace App\Domains\Merchant\Services;
use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Domains\Merchant\Events\MerchantApproved;
use App\Domains\Merchant\Models\Merchant;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use App\Services\StorageManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class MerchantService extends BaseService
{

    /**
     * @var string $entityName
     */
    protected $entityName = 'Merchant';

    /**
     * @var UserService $userService
     */
    protected $userService;

    /**
     * @var StorageManagerService $storageManagerService
     */
    protected $storageManagerService;


    /**
     * @param Merchant $merchant
     * @param UserService $userService
     * @param StorageManagerService $storageManagerService
     */
    public function __construct(Merchant $merchant, UserService $userService, StorageManagerService $storageManagerService)
    {
        $this->model = $merchant;
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
        DB::beginTransaction();

        try {
            $merchantAdmin = $this->userService->registerUser([
                'type' => User::TYPE_USER,
                'name' => $data['name'] ?? null,
                'mobile_number' => $data['mobile_number'],
                'merchant_id' => $data['merchant_id'] ?? null,
                'timezone' => $data['timezone'] ?? env('DEFAULT_TIMEZONE','Asia/Amman')
            ]);

            $merchantAdmin->syncRoles([2]);

            if(!auth()->check()){
                auth()->loginUsingId($merchantAdmin->id);
            }

            $data['profile_id'] = $merchantAdmin->id;

            $merchant = $this->store($data);


            $merchantAdmin->fill([
                'merchant_id' => $merchant->id ?? null,
            ])->save();

            $merchantAdmin = $merchantAdmin->refresh();

        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
            throw new GeneralException(__('There was a problem registering the merchant. Please try again.'));
        }

        event(new UserCreated($merchantAdmin));

        DB::commit();
        return $merchant;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws GeneralException
     * @throws \Throwable
     */
    public function store(array $data = [])
    {
        $data['is_verified']='1';
        if(!empty($data['profile_pic']) && request()->hasFile('profile_pic')){
            try {
                $this->upload($data,'profile_pic');
            } catch (\Exception $e) {
                throw $e;
            }
        }

        $merchant = parent::store($data);

        return $merchant;
    }

    /**
     * @param $entity
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     * @throws GeneralException
     * @throws \Throwable
     */
    public function update($entity, array $data = [])
    {

        $data = array_filter($data);
        $merchant = $this->getById($entity);
         $user=User::query()->where('id',$merchant->profile_id)->firstOrFail();
//        echo 'ss';exit();
        if(!empty($data['profile_pic']) && request()->hasFile('profile_pic')){
//            echo 'ss';exit();
            try {
                $this->storageManagerService->deletePublicFile($merchant->profile_pic,'merchants/profile_pics');

                $this->upload($data,'profile_pic','merchants/profile_pic',$merchant->logo);

            } catch (\Exception $e) {
                throw $e;
            }
        }
        if(isset($data['is_verified'])){
            $data['is_verified'] = 1;
        }
        else{
            $data['is_verified'] =  $merchant->is_verified;
        }
        $data['profile_id'] = $merchant->profile_id;
        return parent::update($entity, $data);
    }

    /**
     * @param array $data
     * @param $fileColumn
     * @param string $directory
     * @return array
     * @throws \Exception
     */
    private function upload(array &$data, $fileColumn, string $directory = 'merchants/profile_pic',$old_file_name = null): array
    {
        try{
            $data[$fileColumn] = $this->storageManagerService->uploadPublicFile($data[$fileColumn],$directory,$old_file_name);
            return $data;
        }
        catch (\Exception $exception){
            throw $exception;
        }
    }

    public function updateStatus(Request $request)
    {
        $merchant = Merchant::query()->findOrFail($request->input('merchantId'));
        if($merchant->is_verified){
            $merchant->is_verified = 0;
        }
        else{
            $merchant->is_verified = 1;
        }
        $merchant->update();

    }


    public function getMerchants($service_id = null,$is_featured = null, $category_id = null, $status = null, $free_delivery = null, $new = null, $is_near = null,$is_top_rated = null)
    {
        $query = $this->model::query()->where('is_verified','1')
            ->when($service_id, fn ($query, $service_id) => $query->where('service_id', $service_id))
            ->when($is_featured, fn ($query, $is_featured) => $query->where('is_featured', $is_featured))
            ->when($category_id, fn ($query, $category_id) => $query->where('category_id', $category_id))
            ->when($new, fn($query,$new) => $query->newOnPlatform())
            ->when($free_delivery, function ($query) use($free_delivery){
                $query->whereHas('merchantBranches', function ($qq) use ($free_delivery){
                    $qq->freeDelivery();
                });
            })
            ->when($status, function ($query) use($status){
                $query->whereHas('merchantBranches', function ($qq) use ($status){
                    $qq->byStatus($status);
                });
            })
            ->whereHas('merchantBranches', function ($qq) {
                if (\request()->header('latitude') != 0 &&\request()->header('longitude')!=0) {
                    $qq->isWithinMaxDistance(['latitude' => \request()->header('latitude'), 'longitude' => \request()->header('longitude')]);

                }
            });


//            ->whereHas('merchantBranches',function ($qq){
//                $qq->isWithinMaxDistance(['latitude' => \request()->header('latitude') ?? '0','longitude' => \request()->header('longitude') ?? '0']);
//            });

        if(!empty(request()->input('is_top_rated')) && request()->input('is_top_rated') == 1){
            $query->withAvg('reviews','rating_stars')->having('reviews_avg_rating_stars','>=',env('TOP_RATE_VALUE',4.5));
        }
        return $query->orderByDesc('id');
    }
    public function getMerchantsHaveCoupons($service_id = null,$is_featured = null, $category_id = null, $status = null, $free_delivery = null, $new = null, $is_near = null,$is_top_rated = null)
    {
        $query = $this->model::query()->where('is_verified','1')
            ->when($service_id, fn ($query, $service_id) => $query->where('service_id', $service_id))
            ->when($is_featured, fn ($query, $is_featured) => $query->where('is_featured', $is_featured))
            ->when($category_id, fn ($query, $category_id) => $query->where('category_id', $category_id))
            ->when($new, fn($query,$new) => $query->newOnPlatform())
            ->when($free_delivery, function ($query) use($free_delivery){
                $query->whereHas('merchantBranches', function ($qq) use ($free_delivery){
                    $qq->freeDelivery();
                });
            })
            ->when($status, function ($query) use($status){
                $query->whereHas('merchantBranches', function ($qq) use ($status){
                    $qq->byStatus($status);
                });
            })
            ->whereHas('merchantBranches', function ($query) {
                $query->whereHas('items', function ($query) {
                    $query->where('is_offer', '2')->where('status','!=','0')->whereHas('itemVariations', function ($query) {
                        $query->where('in_stock', '!=', 0);
                    });
                });
            })
            ->whereHas('merchantBranches',function ($qq){
                $qq->isWithinMaxDistance(['latitude' => \request()->header('latitude') ?? '0','longitude' => \request()->header('longitude') ?? '0']);
            });


        if(!empty(request()->input('is_top_rated')) && request()->input('is_top_rated') == 1){
            $query->withAvg('reviews','rating_stars')->having('reviews_avg_rating_stars','>=',env('TOP_RATE_VALUE',4.5));
        }
        return $query->orderByDesc('id');
    }
}
