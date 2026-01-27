<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SellerHelper
{
    public static function existsCode($code, $mode, $sellerID = null)
    {
        $existCode = DB::table('sellers')
            ->where('code', $code)
            ->first();

        if (! $existCode) {
            throw ValidationException::withMessages([
                'sellerCode' => ['O código do vendedor informado não existe.'],
            ]);
        }

        if ($mode === 'create') {
            if ($existCode) {
                if ($code === $existCode->code) {
                    throw ValidationException::withMessages([
                        'code' => ['Este código ja está sendo usado por outro vendedor.'],
                    ]);
                }
            }
        } else {
            $sellerID = (int) $sellerID;
            if ($existCode && $existCode->id !== $sellerID) {
                throw ValidationException::withMessages([
                    'code' => ['Este código ja está sendo usado por outro vendedor.'],
                ]);
            }
        }
    }

    public static function existsEmail($email, $mode, $sellerID = null)
    {

        $existEmail = DB::table('sellers')
            ->where('email', $email)
            ->first();

        if ($mode === 'create') {
            if ($existEmail) {
                if ($email === $existEmail->email) {
                    throw ValidationException::withMessages([
                        'email' => ['Este e-mail ja está sendo usado por outro vendedor.'],
                    ]);
                }
            }
        } else {
            $sellerID = (int) $sellerID;
            if ($existEmail && $existEmail->id !== $sellerID) {
                throw ValidationException::withMessages([
                    'email' => ['Este e-mail ja está sendo usado por outro vendedor.'],
                ]);
            }
        }
    }
}
