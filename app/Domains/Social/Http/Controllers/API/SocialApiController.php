<?php

namespace App\Domains\Social\Http\Controllers\API;

use App\Domains\Social\Services\SocialService;
use App\Domains\Social\Http\Transformers\SocialTransformer;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;


class SocialApiController extends APIBaseController
{


    /**
     * @param SocialService $socialService
     */
    public function __construct(SocialService $socialService)
    {
        $this->socialService = $socialService;
    }

    /**
     * @OA\Get(
     * path="/api/lookups/getSocial",
     * summary="Get Social",
     * description="",
     * operationId="getSocial",
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
    public function getSocial(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->socialService
                ->get()
                ->transform(function ($information){
                    return (new SocialTransformer())->transform($information);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
