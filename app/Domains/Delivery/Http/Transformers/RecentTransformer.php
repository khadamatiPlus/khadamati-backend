<?php
namespace App\Domains\Delivery\Http\Transformers;
use App\Domains\Delivery\Models\Recent;
use App\Domains\Delivery\Models\RecentAttribute;
use App\Domains\Item\Http\Transformers\ItemTransformer;
use App\Domains\Item\Models\AttributeValue;
use App\Enums\Core\OrderStatuses;
/**
 * Created by Omar
 * Author: Vibes Solutions
 * On: 1/23/2023
 * Class: RecentTransformer.php
 */
class RecentTransformer
{
    /**
     * @param Recent $recent
     * @return array
     */
    public function transform(Recent $recent): array
    {
//        $ss=RecentAttribute::query()->where('recent_id',$recent->id)->get();
//        echo json_encode($ss);exit();

        return [
            'id' => $recent->id,
            'main_option_values' => $recent->getMainAttributeValues()??[],
            'free_option_values' => $recent->getFreeAttributeValues()??[],
            'pending_actions' => $recent->getPendingMerchantActions(),
            'order_amount'=>floatval ($recent->order_amount),
            'delivery_amount'=>(double) $recent->delivery_amount,
            'delivery_amount_after_sale'=>$recent->delivery_amount_after_sale,
            'merchant_percentage' => numberFormatPrecision($recent->merchant_percentage),
            'total_amount_after_deduct' =>(double) numberFormatPrecision($recent->total_amount_after_deduct),
            'total_amount' => $recent->merchantBranch->free_delivery == 1?numberFormatPrecision(floatval($recent->order_amount)):numberFormatPrecision($recent->total_amount),
            'order_reference' => strval($recent->order_reference),
            'merchant_id' => $recent->merchant_id,
            'merchant_branch_id'=>$recent->merchant_branch_id,
            'merchant_name' => $recent->merchant->business_name,
            'captain_id' =>!empty($recent->captain_id)?$recent->captain_id:null,
            'captain_name' => !empty($recent->captain_id)&&isset($recent->captain)?$recent->captain->name:'',
            'captain_phone_number' => !empty($recent->captain_id)&&isset($recent->captain)?$recent->captain->country_code.$recent->captain->mobile_number:'',
            'points'=>$recent->points,
            'item_id'=>$recent->item_id,
            'payment_type'=>$recent->payment_type,
            'status'=>$recent->status,
            'merchant_accepted_at' => $recent->merchant_accepted_at,
            'captain_requested_at' => $recent->captain_requested_at,
            'captain_accepted_at' => $recent->captain_accepted_at,
            'captain_arrived_at' => $recent->captain_arrived_at,
            'captain_picked_order_at' => $recent->captain_picked_order_at,
            'captain_started_trip_at' => $recent->captain_started_trip_at,
            'captain_on_the_way_at' => $recent->captain_on_the_way_at,
            'delivered_at' => $recent->delivered_at,
            'customer_picked_order_at' => $recent->customer_picked_order_at,
            'merchant_rejected_at' => $recent->merchant_rejected_at,
            'special_requests' => $recent->special_requests,
            'customer_name' => !empty($recent->customer)&&!empty($recent->customer->profile)?$recent->customer->first_name.' '.$recent->customer->last_name:__('Deleted Customer'),
            'customer_phone' => !empty($recent->customer)&&!empty($recent->customer->profile)?$recent->customer->profile->country_code.$recent->customer->profile->mobile_number:__('Deleted Customer'),
            'address_info' => !empty($recent->customer)&&!empty($recent->customerAddress)?$recent->customerAddress->address_line_one ?? '':__('Deleted Customer'),
            'last_update' => $recent->updated_at,
            'merchant_branch_latitude' => $recent->merchantBranch->latitude,
            'merchant_branch_longitude' => $recent->merchantBranch->longitude,
            'merchant_branch_address' => $recent->merchantBranch->address_info,
            'show_confirm_arrival_question' => $recent->status == OrderStatuses::CAPTAIN_ACCEPTED && empty($recent->captain_arrived_at),
//            'captain_revenue' => !is_null($recent->captainWalletTransaction)?$recent->captainWalletTransaction->captain_revenue:0.000,
            'captain_revenue' =>$recent->captain_revenue ,
            'kilometers' =>"0.001",
            'recent_type'=>$recent->recent_type,
//            'recent_type'=>strval($recent->recent_type),
            'latitude'=>strval($recent->latitude),
            'longitude'=>strval($recent->longitude),
            'street_name'=>$recent->getStreetName()??"",
            'payment_checkout_id'=>$recent->payment_checkout_id,
            'payment_status'=>$recent->payment_status,
            'payment_status_description' => !empty($recent->payment_status)? transHyperPayCodes($recent->payment_status):'',
            'is_offer'=>$recent->is_offer,
            'merchant_branch_name'=>$recent->merchant_branch_name,
            'created_by_id'=>$recent->created_by_id,
            'created_at'=>$recent->created_at,
            'item' => !empty($recent->item_id)?(new ItemTransformer)->transform($recent->item):null,
            'discount_name'=>!empty($recent->discount_id)?$recent->discount->title:null,
            'can_complaint'=>$recent->canComplaint(),

        ];
    }
    public function transformForNotification(Recent $recent): array
    {
        return [
            'id' => $recent->id,//1
            'captain_name' => !empty($recent->captain_id)?$recent->captain->name:'',//1
            'status'=>$recent->status,
        ];
    }

    public function transformForCustomer(Recent $order): array
    {
        return [
            'id' => $order->id,
            'main_option_values' => $order->getMainAttributeValues()??[],
            'free_option_values' => $order->getFreeAttributeValues()??[],
            'order_amount' => numberFormatPrecision($order->order_amount),
            'delivery_amount_after_sale' => $order->delivery_amount_after_sale??"",
            'delivery_amount' => $order->merchantBranch->free_delivery == 1?numberFormatPrecision(0.0):numberFormatPrecision($order->delivery_amount),
            'merchant_percentage' => numberFormatPrecision($order->merchant_percentage),
            'merchant_revenue' => numberFormatPrecision($order->merchant_revenue),
            'total_amount_after_deduct' => $order->merchantBranch->free_delivery == 1?numberFormatPrecision($order->order_amount):numberFormatPrecision($order->total_amount_after_deduct),
            'total_amount' => $order->merchantBranch->free_delivery == 1?numberFormatPrecision(floatval($order->order_amount)):numberFormatPrecision($order->total_amount),
            'order_reference' => $order->order_reference,
            'payment_type' => $order->payment_type,
            'payment_checkout_id' => $order->payment_checkout_id ?? '',
            'payment_status' => $order->payment_status ?? '',
            'payment_status_description' => !empty($order->payment_status)? transHyperPayCodes($order->payment_status):'',
            'merchant_name' => $order->merchant->business_name,
            'merchant_branch_name' => $order->merchantBranch->name,
            'captain_id' => $order->captain_id,
            'captain_name' => !empty($order->captain_id)?$order->captain->name:'',
            'captain_phone_number' => !empty($order->captain_id)?$order->captain->country_code.$order->captain->mobile_number:'',
            'status' => $order->status,
            'created_at' => $order->created_at,
            'merchant_accepted_at' => $order->merchant_accepted_at,
            'captain_requested_at' => $order->captain_requested_at,
            'captain_accepted_at' => $order->captain_accepted_at,
            'captain_arrived_at' => $order->captain_arrived_at,
            'captain_picked_order_at' => $order->captain_picked_order_at,
            'captain_started_trip_at' => $order->captain_started_trip_at,
            'captain_on_the_way_at' => $order->captain_on_the_way_at,
            'delivered_at' => $order->delivered_at,
            'customer_picked_order_at' => $order->customer_picked_order_at,
            'merchant_rejected_at' => $order->merchant_rejected_at,
            'special_requests' => $order->special_requests,
            'customer_name' => !empty($recent->customer)&&!empty($recent->customer->profile)?$recent->customer->first_name.' '.$recent->customer->last_name:__('Deleted Customer'),
            'customer_phone' => !empty($recent->customer)&&!empty($recent->customer->profile)?$recent->customer->profile->country_code.$recent->customer->profile->mobile_number:__('Deleted Customer'),
            'address_info' => !empty($recent->customer)&&!empty($recent->customerAddress)?$recent->customerAddress->address_line_one ?? '':__('Deleted Customer'),
            'merchant_branch_address' => $order->merchantBranch->address_info,
            'item' => (new ItemTransformer)->transform($order->item)??"",
            'street_name'=>$order->getStreetName()??"",
            'discount_name'=>!empty($recent->discount_id)?$recent->discount->title:null,
            'can_complaint'=>$recent->canComplaint(),

        ];
    }

    /**
     * @param Recent $recent
     * @return array
     */
    public function transformForSocket(Recent $recent): array
    {
        return [
            'id' => $recent->id,
            'order_amount'=>floatval ($recent->order_amount),
            'delivery_amount'=>(double) $recent->delivery_amount,
            'delivery_amount_after_sale'=>$recent->delivery_amount_after_sale,
            'total_amount' => $recent->merchantBranch->free_delivery == 1?numberFormatPrecision(floatval($recent->order_amount)):numberFormatPrecision($recent->total_amount),
            'merchant_id' => $recent->merchant_id,
            'merchant_branch_id'=>$recent->merchant_branch_id,
            'merchant_name' => $recent->merchant->business_name,
            'points'=>$recent->points,
            'item_id'=>$recent->item_id,
            'captain_id' => $recent->captain_id ?? 0,
            'payment_type'=>$recent->payment_type,
            'special_requests' => $recent->special_requests,
            'customer_name' => !empty($recent->customer)&&!empty($recent->customer->profile)?$recent->customer->first_name.' '.$recent->customer->last_name:__('Deleted Customer'),
            'customer_phone' => !empty($recent->customer)&&!empty($recent->customer->profile)?$recent->customer->profile->country_code.$recent->customer->profile->mobile_number:__('Deleted Customer'),
            'merchant_branch_latitude' => $recent->merchantBranch->latitude,
            'merchant_branch_longitude' => $recent->merchantBranch->longitude,
            'merchant_branch_address' => $recent->merchantBranch->address_info,
            'show_confirm_arrival_question' => $recent->status == OrderStatuses::CAPTAIN_ACCEPTED && empty($recent->captain_arrived_at),
            'captain_revenue' =>$recent->captain_revenue ,
            'recent_type'=>$recent->recent_type,
            'latitude'=>strval($recent->latitude),
            'longitude'=>strval($recent->longitude),
            'street_name'=>$recent->getStreetName()??"",
            'payment_checkout_id'=>$recent->payment_checkout_id,
            'payment_status'=>$recent->payment_status,
            'payment_status_description' => !empty($recent->payment_status)? transHyperPayCodes($recent->payment_status):'',
            'is_offer'=>$recent->is_offer,
            'merchant_branch_name'=>$recent->merchant_branch_name,
            'created_by_id'=>$recent->created_by_id,
            'created_at'=>$recent->created_at,
        ];
    }
}
