<?php

namespace App\Domains\Delivery\Http\Controllers\API;

use App\Domains\Delivery\Http\Transformers\OrderTransformer;
use App\Domains\Delivery\Services\OrderService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class CaptainOrdersApiController extends APIBaseController
{
    private OrderService $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }



    /**
     * @OA\Get(
     * path="/api/captain/delivery/order/list",
     * operationId="listCaptainOrders",
     * tags={"Delivery - Captain"},
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
     *         @OA\Schema(
     *             type="string",
     *             default="en"
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="status",
     *          description="status to filter order by status",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="page for paging data",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default="1"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="from_date",
     *          description="date range from",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="date",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="to_date",
     *          description="date range to",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="date",
     *          )
     *      ),
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
    public function list(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->successResponse($this->orderService
            ->getCaptainOrders($request->input('from_date'),$request->input('to_date'))
            ->paginate(3)
            ->getCollection()
            ->transform(function ($order){
                return (new OrderTransformer)->transform($order);
            }));
    }


}
