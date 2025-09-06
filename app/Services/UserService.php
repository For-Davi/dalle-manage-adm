<?php

namespace App\Services;

use App\DTO\User\UserStartDTO;
use App\DTO\User\UpdateDataProfileDTO;
use App\DTO\User\UpdatePasswordProfileDTO;
use App\Helpers\UserHelper;
use App\Repositories\UserRepository;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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

    public function updateDataProfile($request)
    {
        UserHelper::existsEmail(
            $request->user(),
            $request->email,
        );

        $profileDataDTO = UpdateDataProfileDTO::fromRequest(
            $request->only(['name', 'email']),
        );

        return $this->repository->update($request->user()->id, $profileDataDTO->toArray());
    }

    public function updatePasswordProfile($request)
    {
        UserHelper::isPasswordEqual(
            $request->user(),
            $request->currentPassword
        );

        $profilePasswordDTO = UpdatePasswordProfileDTO::fromRequest([
            'password' => Hash::make($request->password),
        ]);

        return $this->repository->update($request->user()->id, $profilePasswordDTO->toArray());
    }
}
