<?php

namespace App\Services;

use App\DTO\User\UserStartDTO;
use App\Helpers\UserHelper;
use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(
        protected UserRepository $repository,
    ) {}

    public function login($request)
    {
        $user = $this->repository->findByEmail($request->email);

        $this->hasUser($user);
        UserHelper::checkPassword($user, $request->password);
   
        return $user;
    }

     private function hasUser($user)
    {
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais não constam em nosso registro.'],
            ]);
        }
    }
}
