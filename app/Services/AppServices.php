<?php

namespace App\Services;

class AppServices
{
    public static function generateCode(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = "";
        $charactersLength = strlen($characters);

        for ($i = 0; $i < 35; $i++) $code .= $characters[random_int(0, $charactersLength - 1)];

        return $code;
    }
}
