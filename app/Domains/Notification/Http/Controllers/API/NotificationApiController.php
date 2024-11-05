<?php

namespace App\Domains\Notification\Http\Controllers\API;
use App\Domains\Notification\Http\Transformers\NotificationTransformer;
use App\Domains\Notification\Services\NotificationService;
use App\Http\Controllers\APIBaseController;
use Illuminate\Http\Request;

class NotificationApiController extends APIBaseController
{

    /**
     * @var NotificationService $notificationService
     */
    private $notificationService;

    /**
     * @param NotificationService $notificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @OA\Get(
     * path="/api/notifications/getNotifications",
     * summary="Get Notifications",
     * description="",
     * operationId="getNotifications",
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
     *          name="page",
     *          description="page to paginate data",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *    security={{"bearerAuth":{}}},
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
    public function getNotifications(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->successResponse($this->notificationService
                ->applyQueryFilters()
                ->paginate(10,['*'],'page',$request->input('page') ?? 1)
                ->getCollection()
                ->transform(function ($notifications) {
                    return (new NotificationTransformer)->transform($notifications);
                }));
        } catch (\Exception $exception) {
            report($exception);
            return $this->internalServerErrorResponse($exception->getMessage());
        }
    }
}
