<?php

namespace App\Enums\Core;

use App\Enums\BaseEnum;

final class OrderStatuses extends BaseEnum
{
    /**
     * happy scenario status flow
     */
    const NEW_ORDER = 1;
    const PENDING_CAPTAIN_ACCEPT = 2;
    const CAPTAIN_ACCEPTED = 3;
    const ON_THE_WAY_TO_CUSTOMER = 4;
    const DELIVERED = 5;
    const COMPLETED = 6;
    /**
     * below are the statuses that may break the order process
     * all of them should be negative
     */
    const REJECTED_BY_MERCHANT = -1;
    const CAPTAIN_CANCELLED  = -2;
    /*
     * Old statuses
     */
//    const CAPTAIN_NOT_REQUESTED = 1;
//    const PENDING = 2;
//    const ACCEPTED_ORDER = 3;
//    const ON_THE_WAY = 4;
//    const COMPLETED = 5;
}
