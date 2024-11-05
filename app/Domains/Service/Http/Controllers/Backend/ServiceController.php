<?php

namespace App\Domains\Service\Http\Controllers\Backend;

use App\Domains\Lookups\Models\Category;
use App\Domains\Lookups\Services\CategoryService;
use App\Domains\Lookups\Services\CountryService;
use App\Domains\Merchant\Services\MerchantService;
use App\Domains\Service\Http\Requests\Backend\ServiceRequest;
use App\Domains\Service\Models\Service;
use App\Domains\Service\Services\ServiceService;
use App\Domains\Lookups\Services\CityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    private ServiceService $serviceService;
    private CategoryService $categoryService;
    private CountryService $countryService;
    private MerchantService $merchantService;


    public function __construct(ServiceService $serviceService,CategoryService $categoryService,CountryService $countryService,MerchantService $merchantService)
    {
        $this->serviceService = $serviceService;
        $this->countryService = $countryService;
        $this->categoryService = $categoryService;
        $this->merchantService = $merchantService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.service.index');
    }
    public function create()
    {
        $countries = $this->countryService->select(['id','name'])->get();
        $categories = $this->categoryService->select(['id','name'])->get();
        $merchants = $this->merchantService->select(['id','name'])->get();
        return view('backend.service.create')
            ->withCountries($countries)
            ->withCategories($categories)
            ->withMerchants($merchants);
    }

    public function store(ServiceRequest $request)
    {
        $this->serviceService->store($request->validated());
        return redirect()->route('admin.service.index')->withFlashSuccess(__('The Service was successfully added'));
    }

    public function edit(Service $service)
    {
        $countries = $this->countryService->select(['id','name'])->get();
        $categories = $this->categoryService->select(['id','name'])->get();
        $merchants = $this->merchantService->select(['id','name'])->get();
        return view('backend.service.edit')
            ->withService($service)
            ->withCountries($countries)
            ->withCategories($categories)
            ->withMerchants($merchants);
    }

    public function update(ServiceRequest $request, $service)
    {
        $this->serviceService->update($service, $request->validated());
        return redirect()->back()->withFlashSuccess(__('The Service was successfully updated'));
    }

    /**
     * @param $area
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($area)
    {
        $this->serviceService->destroy($area);
        return redirect()->back()->withFlashSuccess(__('The Service was successfully deleted.'));
    }

}
