<?php

namespace App\Enums\Core;

use App\Enums\BaseEnum;

final class ErrorTypes extends BaseEnum
{

    const GENERAL = 0;
    const AUTH = 1;
    const USER = 3;
    const MERCHANT = 4;
    const ORDER = 5;
    const CAPTAIN =6;
    const CUSTOMER =7;
    const ITEM = 8;
    const CATEGORY = 9;
}
