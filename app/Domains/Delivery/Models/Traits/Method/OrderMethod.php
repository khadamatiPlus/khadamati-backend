<?php

namespace App\Domains\Delivery\Models\Traits\Method;

use App\Enums\Core\OrderActions;
use App\Enums\Core\OrderStatuses;

/**
 * Created by Omar
 * Author: Vibes Solutions
 * On: 3/29/2022
 * Class: OrderMethod.php
 */
trait OrderMethod
{
    public function calculateForCustomer()
    {
        $this->refresh();
        $amount = 0.0;
        $this->orderItems->each(function ($orderItem)use(&$amount){
            $orderItem->calculatePrices();
            $orderItem->refresh();
            $amount = $amount + $orderItem->total_price;
        });
        $this->delivery_amount = $this->calculateDeliveryAmount();

        $this->order_amount = $amount;
        $this->total_amount = $amount + $this->delivery_amount;
        \Log::info('Total Price: '. $this->total_amount);


        /*
         * Merchant revenue calculation
         */
        //TODO calculate if internal or external captain
        /*
         * App revenue calculation
         */
        //TODO calculate if internal or external captain


        $this->update();
        $this->refresh();
    }

    /**
     * @return float|int
     */
    public function calculateDistance()
    {
        $this->refresh();
        return 100 * manhattanDistance($this->merchantBranch->latitude,$this->merchantBranch->longitude,$this->customerAddress->latitude,$this->customerAddress->longitude);
    }

    /**
     * @return mixed|string
     */
    public function calculateDeliveryAmount()
    {
        $this->refresh();

        $init_charge_internal = getSettingByKey('init_charge_internal') / 100;
        $kilo_internal_price = getSettingByKey('kilo_internal_price') / 100;
        return numberFormatPrecision($init_charge_internal+($kilo_internal_price*$this->calculateDistance()));
    }

    public function changeStatus($status)
    {
        try{
            $this->status = OrderStatuses::isValidValue($status)?$status:$this->status;
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

//    public function acceptByMerchant()
//    {
//        try{
//            if($this->payment_type == PaymentTypes::CASH
//                || ($this->payment_type == PaymentTypes::ONLINE && ($this->payment_status == '000.000.000' || $this->payment_status == 'pay.gatewayCode.APPROVED' || $this->payment_status == '000.100.112')))
//            {
//                $this->merchant_accepted_at = now();
//                $this->captain_requested_at = now();
//            }
//            $this->update();
//            $this->refresh();
//        }
//        catch (\Exception $exception){
//            report($exception);
//        }
//
//        return $this;
//    }

    public function rejectByMerchant()
    {
        try{
            $this->merchant_rejected_at = now();
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

    public function acceptByCaptain($captain_id)
    {
        try{
            $this->captain_accepted_at = now();
            $this->captain_id = $captain_id;
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

    public function confirmCaptainArrival()
    {
        try{
            $this->captain_arrived_at = now();
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

    public function confirmCaptainPickup()
    {
        try{
            $this->captain_picked_order_at = now();
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

    public function captainStartTripToCustomer()
    {
        try{
            $this->captain_started_trip_at = now();
            $this->captain_on_the_way_at = now();
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

    public function confirmCaptainArriveCustomer()
    {
        try{
            $this->delivered_at = now();
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

    public function confirmCustomerPickup()
    {
        try{
            $this->customer_picked_order_at = now();
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

    public function storeCustomerLocation()
    {
        try{
            $this->latitude = $this->customerAddress->latitude;
            $this->longitude = $this->customerAddress->longitude;
            $this->update();
            $this->refresh();
        }
        catch (\Exception $exception)
        {
            report($exception);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getPendingMerchantActions(): array
    {
        if(empty($this->merchant_accepted_at)
            && empty($this->merchant_rejected_at)
            && $this->status == OrderStatuses::NEW_ORDER)
        {
            if($this->payment_type == PaymentTypes::CASH
                || ($this->payment_type == PaymentTypes::ONLINE && ($this->payment_status == '000.000.000' || $this->payment_status == 'pay.gatewayCode.APPROVED' || $this->payment_status == '000.100.112'))){
                return [OrderActions::MERCHANT_ACCEPT_ORDER,OrderActions::MERCHANT_REJECT_ORDER];
            }
        }

        if(empty($this->captain_arrived_at)
            && !empty($this->captain_accepted_at)
            && $this->status == OrderStatuses::CAPTAIN_ACCEPTED)
        {
            return [OrderActions::MERCHANT_CONFIRM_CAPTAIN_ARRIVAL];
        }

        return [];
    }
}
