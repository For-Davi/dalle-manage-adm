<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class EnterpriseHelper
{
    public static function existsEmail($email, $mode, $userID = null)
    {

        $existEmail = DB::connection('dalle_manage')->table('users')
            ->where('email', $email)
            ->first();

        if ($mode === 'create') {
            if ($existEmail) {
                if ($email === $existEmail->email) {
                    throw ValidationException::withMessages([
                        'email' => ['Este e-mail ja está sendo usado por outro usuário.'],
                    ]);
                }
            }
        } else {
            $userID = (int) $userID;
            if ($existEmail && $existEmail->id !== $userID) {
                throw ValidationException::withMessages([
                    'email' => ['Este e-mail ja está sendo usado por outro usuário.'],
                ]);
            }
        }
    }

    public static function isPasswordEqual($user, $currentPassword)
    {
        if (! Hash::check($currentPassword, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['A senha atual está incorreta.'],
            ]);
        }
    }
}
