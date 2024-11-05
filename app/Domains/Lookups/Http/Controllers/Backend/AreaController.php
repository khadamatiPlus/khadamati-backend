<?php

namespace App\Domains\Lookups\Http\Controllers\Backend;

use App\Domains\Lookups\Http\Requests\Backend\AreaRequest;
use App\Domains\Lookups\Models\Area;
use App\Domains\Lookups\Services\AreaService;
use App\Domains\Lookups\Services\CityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    private CityService $cityService;
    private AreaService $areaService;

    public function __construct(AreaService $areaService,CityService $cityService)
    {
        $this->areaService = $areaService;
        $this->cityService = $cityService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.lookups.area.index');
    }
    public function create()
    {
        $cities = $this->cityService->select(['id','name'])->get();
        return view('backend.lookups.area.create')
            ->withCities($cities);
    }

    public function store(AreaRequest $request)
    {
        $this->areaService->store($request->validated());
        return redirect()->route('admin.lookups.area.index')->withFlashSuccess(__('The Area was successfully added'));
    }

    /**
     * @param Area $area
     * @return mixed
     */
    public function edit(Area $area)
    {
        $cities = $this->cityService->select(['id','name'])->get();
        return view('backend.lookups.area.edit')
            ->withArea($area)
            ->withCities($cities);
    }

    public function update(AreaRequest $request, $area)
    {
        $this->areaService->update($area, $request->validated());

        return redirect()->back()->withFlashSuccess(__('The Area was successfully updated'));
    }

    /**
     * @param $area
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function destroy($area)
    {
        $this->areaService->destroy($area);
        return redirect()->back()->withFlashSuccess(__('The Area was successfully deleted.'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByCityId(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->areaService
            ->where('city_id', $request->input('city_id'))
            ->select(['id','name'])->get()]);
    }
}
