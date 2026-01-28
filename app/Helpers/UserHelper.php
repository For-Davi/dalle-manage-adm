<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserHelper
{
    public static function checkPassword($user, $password)
    {
        if (! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['A senha atual está incorreta.'],
            ]);
        }
    }

    public static function existsEmail($connection, $email, $mode, $userID = null)
    {
        $existEmail = DB::connection($connection)->table('users')
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

    public static function checkUserActive($user)
    {
        if ($user->active === 0) {
            throw ValidationException::withMessages([
                'active' => ['Este usuário está inativo e não pode acessar a conta. Por favor, entre em contato com o administrador.'],
            ]);
        }
    }

    public static function clearTokenReset($user)
    {
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();
        DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
    }
}
