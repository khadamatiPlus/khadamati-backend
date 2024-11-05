<?php

namespace App\Domains\Notification\Http\Transformers;

use App\Domains\Notification\Models\Notification;
use App\Enums\Core\StoragePaths;
use Illuminate\Support\Facades\Log;


class NotificationTransformer
{
    /**
     * @param Notification $notification
     * @return array
     */
    public function transform(Notification $notification): array
    {
        return [
            'id' => $notification->id,
            'type' => $notification->type,
             'title' =>  $notification->title,
            'body' =>  $notification->description,
            'notification_icon' => !empty($notification->notification_icon)?storageBaseLink(StoragePaths::NOTIFICATION_ICON.$notification->notification_icon):'',



        ];
//        $data = json_encode([
//            'notification_icon' => storageBaseLink(\App\Enums\Core\StoragePaths::NOTIFICATION_ICON.$notification->notification_icon),
//            'type' => $notification->type,
//            'item_id' => $notification->item->id??0,
//            'merchant_branch_id' => $notification->merchantBranch->id??0,
//            'merchant_id' => $notification->merchantBranch->merchant->id??0,
//            'title' => ['en' => $notification->title, 'ar' =>$notification->title_ar],
//            'description' => ['en' => $notification->description, 'ar' => $notification->description_ar],
//        ],JSON_UNESCAPED_SLASHES);
    }
}
