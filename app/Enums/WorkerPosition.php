<?php

namespace App\Enums;

use App\Enums\Traits\Names;
use App\Enums\Traits\Values;

enum WorkerPosition: string
{
    use Names, Values;

    case EMPLOYEE = "employee";
    case MANAGER = "manager";
    case OWNER = "owner";
}
