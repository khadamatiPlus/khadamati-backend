<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Http\Transformers\VehicleTypeTransformer;
use App\Domains\Lookups\Services\VehicleTypeService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class VehicleTypeApiController extends APIBaseController
{

    /**
     * @var VehicleTypeService $vehicleTypeService
     */
    private $vehicleTypeService;

    /**
     * @param VehicleTypeService $vehicleTypeService
     */
    public function __construct(VehicleTypeService $vehicleTypeService)
    {
        $this->vehicleTypeService = $vehicleTypeService;
    }

    /**
     * @OA\Get(
     * path="/api/lookups/getVehicleTypes",
     * summary="Get VehicleTypes",
     * description="",
     * operationId="getVehicleTypes",
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
    public function getVehicleTypes(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->vehicleTypeService
                ->get()
                ->transform(function ($language){
                    return (new VehicleTypeTransformer())->transform($language);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
