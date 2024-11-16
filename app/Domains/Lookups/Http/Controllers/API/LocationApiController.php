<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Http\Transformers\AreaTransformer;
use App\Domains\Lookups\Http\Transformers\CityTransformer;
use App\Domains\Lookups\Http\Transformers\CountryTransformer;
use App\Domains\Lookups\Services\AreaService;
use App\Domains\Lookups\Services\CityService;
use App\Domains\Lookups\Services\CountryService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

/**
 * Class LocationApiController
 */
class LocationApiController extends APIBaseController
{
    /**
     * @var $countryService
     */
    protected $countryService;

    /**
     * @var $cityService
     */
    protected $cityService;
    protected $areaService;

    /**
     * @param CountryService $countryService
     * @param CityService $cityService
     */
    public function __construct(CountryService $countryService, CityService $cityService,AreaService $areaService)
    {
        $this->countryService = $countryService;
        $this->cityService = $cityService;
        $this->areaService = $areaService;
    }


    public function getCountries(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->countryService->get()->transform(function ($country){
                return (new CountryTransformer)->transform($country);
            }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }


    public function getCities(Request $request): \Illuminate\Http\JsonResponse
    {

        try{
            return $this->successResponse($this->cityService
                ->where('country_id', $request->input('country_id'))
                ->get()->transform(function ($city){
                    return (new CityTransformer)->transform($city);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
    public function getAreas(Request $request): \Illuminate\Http\JsonResponse
    {

        try{
            return $this->successResponse($this->areaService
                ->where('city_id', $request->input('city_id'))
                ->get()->transform(function ($area){
                    return (new AreaTransformer())->transform($area);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
