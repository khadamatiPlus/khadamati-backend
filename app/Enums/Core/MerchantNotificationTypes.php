<?php

namespace App\Enums\Core;

use App\Enums\BaseEnum;
final class MerchantNotificationTypes extends BaseEnum
{
    const NEW_ORDER_CREATED = 1;
    const CAPTAIN_ACCEPTED_ORDER = 2;
    const CUSTOMER_PICKED_ORDER = 3;
    const ORDER_PAYMENT_STATUS = 4;
    const REDEEM = 5;
    const DEAL_APPROVED =6;
    const COUPON_APPROVED =7;
    const MERCHANT_APPROVED =8;
    const CAPTAIN_ARRIVED_TO_CUSTOMER =9;
}
