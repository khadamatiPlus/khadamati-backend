<?php

namespace App\Enums\Core;

use App\Enums\BaseEnum;

final class CaptainStatuses extends BaseEnum
{
    const OFFLINE = 0;
    const ONLINE = 1;
    const PENDING_REQUEST = 2;
    const BUSY = 3;
}
