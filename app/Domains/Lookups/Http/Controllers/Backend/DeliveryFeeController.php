<?php

namespace App\Domains\Lookups\Http\Controllers\Backend;

use App\Domains\Lookups\Http\Requests\Backend\DeliveryFeeRequest;
use App\Domains\Lookups\Models\DeliveryFee;
use App\Domains\Lookups\Services\DeliveryFeeService;
use App\Http\Controllers\Controller;

class DeliveryFeeController extends Controller
{
    private DeliveryFeeService $deliveryFeeService;

    /**
     * @param DeliveryFeeService $deliveryFeeService
     */
    public function __construct(DeliveryFeeService $deliveryFeeService)
    {
        $this->deliveryFeeService = $deliveryFeeService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.lookups.delivery-fee.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.lookups.delivery-fee.create');
    }

    /**
     * @param DeliveryFeeRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(DeliveryFeeRequest $request)
    {
        $this->deliveryFeeService->store($request->validated());

        return redirect()->route('admin.lookups.deliveryFee.index')->withFlashSuccess(__('The Delivery Fee was successfully added'));
    }

    /**
     * @param VehicleType $vehicleType
     * @return mixed
     */
    public function edit(DeliveryFee $deliveryFee)
    {
        return view('backend.lookups.delivery-fee.edit')
            ->withDeliveryFee($deliveryFee);
    }

    /**
     * @param DeliveryFeeRequest $request
     * @param $deliveryFee
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(DeliveryFeeRequest $request, $deliveryFee)
    {
        $this->deliveryFeeService->update($deliveryFee, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Delivery Fee was successfully updated'));
    }

    /**
     * @param $deliveryFee
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($deliveryFee)
    {
        $this->deliveryFeeService->destroy($deliveryFee);
        return redirect()->back()->withFlashSuccess(__('The Delivery Fee was successfully deleted.'));
    }
}
