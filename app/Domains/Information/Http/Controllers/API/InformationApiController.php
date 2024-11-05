<?php

namespace App\Domains\Information\Http\Controllers\API;

use App\Domains\Information\Services\InformationService;
use App\Domains\Information\Http\Transformers\InformationTransformer;
use App\Domains\Lookups\Services\BusinessTypeService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;


class InformationApiController extends APIBaseController
{

    /**
     * @var BusinessTypeService $businessTypeService
     */
    private $informationService;

    /**
     * @param InformationService $informationService
     */
    public function __construct(InformationService $informationService)
    {
        $this->informationService = $informationService;
    }

    /**
     * @OA\Get(
     * path="/api/lookups/getInformation",
     * summary="Get Information",
     * description="",
     * operationId="getInformation",
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
    public function getInformation(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->informationService
                ->get()
                ->transform(function ($information){
                    return (new InformationTransformer())->transform($information);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
