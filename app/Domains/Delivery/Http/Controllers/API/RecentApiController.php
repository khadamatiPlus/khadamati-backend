<?php
//
//namespace App\Domains\Delivery\Http\Controllers\API;
//
//use App\Domains\Customer\Models\Customer;
//use App\Domains\Delivery\Http\Requests\API\CalculateDeliveryAmountRequest;
//use App\Domains\Delivery\Http\Requests\API\MarkAsCompletedRequest;
//use App\Domains\Delivery\Http\Requests\API\OrderRequest;
//use App\Domains\Delivery\Http\Requests\API\OrderActionByMerchantRequest;
//use App\Domains\Delivery\Http\Requests\API\ShowOrderRequest;
//use App\Domains\Delivery\Http\Requests\API\StoreDiscountOrderRequest;
//use App\Domains\Delivery\Http\Requests\API\StoreOrderAsCustomerRequest;
//use App\Domains\Delivery\Http\Transformers\OrderTransformer;
//use App\Domains\Delivery\Http\Transformers\RecentTransformer;
//use App\Domains\Delivery\Services\RecentService;
//use App\Domains\Merchant\Models\MerchantBranch;
//use App\Http\Controllers\APIBaseController;
//use Illuminate\Http\Request;
//
//class RecentApiController extends APIBaseController
//{
//    private RecentService $recentService;
//
//    /**
//     * @param RecentService $recentService
//     */
//    public function __construct(RecentService $recentService)
//    {
//        $this->recentService = $recentService;
//    }
//
//    /**
//     * @OA\Post(
//     * path="/api/delivery/order/storeOrderAsCustomer",
//     * operationId="storeOrderAsCustomer",
//     * tags={"Customer App"},
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
//     *              required={"customer_address_id", "payment_type", "order_items"},
//     *              @OA\Property(property="customer_address_id", type="integer"),
//     *              @OA\Property(property="payment_type", type="integer"),
//     *              @OA\Property(property="special_requests", type="string"),
//     *              @OA\Property(property="order_items", type="string"),
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
//    public function storeRecentAsCustomer(StoreOrderAsCustomerRequest $request): \Illuminate\Http\JsonResponse
//    {
//        $order = $this->orderService->addCustomerOrder($request->validated());
//        return $this->successResponse([
//                'order_saved' => $order != false,
//                'payment_checkout_id' => $order->payment_checkout_id ?? '',
//                'order_id' => $order->id ?? 0
//            ]);
//    }
//
//
//
//    /**
//     * @OA\Post(
//     * path="/api/delivery/recent/paymentStatus",
//     * operationId="paymentStatusRecent",
//     * tags={"Customer App"},
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
//     *              required={"recent_id", "transaction_id"},
//     *              @OA\Property(property="recent_id", type="integer"),
//     *              @OA\Property(property="transaction_id", type="string"),
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
//    public function paymentStatus(Request $request): \Illuminate\Http\JsonResponse
//    {
//        return $this->successResponse([
//            'recent' => (new RecentTransformer)->transform($this->recentService->paymentStatusCheck($request->input('recent_id'),$request->input('transaction_id')))
//        ]);
//
//    }
//    /**
//     * @OA\Get(
//     * path="/api/delivery/order/recentList",
//     * operationId="listOrders",
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
//     *      @OA\Parameter(
//     *          name="status",
//     *          description="status to filter order by status",
//     *          required=false,
//     *          in="query",
//     *          @OA\Schema(
//     *              type="integer",
//     *          )
//     *      ),
//     *      @OA\Parameter(
//     *          name="page",
//     *          description="page for paging data",
//     *          required=true,
//     *          in="query",
//     *          @OA\Schema(
//     *              type="integer",
//     *              default="1"
//     *          )
//     *      ),
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
//    public function list(Request $request): \Illuminate\Http\JsonResponse
//    {
//        if(!empty($request->input('status')))
//        {
//            $status = [$request->input('status')];
//        }
//        else{
//            $status = [];
//        }
//        return $this->successResponse($this->recentService
//            ->getMerchantOrders($status)
//            ->paginate(3)
//            ->getCollection()
//            ->transform(function ($recent){
//                return (new RecentTransformer)->transform($recent);
//            }));
//    }
//
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
//    /**
//     * @OA\Get(
//     * path="/api/delivery/order/show",
//     * operationId="showOrder",
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
//     *      @OA\Parameter(
//     *          name="order_id",
//     *          description="orderId to filter order by orderId",
//     *          required=true,
//     *          in="query",
//     *          @OA\Schema(
//     *              type="integer",
//     *          )
//     *      ),
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
//    public function show(ShowOrderRequest $request): \Illuminate\Http\JsonResponse
//    {
//        $order = $this->recentService->getMerchantOrders(null,$request->input('order_id'))->first();
//        return $this->successResponse(!empty($order)?(new RecentTransformer)->transform($order):null);
//    }
//    /**
//     * @OA\Get(
//     * path="/api/delivery/order/calculateDeliveryAmount",
//     * operationId="calculateDeliveryAmount",
//     * tags={"Customer App"},
//     *     @OA\Parameter(
//     *         name="Accept-Language",
//     *         in="header",
//     *         description="Set language parameter by RFC2616 <https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4>",
//     *         @OA\Schema(
//     *             type="string",
//     *             default="en"
//     *         )
//     *     ),
//     *     @OA\Parameter(
//     *         name="latitude",
//     *         in="query",
//     *         required=true,
//     *         description="set your current latitude",
//     *         @OA\Schema(
//     *             type="string",
//     *         )
//     *     ),
//     *     @OA\Parameter(
//     *         name="longitude",
//     *         in="query",
//     *         required=true,
//     *         description="set your current longitude",
//     *         @OA\Schema(
//     *             type="string",
//     *         )
//     *     ),
//     *      @OA\Parameter(
//     *          name="merchant_branch_id",
//     *          description="merchant branch id that you want to deliver the order from",
//     *          required=true,
//     *          in="query",
//     *          @OA\Schema(
//     *              type="integer",
//     *          )
//     *      ),
//     *           @OA\Parameter(
//     *          name="item_id",
//     *          description="item id that you want to deliver the order from",
//     *          required=true,
//     *          in="query",
//     *          @OA\Schema(
//     *              type="integer",
//     *          )
//     *      ),
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
//    public function calculateDeliveryAmount(CalculateDeliveryAmountRequest $request): \Illuminate\Http\JsonResponse
//    {
////        $customer = auth()->user()->customer->where('id',auth()->id())->firstOrFail();
//        $customer = Customer::query()->where('profile_id',$request->user()->id)->firstOrFail();
////        echo json_encode($customer);exit();
//        $merchantBranch = MerchantBranch::query()->findOrFail($request->merchant_branch_id);
//        if(100 * manhattanDistance($request->latitude,$request->longitude,$merchantBranch->latitude,$merchantBranch->longitude)<5) {
//
//            return $this->successResponse([
////            'distance' => $customer->calculateDistance($merchantBranch->latitude,$merchantBranch->longitude),
//                'success' => true,'message'=>'',
//                'distance' => 100 * manhattanDistance($request->latitude, $request->longitude, $merchantBranch->latitude, $merchantBranch->longitude),
//                'delivery_amount' => $customer->calculateDeliveryAmount($request->latitude, $request->longitude, $merchantBranch->latitude, $merchantBranch->longitude, $request->item_id)
//            ]);
//        }
//        else{
////            return response()->json(['success' => false,'message'=>'The distance more than 5 km '], 200, [], JSON_UNESCAPED_SLASHES) ;
//
//            return $this->successResponse([
////            'distance' => $customer->calculateDistance($merchantBranch->latitude,$merchantBranch->longitude),
//                'success' => false,
//                'message'=>'We are unable to deliver because your location is more than 5 kilometers from the branch.',
//            ]);
//
//
//        }
//    }
//    /**
//     * @OA\Post(
//     * path="/api/delivery/recent/storeDiscountOrder",
//     * operationId="storeDiscountOrder",
//     * tags={"Customer App"},
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
//     *              required={"merchant_branch_id", "pin_code","price","discount_id"},
//     *              @OA\Property(property="merchant_branch_id", type="integer"),
//     *              @OA\Property(property="pin_code", type="string"),
//     *              @OA\Property(property="price", type="string"),
//     *              @OA\Property(property="discount_id", type="string"),
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
//    public function storeDiscountOrder(StoreDiscountOrderRequest $request): \Illuminate\Http\JsonResponse
//    {
//        return $this->successResponse($this->recentService->storeDiscountOrder($request->validated()));
//    }
//
//
//}
