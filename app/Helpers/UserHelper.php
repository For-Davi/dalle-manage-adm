<?php

namespace App\Helpers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
    public static function existsEmail($user, $email)
    {

        $existEmail = DB::table('users')
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
