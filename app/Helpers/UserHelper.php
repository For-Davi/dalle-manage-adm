<?php

namespace App\Helpers;

use App\Models\Adm\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserHelper
{
    public static function validUser($email, $password)
    {
        $userRepository = new UserRepository(new User);
        $user = $userRepository->findByEmail($email);
        if (! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['A senha informada está incorreta'],
            ]);
        }
    }

    public static function checkPassword($user, $password)
    {
        if (! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Credenciais não constam em nosso registro.'],
            ]);
        }
    }

    public static function existsEmail($email, $mode, $userID = null)
    {

        $existEmail = DB::table('users')
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

            Log::info('Verificando email', [
                'userID' => $userID,
                'existsEmail' => $existEmail,
            ]);

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
