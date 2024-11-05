<?php

namespace App\Domains\Merchant\Http\Controllers\API;

use App\Domains\Merchant\Http\Requests\API\ListMerchantBranchRequest;
use App\Domains\Merchant\Http\Requests\API\UpdateMerchantRequest;
use App\Domains\Merchant\Http\Transformers\MerchantTransformer;
use App\Domains\Merchant\Services\MerchantService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class MerchantApiController extends APIBaseController
{

    private MerchantService $merchantService;

    /**
     * @param MerchantService $merchantService
     */
    public function __construct(MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
    }

    /**
     * @OA\Post(
     * path="/api/merchant/update",
     * summary="Update Merchant Details",
     * description="",
     * operationId="updateMerchant",
     * tags={"Merchant"},
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
     *         @OA\Schema(
     *             type="string",
     *             default="en"
     *         )
     *     ),
     * @OA\RequestBody(
     *    required=true,
     *    description="pass authetication data in addition to merchant details",
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="latitude", type="string"),
     *              @OA\Property(property="longitude", type="string"),
     *              @OA\Property(property="business_type_id", type="city_id"),
     *              @OA\Property(property="city_id", type="integer"),
     *              @OA\Property(property="profile_pic", type="file"),
     *           ),
     *       )
     * ),
     * security={{"bearerAuth":{}}},
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
    public function update(UpdateMerchantRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse(
            (new MerchantTransformer)->transform($this->merchantService->update($request->user()->merchant_id,$request->validated()))
        );
    }


    /**
     * @OA\Get(
     * path="/api/merchant/profile",
     * summary="get Merchant Details",
     * description="",
     * operationId="getMerchant",
     * tags={"Merchant"},
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
     *         @OA\Schema(
     *             type="string",
     *             default="en"
     *         )
     *     ),
     * security={{"bearerAuth":{}}},
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
    public function profile()
    {

        $merchant = auth()->user()->merchant->where('profile_id',auth()->id())->firstOrFail();
        return $this->successResponse(
            (new MerchantTransformer)->transform($merchant)
        );
    }

}
