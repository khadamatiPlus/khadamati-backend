<?php

namespace App\Domains\Lookups\Http\Controllers\Backend;

use App\Domains\Lookups\Http\Requests\Backend\CityRequest;
use App\Domains\Lookups\Models\City;
use App\Domains\Lookups\Services\CityService;
use App\Domains\Lookups\Services\CountryService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private CityService $cityService;
    private CountryService $countryService;

    /**
     * @param CityService $cityService
     * @param CountryService $countryService
     */
    public function __construct(CityService $cityService,CountryService $countryService)
    {
        $this->cityService = $cityService;
        $this->countryService = $countryService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.lookups.city.index');
    }
    public function create()
    {
        $countries = $this->countryService->select(['id','name'])->get();
        //$country = $this->countryService->where('deleted_at' ,null,'<>')->all();
        //echo json_encode($country);exit();
        return view('backend.lookups.city.create')
            ->withCountries($countries);
    }

    /**
     * @param CityRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(CityRequest $request)
    {
        $this->cityService->store($request->validated());

        return redirect()->route('admin.lookups.city.index')->withFlashSuccess(__('The City was successfully added'));
    }

    /**
     * @param City $city
     * @return mixed
     */
    public function edit(City $city)
    {
        $countries = $this->countryService->select(['id','name'])->get();
        //$country = $this->countryService->where('deleted_at' ,null,'<>')->all();
        //echo json_encode($country);exit();
        return view('backend.lookups.city.edit')
            ->withCity($city)
            ->withCountries($countries);
    }

    /**
     * @param CityRequest $request
     * @param $city
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(CityRequest $request, $city)
    {
        $this->cityService->update($city, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The City was successfully updated'));
    }

    /**
     * @param $city
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($city)
    {
        $this->cityService->destroy($city);
        return redirect()->back()->withFlashSuccess(__('The City was successfully deleted.'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCountryId(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->cityService
            ->where('country_id', $request->input('country_id'))
            ->select(['id','name'])->get()]);
    }
}
