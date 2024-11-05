<?php

namespace App\Domains\Customer\Http\Controllers\Backend;

use App\Domains\Captain\Models\CaptainWallet;
use App\Domains\Captain\Models\CaptainWalletTransaction;
use App\Domains\Lookups\Services\CityService;
use App\Domains\Lookups\Services\VehicleTypeService;
use App\Domains\Customer\Http\Requests\Backend\CustomerRequest;
use App\Domains\Customer\Models\Customer;
use App\Domains\Customer\Services\CustomerService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    private CustomerService $customerService;
    private CityService $cityService;



    public function __construct(CustomerService $customerService, CityService $cityService)
    {
        $this->customerService = $customerService;
        $this->cityService = $cityService;

    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.customer.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $cities = $this->cityService->select((['id','name']))->get();
        return view('backend.customer.create')
            ->withCities($cities);

    }

    /**
     * @param CustomerRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(CustomerRequest $request)
    {
        $this->customerService->register($request->validated());

        return redirect()->route('admin.customer.index')->withFlashSuccess(__('The Customer was successfully added'));
    }


    public function edit(Customer $customer)
    {
        $cities = $this->cityService->select((['id','name']))->get();
        return view('backend.customer.edit')
            ->withCustomer($customer);
    }


    public function update(CustomerRequest $request, $customer)
    {
        $this->customerService->update($customer, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Customer was successfully updated'));
    }

    /**
     * @param $captain
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($captain)
    {
        $this->customerService->destroy($captain);
        return redirect()->back()->withFlashSuccess(__('The Customer was successfully deleted.'));
    }

    /**
     * @param Request $request
     * @return void
     */
    public function updateStatus(Request $request)
    {
        $this->customerService->updateStatus($request);
        $customer = Customer::query()->findOrFail($request->input('customerId'));
        return response()->json(true);
    }
    public function show(Customer $customer)
    {
        return view('backend.customer.show')
            ->withCustomer($customer);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function UpdateIsPausedStatus(Request $request)
    {
        $this->captainService->UpdateIsPausedStatus($request);
        //$captain = Captain::query()->findOrFail($request->input('captainId'));
        return response()->json(true);
    }
    public function updatePercentage(Request $request)
    {
        $percentage=$request->input('percentage');
        $captainId=$request->input('captainId');
        DB::table('captains')
            ->where('id', '=', $captainId)
            ->update([
                'percentage' => $percentage
            ]);
        return   redirect()->back()->withFlashSuccess(__('The Percentage was successfully updated'));
    }
    public function showCaptainWallet(Captain $captain)
    {
        $wallet=CaptainWallet::query()->where('captain_id',$captain->id)->first();
        return view('backend.captain.wallet',compact('wallet'))
            ->withCaptain($captain);
    }


    public function addAmount(Request $request)
    {
        $captainId = $request->input('captainId'); // Get the authenticated user
        $amount = $request->input('amount');
        // Add the amount to the user's wallet
        $wallet = CaptainWallet::updateOrCreate(
            ['captain_id' => $captainId],
            ['available_balance' => \DB::raw("available_balance + $amount")]
        );

        // Record the transaction in wallet_transactions table
        $transaction = CaptainWalletTransaction::create([
            'captain_wallet_id' => $wallet->id,
            'amount' => $amount,
            'type' => 'deposit', // Assuming it's a deposit
        ]);
        return   redirect()->back()->withFlashSuccess(__('Amount added successfully'));

//        return response()->json(['message' => 'Amount added successfully', 'wallet' => $wallet, 'transaction' => $transaction]);
    }
}
