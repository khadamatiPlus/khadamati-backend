<?php

namespace App\Domains\Lookups\Http\Controllers\API;

use App\Domains\Lookups\Http\Transformers\UserTypeTransformer;
use App\Domains\Lookups\Services\UserTypeService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;


class UserTypeApiController extends APIBaseController
{

    /**
     * @var UserTypeService
     */
    private $userTypeService;

    /**
     * @param UserTypeService $userTypeService
     */
    public function __construct(UserTypeService $userTypeService)
    {
        $this->userTypeService = $userTypeService;
    }

    /**
     * @OA\Get(
     * path="/api/lookups/getUserTypes",
     * summary="Get User Types",
     * description="",
     * operationId="getUserTypes",
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
    public function getUserTypes(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            return $this->successResponse($this->userTypeService
                ->get()
                ->transform(function ($userType){
                    return (new UserTypeTransformer)->transform($userType);
                }));
        }
        catch (\Exception $exception){
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
