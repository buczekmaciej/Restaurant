<?php

namespace App\Enums;

enum WorkerPosition: string
{
    case EMPLOYEE = "employee";
    case MANAGER = "manager";
    case OWNER = "owner";
}
