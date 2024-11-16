<?php

namespace App\Domains\Auth\Http\Controllers\API;

use App\Domains\Auth\Http\Requests\API\MobileAuthenticateRequest;
use App\Domains\Auth\Http\Transformers\UserTransformer;
use App\Domains\Auth\Services\UserService;
use App\Domains\FirebaseIntegration\FirebaseIntegration;
use App\Domains\Merchant\Http\Transformers\MerchantTransformer;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class LoginApiController extends APIBaseController
{

    /**
     * @var UserService $userService
     */
    protected $userService;



    /**
     * @param UserService $userService
     * @param FirebaseIntegration $firebaseIntegration
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Post(
     * path="/api/auth/authenticate",
     * summary="Authentication - Login Using Mobile",
     * description="",
     * operationId="authenticate",
     * tags={"Auth"},
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
     *         @OA\Schema(
     *             type="string",
     *             default="en"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="App-Version-Name",
     *         in="header",
     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
     *         @OA\Schema(
     *             type="string",
     *             default="hayat_delivery_merchant_app"
     *         )
     *     ),
     * @OA\RequestBody(
     *    required=true,
     *    description="pass authetication data",
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               required={"mobile_number", "firebase_auth_token"},
     *              @OA\Property(property="country_code", type="string"),
     *              @OA\Property(property="mobile_number", type="string"),
     *              @OA\Property(property="firebase_auth_token", type="string")
     *           ),
     *       )
     * ),
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
    public function mobileAuthenticate(MobileAuthenticateRequest $request)
    {
        $request->validated();//validate before complete

        $country_code =$request->input('country_code')?? env('DEFAULT_COUNTRY_CODE','962');
        $fullNumber = $country_code.$request->input('mobile_number');
        $password = $request->input('password');

        try{
//            if($verifyResult = $this->firebaseIntegration->verifyToken($request->input('firebase_auth_token'),$fullNumber)){
                if(app()->environment(['local', 'testing'])){
                    $verifyResult = true;
                }
                if($verifyResult){
                    $login = $this->userService->authenticateUserMobile($country_code,$request->input('mobile_number'),$request->header('App-Version-Name'),$password);
                    if(isset($login->show_not_merchant) && $login->show_not_merchant){
                        return $this->inputValidationErrorResponse(__('You cannot login using the merchant application'));
                    }
                    if(isset($login->show_not_captain) && $login->show_not_captain){
                        return $this->inputValidationErrorResponse(__('You cannot login using the captain application'));
                    }
                    if(isset($login->show_not_customer) && $login->show_not_customer){
                        return $this->inputValidationErrorResponse(__('You cannot login using the customer application'));
                    }
                    if($login){
                        return $this->successResponse($login);
                    }
                }
//            }
            return $this->successResponse([
                'completed' => false,
                'access_token' => '',
                'active' => false
            ]);

        }
        catch (\Exception $exception)
        {
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
