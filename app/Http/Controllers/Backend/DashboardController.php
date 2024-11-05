<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Delivery\Services\OrderService;
use App\Domains\Order\Models\Order;
use App\Enums\Core\OrderStatuses;

/**
 * Class DashboardController.
 */
class DashboardController
{
    public function __construct(OrderService $orderService){
        $this->orderService=$orderService;
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $totalOfOrders=$this->orderService->count();
        $totalPriceOfOrders=$this->orderService->sum('order_amount');
        $totalOfRequestedOrders=$this->orderService->where('status','=',OrderStatuses::NEW_ORDER)->count();
        $totalOfAcceptedOrders=$this->orderService->where('status','=',OrderStatuses::CAPTAIN_ACCEPTED)->count();
        $totalOfDeliveredOrders=$this->orderService->where('status','=',OrderStatuses::DELIVERED)->count();
        $totalOfCanceledOrders=$this->orderService->where('status','=',OrderStatuses::CAPTAIN_CANCELLED)->count();
        return view('backend.dashboard',compact('totalOfOrders','totalPriceOfOrders','totalOfRequestedOrders','totalOfAcceptedOrders','totalOfDeliveredOrders','totalOfCanceledOrders'));
    }
}
