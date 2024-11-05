<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Http\Transformers\CityTransformer;
use App\Domains\Lookups\Http\Transformers\CountryTransformer;
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

    /**
     * @param CountryService $countryService
     * @param CityService $cityService
     */
    public function __construct(CountryService $countryService, CityService $cityService)
    {
        $this->countryService = $countryService;
        $this->cityService = $cityService;
    }

//    /**
//     * @OA\Get(
//     * path="/api/lookups/getCountries",
//     * summary="Get Countries",
//     * description="",
//     * operationId="getCountries",
//     * tags={"Lookups"},
//     *     @OA\Parameter(
//     *         name="Accept-Language",
//     *         in="header",
//     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
//     *         @OA\Schema(
//     *             type="string",
//     *             default="en"
//     *         )
//     *     ),
//     * @OA\Response(
//     *    response=400,
//     *    description="input validation errors"
//     * ),
//     * @OA\Response(
//     *    response=500,
//     *    description="internal server error"
//     * ),
//     *     @OA\Response(
//     *    response=200,
//     *    description="success"
//     * )
//     * )
//     */
//    public function getCountries(Request $request): \Illuminate\Http\JsonResponse
//    {
//        try{
//            return $this->successResponse($this->countryService->get()->transform(function ($country){
//                return (new CountryTransformer)->transform($country);
//            }));
//        }
//        catch (\Exception $exception){
//            report($exception);
//            return $this->internalServerErrorResponse($exception->getMessage());
//        }
//    }

    /**
     * @OA\Get(
     * path="/api/lookups/getCities",
     * summary="Get Cities",
     * description="",
     * operationId="getCities",
     * tags={"Lookups"},
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
     *         @OA\Schema(
     *             type="string",
     *             default="en"
     *         )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="input validation errors"
     * ),
     * @OA\Response(
     *    response=500,
     *    description="internal server error"
     * ),
     *     @OA\Response(
     *    response=200,
     *    description="success"
     * )
     * )
     */
    public function getCities(Request $request): \Illuminate\Http\JsonResponse
    {

        try{
            return $this->successResponse($this->cityService
//                ->where('country_id', $request->input('country_id'))
                ->where('country_id', 2)
                ->get()->transform(function ($city){
                    return (new CityTransformer)->transform($city);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
