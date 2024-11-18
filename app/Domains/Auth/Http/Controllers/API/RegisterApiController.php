<?php

namespace App\Domains\Auth\Http\Controllers\API;
use App\Domains\Auth\Http\Transformers\UserTransformer;
use App\Domains\Auth\Services\UserService;
use App\Domains\FirebaseIntegration\FirebaseIntegration;
use App\Domains\Auth\Http\Requests\API\RegisterCaptainRequest;
use App\Domains\Merchant\Services\MerchantService;
use App\Domains\Customer\Services\CustomerService;
use App\Http\Controllers\APIBaseController;
use App\Domains\Auth\Http\Requests\API\RegisterMerchantRequest;

class RegisterApiController extends APIBaseController
{

    /**
     * @var UserService $userService
     */
    protected $userService;

    /**
     * @var MerchantService $merchantService
     */
    protected $merchantService;

    protected $customerService;
    /**
     * @var CustomerService $captainService
     */
    protected $captainService;

    /**
     * @var FirebaseIntegration $firebaseIntegration
     */
    protected $firebaseIntegration;

    /**
     * @param UserService $userService
     * @param MerchantService $merchantService
     * @param FirebaseIntegration $firebaseIntegration
     */
    public function __construct(UserService $userService, MerchantService $merchantService,CustomerService $customerService,
//                                FirebaseIntegration $firebaseIntegration
    )
    {
        $this->userService = $userService;
        $this->merchantService = $merchantService;
        $this->customerService = $customerService;
//        $this->firebaseIntegration = $firebaseIntegration;
    }

    /**
     * @OA\Post(
     * path="/api/auth/registerMerchant",
     * summary="Register Merchant",
     * description="",
     * operationId="registerMerchant",
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
     *       @OA\Parameter(
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
     *    description="pass authetication data in addition to merchant details",
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               required={"mobile_number", "name", "business_type_id", "city_id", "firebase_auth_token"},
     *              @OA\Property(property="mobile_number", type="string"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="latitude", type="string"),
     *              @OA\Property(property="longitude", type="string"),
     *              @OA\Property(property="business_type_id", type="integer"),
     *              @OA\Property(property="city_id", type="integer"),
     *              @OA\Property(property="firebase_auth_token", type="string"),
     *              @OA\Property(property="profile_pic", type="file"),
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
    public function registerMerchant(RegisterMerchantRequest $request): \Illuminate\Http\JsonResponse
    {
        try{
            $country_code = env('DEFAULT_COUNTRY_CODE','962');
            $fullNumber = $country_code.$request->input('mobile_number');
            $password = $request->input('password');


//            if($verifyResult = $this->firebaseIntegration->verifyToken($request->input('firebase_auth_token'),$fullNumber)){
                if(app()->environment(['local', 'testing'])){
//                    $verifyResult->verified = true;
                    $verifyResult = true;
                }
                if($verifyResult){
                    $this->merchantService->register($request->validated());

                    $login = $this->userService->authenticateUserMobile($country_code,$request->input('mobile_number'),$request->header('App-Version-Name'),$password);
                    if($login && $login->active === true){
                        return $this->successResponse($login);
                    }
                }
//            }
            return $this->successResponse([
                'completed' => false,
                'access_token' => '',
                'active' => false
            ]);
//        }
    }

        catch (\Exception $exception)
        {
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }

    /**
     * @OA\Post(
     * path="/api/auth/registerCaptain",
     * summary="Register Captain",
     * description="",
     * operationId="registerCaptain",
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
     *        @OA\Parameter(
     *         name="App-Version-Name",
     *         in="header",
     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
     *         @OA\Schema(
     *             type="string",
     *             default="hayat_delivery_captain_app"
     *         )
     *     ),
     * @OA\RequestBody(
     *    required=true,
     *    description="pass authetication data in addition to captain details",
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *               required={"mobile_number", "name", "vehicle_type_id","is_instant_delivery", "profile_pic","driving_license_card","car_id_card","firebase_auth_token"},
     *              @OA\Property(property="mobile_number", type="string"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="vehicle_type_id", type="integer"),
     *              @OA\Property(property="is_instant_delivery", type="boolean"),
     *              @OA\Property(property="firebase_auth_token", type="string"),
     *              @OA\Property(property="cities", type="string"),
     *              @OA\Property(property="profile_pic", type="file"),
     *              @OA\Property(property="driving_license_card", type="file"),
     *              @OA\Property(property="car_id_card", type="file"),
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
    public function registerCaptain(RegisterCaptainRequest $request): \Illuminate\Http\JsonResponse
    {
        try{
            $country_code = env('DEFAULT_COUNTRY_CODE','962');
            $fullNumber = $country_code.$request->input('mobile_number');

            if($verifyResult = $this->firebaseIntegration->verifyToken($request->input('firebase_auth_token'),$fullNumber)){

                if(app()->environment(['local', 'testing'])){
                    $verifyResult->verified = true;
                }

                if($verifyResult->verified){
                    $this->captainService->register($request->validated());
                    $login = $this->userService->authenticateUserMobile($country_code,$request->input('mobile_number'),$request->header('App-Version-Name'));
                    return $this->successResponse($login);
                }
            }
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
