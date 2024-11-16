<?php

namespace App\Domains\Delivery\Http\Transformers;

use App\Domains\Delivery\Models\Order;
use App\Enums\Core\OrderStatuses;

class OrderTransformer
{

    /**
     * @param Order $order
     * @return array
     */
    public function transform(Order $order): array
    {
        return [
            'id' => $order->id,
//            'pending_actions' => $order->getPendingMerchantActions(),
            'delivery_destination' => $order->delivery_destination??"",
            'city_id' => $order->city_id??"",
            'city_name' => $order->city->name??"",
            'vehicle_type_id' => $order->vehicle_type_id??"",
            'vehicle_type_name' => $order->vehicleType->name??"",
            'customer_phone' => $order->customer_phone??"",
            'order_amount' => numberFormatPrecision($order->order_amount)??"",
            'delivery_amount' => numberFormatPrecision($order->delivery_amount)??"",
            'order_reference' => $order->order_reference??"",
            'merchant_name' => $order->merchant->name??"",
            'captain_id' => $order->captain_id,
            'captain_name' => !empty($order->captain_id)?$order->captain->name??"":'',
            'captain_phone_number' => !empty($order->captain_id)?$order->captain->profile->country_code.$order->captain->profile->mobile_number:'',
            'status' => $order->status,
            'created_at' => $order->created_at,
            'captain_requested_at' => $order->captain_requested_at,
            'captain_accepted_at' => $order->captain_accepted_at,
            'captain_arrived_at' => $order->captain_arrived_at,
            'captain_picked_order_at' => $order->captain_picked_order_at,
            'captain_started_trip_at' => $order->captain_started_trip_at,
            'captain_on_the_way_at' => $order->captain_on_the_way_at,
            'delivered_at' => $order->delivered_at,
            'customer_picked_order_at' => $order->customer_picked_order_at,
            'notes' => $order->notes,
            'last_update' => $order->updated_at,
            'latitude' => $order->latitude,
            'longitude' => $order->longitude,
            'show_confirm_arrival_question' => $order->status == OrderStatuses::CAPTAIN_ACCEPTED && empty($order->captain_arrived_at),
        ];
    }

//    /**
//     * @param Order $order
//     * @return array
//     */
//    public function transformForMerchantReport(Order $order): array
//    {
//        return [
//            'id' => $order->id,
//            'order_amount' => numberFormatPrecision($order->order_amount),
//            'delivery_amount' => numberFormatPrecision($order->delivery_amount),
//            'merchant_percentage' => numberFormatPrecision($order->merchant_percentage),
//            'merchant_revenue' => numberFormatPrecision($order->merchant_revenue),
//            'total_amount_after_deduct' => numberFormatPrecision($order->total_amount_after_deduct),
//            'total_amount' => numberFormatPrecision($order->total_amount),
//            'order_reference' => $order->order_reference,
//            'payment_type' => $order->payment_type,
//            'delivered_at' => $order->delivered_at
//        ];
//    }


}

