<?php

namespace App\Domains\Captain\Http\Controllers\API;

use App\Domains\Captain\Models\Captain;
use App\Domains\Captain\Services\CaptainService;
use App\Domains\Captain\Http\Requests\API\UpdateCaptainRequest;
use App\Domains\Captain\Http\Transformers\CaptainTransformer;
use App\Http\Controllers\APIBaseController;
use AWS\CRT\HTTP\Request;

class CaptainApiController extends APIBaseController
{

    private CaptainService $captainService;

    /**
     * @param CaptainService $captainService
     */
    public function __construct(CaptainService $captainService)
    {
        $this->captainService = $captainService;
    }

    /**
     * @OA\Post(
     * path="/api/captain/update",
     * summary="Update Captain Details",
     * description="",
     * operationId="updateCaptain",
     * tags={"Captain"},
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
     *    description="pass authetication data in addition to captain details",
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              @OA\Property(property="personal_photo", type="file"),
     *              @OA\Property(property="profile_pic", type="file"),
     *              @OA\Property(property="driving_license_card", type="file"),
     *              @OA\Property(property="car_id_card", type="file"),
     *              @OA\Property(property="vehicle_type_id", type="integer"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="cities", type="string"),
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
    public function update(UpdateCaptainRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse(
            (new CaptainTransformer)->transform($this->captainService->update($request->user()->captain_id,$request->validated()))
        );
    }
    /**
     * @OA\Get(
     * path="/api/captain/profile",
     * summary="get Captain Details",
     * description="",
     * operationId="getCaptain",
     * tags={"Captain"},
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

        $captain = auth()->user()->captain->where('profile_id',auth()->id())->firstOrFail();
        return $this->successResponse(
            (new CaptainTransformer)->transform($captain)
        );
    }

}
