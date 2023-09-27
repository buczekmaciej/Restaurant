<?php

namespace App\Enums;

use App\Enums\Traits\Names;
use App\Enums\Traits\Values;

enum OrderStatus: string
{
    use Names, Values;

    case PREPARING = "preparing";
    case DELIVERING = "delivering";
    case DELIVERED = "delivered";
}
