<?php

namespace App\Enums;

enum WorkerPosition: string
{
    case EMPLOYEE = "employee";
    case MANAGER = "manager";
    case OWNER = "owner";

    public static function getValues(): array
    {
        return array_column(WorkerPosition::cases(), 'value');
    }
}
