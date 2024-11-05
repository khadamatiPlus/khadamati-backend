<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Http\Transformers\BusinessTypeTransformer;
use App\Domains\Lookups\Services\BusinessTypeService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;


class BusinessTypeApiController extends APIBaseController
{

    /**
     * @var BusinessTypeService $businessTypeService
     */
    private $businessTypeService;

    /**
     * @param BusinessTypeService $businessTypeService
     */
    public function __construct(BusinessTypeService $businessTypeService)
    {
        $this->businessTypeService = $businessTypeService;
    }

    /**
     * @OA\Get(
     * path="/api/lookups/getBusinessTypes",
     * summary="Get Business Types",
     * description="",
     * operationId="getBusinessTypes",
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
    public function getBusinessTypes(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->businessTypeService
                ->get()
                ->transform(function ($language){
                    return (new BusinessTypeTransformer())->transform($language);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
