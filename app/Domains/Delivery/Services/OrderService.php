<?php

namespace App\Domains\Delivery\Services;


use App\Domains\Delivery\Events\Order\OrderMarkedCompleted;
use App\Domains\Delivery\Models\Order;
use App\Domains\Merchant\Models\Merchant;
use App\Domains\Merchant\Services\MerchantBranchService;
use App\Domains\Merchant\Services\MerchantService;
use App\Enums\Core\CaptainStatuses;
use App\Enums\Core\ErrorTypes;
use App\Enums\Core\OrderStatuses;
use App\Exceptions\GeneralException;
use App\Services\BaseService;
use App\Services\StorageManagerService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class OrderService extends BaseService
{
    /**
     * @var string $entityName
     */
    protected $entityName = 'Order';


    /**
     * @var MerchantService
     */
    protected $merchantService;

    /**
     * @param Order $order
     * @param MerchantService $merchantService
     */
    public function __construct(Order $order,MerchantService $merchantService,StorageManagerService $storageManagerService)
    {
        $this->model = $order;
        $this->merchantService = $merchantService;
        $this->storageManagerService = $storageManagerService;
    }


    /**
     * @param array $data
     * @return mixed
     * @throws GeneralException
     * @throws \Throwable
     */
    public function addMerchantOrder(array $data = [])
    {
        $orderNumber = Str::upper('ORD' . uniqid());
        $user = auth()->user();
        $data['order_reference'] = $orderNumber;
        $data['merchant_id'] = $user->merchant_id;
        if($data['is_instant_delivery']==true){
            $data['is_instant_delivery']=1;
        }
        if(!empty($data['voice_record']) && request()->hasFile('voice_record')){
            try {
                $this->upload($data,'voice_record');
            } catch (\Exception $e) {
                throw $e;
            }
        }
        $order = parent::store($data);
        return $order;
    }

    public function getMerchantOrders($status = [],$orderId = null)
    {
        return $this->model::query()
            ->when(auth()->user()->merchant_id,fn($query, $merchant_id) => $query->where('merchant_id', $merchant_id))
            ->when($status, fn ($query, $status) => $query->whereIn('status', $status))
            ->when($orderId, fn ($query, $orderId) => $query->where('id', $orderId))
            ->orderByDesc('id');
    }
    public function getCaptainOrders($from_date = null,$to_date = null)
    {
        $query=  $this->model::query()->
        when(auth()->user()->captain_id, fn($query, $captain_id) => $query->where('captain_id', $captain_id));
        if (!empty($from_date) && !empty($to_date)) {
            $from_date = Carbon::parse($from_date)->startOfDay();
            $to_date = Carbon::parse($to_date)->endOfDay();
            $query->whereBetween('delivered_at', [$from_date, $to_date]);
        }
        return $query->orderBy('created_at','desc');
    }
    /**
     * @param array $data
     * @return array
     */
    public function merchantAction($data = []): array
    {
        $order = Recent::query()
            ->when(auth()->user()->merchant_id,fn($query, $merchant_id) => $query->where('merchant_id', $merchant_id))
            ->when(auth()->user()->merchant_branch_id,fn($query, $merchant_branch_id) => $query->where('merchant_branch_id', $merchant_branch_id))
            ->when($data['order_id'], fn ($query, $orderId) => $query->where('id', $orderId))
            ->first();

        if(empty($order)){
            return [
                'done' => false,
                'message' => __('Order not found')
            ];
        }
        switch (true)
        {
            case $data['action_id'] == OrderActions::MERCHANT_ACCEPT_ORDER:
                if($order->status == OrderStatuses::NEW_ORDER){
                    $order->acceptByMerchant();
                    $resp = [
                        'done' => true,
                        'message' => __('The order has been accepted')
                    ];
                }
                else{
                    $resp = [
                        'done' => false,
                        'message' => __('You already accepted this order')
                    ];
                }
                break;
            case $data['action_id'] == OrderActions::MERCHANT_CONFIRM_CAPTAIN_ARRIVAL:
                if($order->status == OrderStatuses::CAPTAIN_ACCEPTED){
                    $order->confirmCaptainArrival();
                    $resp = [
                        'done' => true,
                        'message' => __('Confirmed captain arrival successfully done')
                    ];
                }
                else{
                    $resp = [
                        'done' => false,
                        'message' => __('You already confirmed that the captain arrived')
                    ];
                }
                break;
            case $data['action_id'] == OrderActions::MERCHANT_REJECT_ORDER:
            default:
                if($order->status == OrderStatuses::NEW_ORDER){
                    $order->rejectByMerchant();
                    $resp = [
                        'done' => true,
                        'message' => __('The order has been rejected')
                    ];
                }
                else{
                    $resp = [
                        'done' => false,
                        'message' => __('You already rejected this order')
                    ];
                }
                break;
        }
        return $resp;
    }
    protected function internalServerErrorResponse($error, array $responseHeaders = []): \Illuminate\Http\JsonResponse
    {
        return response()->json(['error_type' => ErrorTypes::GENERAL, 'errors' => [array('key' => 'general', 'error' => $error)]], 500, $responseHeaders, JSON_UNESCAPED_SLASHES);
    }
    private function upload(array &$data, $fileColumn, string $directory = 'order/voice_records'): array
    {
        try{
            $data[$fileColumn] = $this->storageManagerService->uploadPublicFile($data[$fileColumn],$directory);
            return $data;
        }
        catch (\Exception $exception){
            throw $exception;
        }
    }

}
