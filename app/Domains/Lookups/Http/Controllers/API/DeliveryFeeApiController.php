<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Http\Transformers\DeliveryFeeTransformer;
use App\Domains\Lookups\Services\DeliveryFeeService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class DeliveryFeeApiController extends APIBaseController
{

    /**
     * @var DeliveryFeeService $deliveryFeeService
     */
    private $deliveryFeeService;

    /**
     * @param DeliveryFeeService $deliveryFeeService
     */
    public function __construct(DeliveryFeeService $deliveryFeeService)
    {
        $this->deliveryFeeService = $deliveryFeeService;
    }

    /**
     * @OA\Get(
     * path="/api/lookups/getDeliveryFees",
     * summary="Get Delivery Fees",
     * description="",
     * operationId="getDeliveryFees",
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
    public function getDeliveryFees(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->deliveryFeeService
                ->get()
                ->transform(function ($deliveryFee){
                    return (new DeliveryFeeTransformer)->transform($deliveryFee);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
