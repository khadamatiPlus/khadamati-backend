<?php
/**
 * Created by Omar
 * Author: Vibes Solutions
 * On: 3/30/2022
 * Class: OrderController.php
 */


namespace App\Domains\Delivery\Http\Controllers\Backend;

use App\Domains\Delivery\Http\Requests\API\OrderRequest;
use App\Domains\Delivery\Models\Order;
use App\Domains\Delivery\Models\Recent;
use App\Domains\Lookups\Models\Category;
use App\Domains\Lookups\Services\CategoryService;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.order.index');
    }
    public function show($id){
        $order = Order::query()->where('id','=',$id)->first();
        return view('backend.order.includes.order-details',compact('order'));
    }
}
