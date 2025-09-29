<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SellerHelper
{
    public static function existsCode($code)
    {

        $existCode = DB::table('sellers')
            ->where('code', $code)
            ->first();

        if ($existCode) {
            if ($code !== $existCode->code) {
                throw ValidationException::withMessages([
                    'code' => ['Este código ja está em uso.'],
                ]);
            }
        }
    }
}
