<?php

namespace App\Domains\Delivery\Http\Controllers\API;
use App\Domains\Delivery\Http\Requests\API\ShowOrderRequest;
use App\Domains\Delivery\Http\Requests\API\StoreOrderAsMerchantRequest;
use App\Domains\Delivery\Http\Transformers\OrderTransformer;
use App\Domains\Delivery\Http\Transformers\RecentTransformer;
use App\Domains\Delivery\Services\OrderService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class OrderApiController extends APIBaseController
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
     * @OA\Post(
     * path="/api/delivery/order/storeOrderAsMerchant",
     * operationId="storeOrderAsMerchant",
     * tags={"Delivery - Merchant"},
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
     *       @OA\MediaType(
     *           mediaType="multipart/form-data",
     *           @OA\Schema(
     *              required={"delivery_destination", "city_id", "vehicle_type_id","latitude","longitude","is_instant_delivery","order_amount","delivery_amount","customer_phone"},
     *              @OA\Property(property="city_id", type="integer"),
     *              @OA\Property(property="vehicle_type_id", type="integer"),
     *              @OA\Property(property="delivery_destination", type="string"),
     *              @OA\Property(property="notes", type="string"),
     *              @OA\Property(property="latitude", type="string"),
     *              @OA\Property(property="longitude", type="string"),
     *              @OA\Property(property="order_amount", type="string"),
     *              @OA\Property(property="delivery_amount", type="string"),
     *              @OA\Property(property="customer_phone", type="string"),
     *              @OA\Property(property="is_instant_delivery", type="boolean"),
     *              @OA\Property(property="latitude_to", type="string"),
     *              @OA\Property(property="longitude_to", type="string"),
     *              @OA\Property(property="voice_record", type="file"),

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
    public function storeOrderAsMerchant(StoreOrderAsMerchantRequest $request): \Illuminate\Http\JsonResponse
    {
        $order = $this->orderService->addMerchantOrder($request->validated());
        \Log::info('new333');
        return $this->successResponse([
                'order_saved' => $order != false,
                'order_id' => $order->id ?? 0
            ]);

    }




    /**
     * @OA\Get(
     * path="/api/delivery/order/orderList",
     * operationId="listOrders",
     * tags={"Delivery - Merchant"},
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
        if(!empty($request->input('status')))
        {
            $status = [$request->input('status')];
        }
        else{
            $status = [];
        }
        return $this->successResponse($this->orderService
            ->getMerchantOrders($status)
            ->paginate(3)
            ->getCollection()
            ->transform(function ($recent){
                return (new OrderTransformer)->transform($recent);
            }));
    }

//    /**
//     * @OA\Post(
//     * path="/api/delivery/order/merchantAction",
//     * operationId="merchantAction",
//     * tags={"Delivery - Merchant"},
//     *     @OA\Parameter(
//     *         name="Accept-Language",
//     *         in="header",
//     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
//     *         @OA\Schema(
//     *             type="string",
//     *             default="en"
//     *         )
//     *     ),
//     * @OA\RequestBody(
//     *    required=true,
//     *       @OA\MediaType(
//     *           mediaType="multipart/form-data",
//     *           @OA\Schema(
//     *              required={"order_id", "action_id"},
//     *              @OA\Property(property="order_id", type="integer"),
//     *              @OA\Property(property="action_id", type="integer"),
//     *           ),
//     *       )
//     * ),
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
//    public function merchantAction(OrderActionByMerchantRequest $request): \Illuminate\Http\JsonResponse
//    {
//        return $this->successResponse($this->recentService->merchantAction($request->validated()));
//    }
    /**
     * @OA\Get(
     * path="/api/delivery/order/show",
     * operationId="showOrder",
     * tags={"Hayat Delivery App"},
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
     *          name="order_id",
     *          description="orderId to filter order by orderId",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
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
    public function show(ShowOrderRequest $request): \Illuminate\Http\JsonResponse
    {
        if(auth()->user()->merchant) {
            $order = $this->orderService->getMerchantOrders(null, $request->input('order_id'))->first();
        }
        if(auth()->user()->captain) {
            $order = $this->orderService->getCaptainOrders(null, $request->input('order_id'))->first();
        }
        return $this->successResponse(!empty($order)?(new OrderTransformer)->transform($order):null);
    }

}
