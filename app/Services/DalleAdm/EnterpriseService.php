<?php

namespace App\Services\DalleAdm;

use App\DTO\Enterprise\CreateOrUpdateEnterpriseDTO;
use App\DTO\User\CreateOrUpdateUserDTO;
use App\Helpers\UserEnterpriseHelper;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleManage\UserDMRepository;
use Illuminate\Support\Facades\Hash;

class EnterpriseService
{
    public function __construct(
        protected EnterpriseRepository $repository,
        protected UserDMRepository $userDMrepository,
    ) {}

    public function createUser($request)
    {
        UserEnterpriseHelper::existsEmail($request->user(), $request->email);

        $userDTO = CreateOrUpdateUserDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->userDMrepository->createUserWithEnterpriseId($request->enterpriseID, $userDTO->toArray());
    }

    public function updateUser($request)
    {
        $userDTO = CreateOrUpdateUserDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return $this->userDMrepository->update($request->userID, $userDTO->toArray());
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
