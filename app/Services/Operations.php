<?php

namespace App\Services;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class Operations
{
    public static function decrypt($value)
    {
        // verifica se o $value é encripitado
        try {
            $value = Crypt::decrypt($value);
        } catch (DecryptException $e) {
            return null;
        }
        return $value;
    }
}
