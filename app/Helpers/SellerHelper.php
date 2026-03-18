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

        if ($mode === 'create') {
            if ($existCode) {
                if ($code === $existCode->code) {
                    throw ValidationException::withMessages([
                        'code' => ['Este código ja está sendo utilizado.'],
                    ]);
                }
            }
        } else {
            $sellerID = (int) $sellerID;
            if ($existCode && $existCode->id !== $sellerID) {
                throw ValidationException::withMessages([
                    'code' => ['Este código ja está sendo utilizado.'],
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
                        'email' => ['Este e-mail ja está sendo utilizado.'],
                    ]);
                }
            }
        } else {
            $sellerID = (int) $sellerID;
            if ($existEmail && $existEmail->id !== $sellerID) {
                throw ValidationException::withMessages([
                    'email' => ['Este e-mail ja está sendo utilizado.'],
                ]);
            }
        }
    }

    public static function existsPhone($phone, $mode, $sellerID = null)
    {

        $existPhone = DB::table('sellers')
            ->where('phone', $phone)
            ->first();

        if ($mode === 'create') {
            if ($existPhone) {
                if ($phone === $existPhone->phone) {
                    throw ValidationException::withMessages([
                        'phone' => ['Este telefone ja está sendo utilizado.'],
                    ]);
                }
            }
        } else {
            $sellerID = (int) $sellerID;
            if ($existPhone && $existPhone->id !== $sellerID) {
                throw ValidationException::withMessages([
                    'phone' => ['Este telefone ja está sendo utilizado.'],
                ]);
            }
        }
    }
}
