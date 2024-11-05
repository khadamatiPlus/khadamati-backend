<?php

namespace App\Domains\Auth\Http\Controllers\API;

use App\Domains\Auth\Http\Requests\API\MerchantBranchAccessActivationRequest;
use App\Domains\Auth\Http\Transformers\UserTransformer;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class UserManagementApiController extends APIBaseController
{

    /**
     * @var UserService $userService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }



//    /**
//     * @OA\Get(
//     * path="/api/auth/checkSession",
//     * operationId="getcheckSession",
//     * tags={"Auth"},
//     *     @OA\Parameter(
//     *         name="Accept-Language",
//     *         in="header",
//     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
//     *         @OA\Schema(
//     *             type="string",
//     *             default="en"
//     *         )
//     *     ),
//     * security={{"bearerAuth":{}}},
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
//
//    public function checkSession(){
//        return $this->successResponse(['valid' => true]);
//    }
////
//    /**
//     * @OA\Get(
//     * path="/api/auth/checkAuthEnabled",
//     * operationId="checkAuthEnabled",
//     * tags={"Auth"},
//     *     @OA\Parameter(
//     *         name="Accept-Language",
//     *         in="header",
//     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
//     *         @OA\Schema(
//     *             type="string",
//     *             default="en"
//     *         )
//     *     ),
//     * security={{"bearerAuth":{}}},
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
//
//    public function checkAuthEnabled(){
//        return $this->successResponse(['enabled' => env('OTP_AUTH_ENABLED')]);
//    }
}
