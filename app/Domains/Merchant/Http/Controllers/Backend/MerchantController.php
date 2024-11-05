<?php
namespace App\Domains\Merchant\Http\Controllers\Backend;
use App\Domains\Lookups\Services\BusinessTypeService;
use App\Domains\Lookups\Services\CityService;
use App\Domains\Merchant\Http\Requests\Backend\MerchantRequest;
use App\Domains\Merchant\Models\Merchant;
use App\Domains\Merchant\Services\MerchantService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    private MerchantService $merchantService;
    private CityService $cityService;

    /**
     * @param MerchantService $merchantService
     */
    public function __construct(MerchantService $merchantService,CityService $cityService)
    {
        $this->merchantService = $merchantService;
        $this->cityService = $cityService;
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.merchant.index');
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $cities = $this->cityService->select(['id','name'])->get();
        return view('backend.merchant.create')
            ->withCities($cities);
    }
    /**
     * @param merchantRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(MerchantRequest $request)
    {
        $this->merchantService->register($request->validated());
        return redirect()->route('admin.merchant.index')->withFlashSuccess(__('The Merchant was successfully added'));
    }
    /**
     * @param Merchant $merchant
     * @return mixed
     */
    public function edit(Merchant $merchant)
    {
        $cities = $this->cityService->select(['id','name'])->get();
        return view('backend.merchant.edit')
            ->withMerchant($merchant)
            ->withCities($cities);
    }
    /**
     * @param Merchant $item
     * @return mixed
     */
    public function show(Merchant $merchant)
    {
        return view('backend.merchant.show')
            ->withMerchant($merchant);
    }
    /**
     * @param MerchantRequest $request
     * @param $merchant
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(MerchantRequest $request, $merchant)
    {
        $this->merchantService->update($merchant, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Merchant was successfully updated'));
    }

    /**
     * @param $merchant
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($merchant)
    {
        $this->merchantService->destroy($merchant);
        return redirect()->back()->withFlashSuccess(__('The Merchant was successfully deleted.'));
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request)
    {
        $this->merchantService->updateStatus($request);
        return response()->json(true);
    }
}
