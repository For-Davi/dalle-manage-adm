<?php

namespace App\Services\DalleManage;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Helpers\UserHelper;
use App\Repositories\DalleManage\UserDMRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserDMRepository $repository,
    ) {}

    public function create($request)
    {
        UserHelper::existsEmail('dalle_manage', $request->email, 'create');

        $userDTO = CreateUserDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->repository->create($userDTO->toArray());
    }

    public function update($request)
    {
        UserHelper::existsEmail('dalle_manage', $request->email, 'update', $request->userID);

        $userDTO = UpdateUserDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return $this->repository->update($request->userID, $userDTO->toArray());
    }
}
