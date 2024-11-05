<?php

namespace App\Domains\Rating\Http\Controllers\API;

use App\Domains\Rating\Http\Requests\API\RatingRequest;
use App\Domains\Rating\Services\RatingService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class RatingApiController extends APIBaseController
{

    private RatingService $ratingService;

    /**
     * @param RatingService $ratingService
     */
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * @OA\Post(
     * path="/api/merchant/storeRating",
     * summary="Store Rating",
     * description="",
     * operationId="storeRating",
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
     *              @OA\Property(property="notes", type="string"),
     *              @OA\Property(property="captain_id", type="integer"),
     *              @OA\Property(property="rate", type="integer"),
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

    public function store(RatingRequest $request)
    {

        $rating = $this->ratingService->store($request->validated());

        return response()->json(['message' => 'Rating stored successfully', 'rating' => $rating], 200);
    }
}
