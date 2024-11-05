<?php

namespace App\Enums\Core;

use App\Enums\BaseEnum;

final class StoragePaths extends BaseEnum
{

    const USER_PROFILE_PICTURE = 'storage/users/profile_pictures/';
    const CAPTAIN_PROFILE_PIC = 'captain/identity_cards/profile_pic/';
    const CATEGORY_IMAGE = 'category/images/';

    const CAPTAIN_DRIVING_LICENSE_CARD = 'captain/identity_cards/driving_license_card/';
    const CAPTAIN_CAR_ID_CARD = 'captain/identity_cards/car_id_card/';
    const MERCHANT_PROFILE_PIC = 'merchants/profile_pic/';
    const USER_TYPE_IMAGE = 'usertype/images/';
    const ORDER_VOICE_RECORD = 'order/voice_records/';

    const NOTIFICATION_ICON='notification/notification_icons/';
    const BANNER_IMAGE='banner/images/';
    const SERVICE_FILE='service/files/';

}
