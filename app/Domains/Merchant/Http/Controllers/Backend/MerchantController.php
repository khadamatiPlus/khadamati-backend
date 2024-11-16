<?php
namespace App\Domains\Merchant\Http\Controllers\Backend;
use App\Domains\Lookups\Services\AreaService;
use App\Domains\Lookups\Services\BusinessTypeService;
use App\Domains\Lookups\Services\CityService;
use App\Domains\Lookups\Services\CountryService;
use App\Domains\Merchant\Http\Requests\Backend\MerchantRequest;
use App\Domains\Merchant\Models\Merchant;
use App\Domains\Merchant\Services\MerchantService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MerchantController extends Controller
{
    private MerchantService $merchantService;
    private CountryService $countryService;
    private CityService $cityService;
    private AreaService $areaService;

    /**
     * @param MerchantService $merchantService
     */
    public function __construct(MerchantService $merchantService,CountryService $countryService,CityService $cityService,AreaService $areaService )
    {
        $this->merchantService = $merchantService;
        $this->countryService = $countryService;
        $this->cityService = $cityService;
        $this->areaService = $areaService;
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
        $countries = $this->countryService->select(['id','name'])->get();
        return view('backend.merchant.create')
            ->withCountries($countries);
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
        $countries = $this->countryService->select(['id','name'])->get();
        $cities = $this->cityService->where('country_id',$merchant->country_id)->select(['id','name'])->get();
        $areas = $this->areaService->where('city_id',$merchant->city_id)->select(['id','name'])->get();

        return view('backend.merchant.edit')
            ->withMerchant($merchant)
            ->withCountries($countries)
            ->withCities($cities)
            ->withAreas($areas);
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
    public function getCities($id){
        $cities=DB::table('cities')->where('country_id',$id)
            ->pluck('name','id');
        return json_encode($cities);
    }
    public function getAreas($id){
        $areas=DB::table('areas')->where('city_id',$id)
            ->pluck('name','id');
        return json_encode($areas);
    }
}
