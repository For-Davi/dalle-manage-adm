<?php

namespace App\Services\DalleAdm;

use App\DTO\Enterprise\CreateOrUpdateEnterpriseDTO;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Helpers\UserEnterpriseHelper;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleManage\UserDMRepository;
use App\Repositories\DalleManage\RoleDMRepository;
use Illuminate\Support\Facades\Hash;

class EnterpriseService
{
    public function __construct(
        protected EnterpriseRepository $repository,
        protected UserDMRepository $userDMRepository,
        protected RoleDMRepository $roleDMRepository
    ) {}

    public function createUser($request)
    {
        UserEnterpriseHelper::existsEmail($request->user(), $request->email);

        $role = $this->roleDMRepository->findByName($request->enterpriseID, 'Master');

        $userDTO = CreateUserDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roleID' => $role->id,
        ]);

        return $this->userDMRepository->createUserWithEnterpriseId($request->enterpriseID, $userDTO->toArray());
    }

    public function updateUser($request)
    {
        $userDTO = UpdateUserDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return $this->userDMRepository->update($request->userID, $userDTO->toArray());
    }

    public function create($request)
    {
        $enterpriseDTO = CreateOrUpdateEnterpriseDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'cnpj' => $request->cnpj,
            'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'cep' => $request->cep,
            'neighborhood' => $request->neighborhood,
            'address' => $request->address,
            'numberAddress' => $request->numberAddress,
            'complement' => $request->complement,
            'subscriptionId' => $request->subscriptionId,
        ]);

        $enterprise = $this->repository->create($enterpriseDTO->toArray());

        return $enterprise;
    }

    public function update($request)
    {
        $enterpriseDTO = CreateOrUpdateEnterpriseDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'cnpj' => $request->cnpj,
            'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'cep' => $request->cep,
            'neighborhood' => $request->neighborhood,
            'address' => $request->address,
            'numberAddress' => $request->numberAddress,
            'complement' => $request->complement,
            'subscriptionId' => $request->subscriptionId,
            'active' => $request->active,
        ]);

        $enterprise = $this->repository->update($request->id, $enterpriseDTO->toArray());

        return $enterprise;
    }
}
