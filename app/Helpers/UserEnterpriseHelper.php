<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UserEnterpriseHelper
{
    public static function existsEmail($user, $email)
    {

        $existEmail = DB::connection('dalle_manage')->table('users')
            ->where('email', $email)
            ->first();

        if ($existEmail) {
            if ($user->email !== $existEmail->email) {
                throw ValidationException::withMessages([
                    'email' => ['Este email ja está em uso.'],
                ]);
            }
        }
    }
}
