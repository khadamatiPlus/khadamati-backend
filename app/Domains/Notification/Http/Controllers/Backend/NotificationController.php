<?php
namespace App\Domains\Notification\Http\Controllers\Backend;
use App\Domains\Delivery\Http\Transformers\OrderTransformer;
use App\Domains\FirebaseIntegration\FirebaseIntegration;
use App\Domains\Notification\Http\Requests\Backend\NotificationRequest;
use App\Domains\Lookups\Services\CategoryService;
use App\Domains\Merchant\Services\MerchantBranchService;
use App\Domains\Notification\Models\Notification;
use App\Domains\Notification\Services\NotificationService;
use App\Domains\Item\Services\ItemService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
class NotificationController extends Controller
{
    private NotificationService $notificationService;

    private FirebaseIntegration $firebaseIntegration;
    /**
     * @param NotificationService $notificationService

     * @param FirebaseIntegration $firebaseIntegration
     */
    public function __construct(NotificationService $notificationService,FirebaseIntegration $firebaseIntegration)
    {
        $this->notificationService = $notificationService;
        $this->firebaseIntegration = resolve(FirebaseIntegration::class);
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('backend.notification.index');
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('backend.notification.create');
    }
    /**
     * @param NotificationRequest $request
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(NotificationRequest $request)
    {
        $this->notificationService->store($request->validated());
        return redirect()->route('admin.notification.index')->withFlashSuccess(__('The Notification was successfully added'));
    }
    /**
     * @param Notification $notification
     * @return mixed
     */
    public function edit(Notification $notification)
    {
        return view('backend.notification.edit')
            ->withNotification($notification);
    }
    /**
     * @param NotificationRequest $request
     * @param $notification
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(NotificationRequest $request, $notification)
    {
        $this->notificationService->update($notification, $request->validated());
        return redirect()->back()->withFlashSuccess(__('The Notification was successfully updated'));
    }
    /**
     * @param $notification
     * @return mixed
     */
    public function destroy($notification)
    {
        $this->notificationService->destroy($notification);
        return redirect()->back()->withFlashSuccess(__('The Notification was successfully deleted.'));
    }
    public function sendNotification (Request $request){
        try{
            $notification=Notification::query()->where('id',$request->input('notificationId'))->firstOrFail();
            if( $notification->type=='merchant'){
                $type=100;
            }
            if( $notification->type=='captain'){
                $type=101;
            }
            $data = json_encode([
                'notification_icon' => storageBaseLink(\App\Enums\Core\StoragePaths::NOTIFICATION_ICON.$notification->notification_icon),
                'type' => $type,
                'title' => ['en' => $notification->title, 'ar' =>$notification->title_ar],
                'description' => ['en' => $notification->description, 'ar' => $notification->description_ar],
            ],JSON_UNESCAPED_SLASHES);
//        Log::info($data); exit();
            $topic='all11';
            //return firebase message to be sent
            $this->firebaseIntegration->pushNotification(CloudMessage::withTarget('topic', $topic)
                ->withData(['data' => $data]));
            $notification->is_sent =1;
            $notification->update();

            return response()->json(true);
        }
        catch (\Exception $exception)
        {
            report($exception);
            return response()->json(['success' => false, 'error' => $exception]);
        }
    }
}
