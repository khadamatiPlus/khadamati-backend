<?php
namespace App\Domains\Merchant\Events;
use App\Domains\Auth\Models\User;
use App\Domains\Delivery\Http\Transformers\OrderTransformer;
use App\Domains\Delivery\Http\Transformers\RecentTransformer;
use App\Domains\Delivery\Models\Order;
use App\Domains\Delivery\Models\Recent;
use App\Domains\FirebaseIntegration\FirebaseIntegration;
use App\Domains\Item\Http\Transformers\ItemTransformer;
use App\Domains\Item\Models\Item;
use App\Domains\Merchant\Http\Transformers\MerchantTransformer;
use App\Domains\Merchant\Models\Merchant;
use App\Enums\Core\MerchantNotificationTypes;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Kreait\Firebase\Messaging\CloudMessage;
use App\Domains\Customer\Models\CustomerPointsLogRecord;
use Illuminate\Support\Facades\Log;
/**
 * Created by Omar
 * Author: Vibes Solutions
 * On: 5/16/2023
 * Class: MerchantApproved.php
 */
class MerchantApproved implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Merchant $merchant
     */
    public Merchant $merchant;

    /**
     * @var FirebaseIntegration $firebaseIntegration
     */
    private FirebaseIntegration $firebaseIntegration;

    /**
     * @param Merchant $merchant
     */
    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
        $this->firebaseIntegration = resolve(FirebaseIntegration::class);
    }

    /**
     * @return Channel
     * @throws \Kreait\Firebase\Exception\FirebaseException
     * @throws \Kreait\Firebase\Exception\MessagingException
     */
    public function broadcastOn(): Channel
    {
        //prepare notification variables
        Log::info('before pushNotification');
        $title_en = __('The Admin approve ',['merchant_id' => $this->merchant->id],'en');
        $title_ar = __('The Admin approve :merchant_id',['merchant_id' => $this->merchant->id],'ar');
        $body_en =  __('The Merchant: :merchant_name',['merchant_name' => $this->merchant->business_name],'en');
        $body_ar =  __('The Merchant: :merchant_name',['merchant_name' => $this->merchant->business_name_ar],'ar');
        $topic = 'merchant-'.$this->merchant->id.'-branch'.'-'.'0';
        $data = json_encode([
            'type' => MerchantNotificationTypes::MERCHANT_APPROVED,
            'title' => ['en' => $title_en, 'ar' => $title_ar],
            'body' =>  ['en' => $body_en, 'ar' => $body_ar],
            'merchant' => (new MerchantTransformer)->transform($this->merchant)
        ],JSON_UNESCAPED_SLASHES);
        Log::info('before pushNotification');
        //return firebase message to be sent
        $this->firebaseIntegration->pushNotification(CloudMessage::withTarget('topic', $topic)
            ->withData(['data' => $data]));
        Log::info($topic);

        return new Channel('order');
    }
}
