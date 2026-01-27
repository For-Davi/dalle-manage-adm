<?php

namespace App\Services\DalleAdm;

use App\DTO\Enterprise\CreateEnterpriseUserDTO;
use App\DTO\Enterprise\CreateOrUpdateEnterpriseDTO;
use App\DTO\Enterprise\UpdateEnterpriseUserDTO;
use App\DTO\Role\RoleStartDTO;
use App\DTO\Setting\Appearance\CreateSettingAppearanceDTO;
use App\DTO\Setting\System\CreateSettingSystemDTO;
use App\Helpers\UserHelper;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleManage\RoleDMRepository;
use App\Repositories\DalleManage\SettingAppearanceDMRepository;
use App\Repositories\DalleManage\SettingSystemDMRepository;
use App\Repositories\DalleManage\UserDMRepository;
use Illuminate\Support\Facades\Hash;

class EnterpriseService
{
    public function __construct(
        protected EnterpriseRepository $repository,
        protected SettingAppearanceDMRepository $settingAppearanceRepository,
        protected SettingSystemDMRepository $settingSystemRepository,
        protected UserDMRepository $userDMRepository,
        protected RoleDMRepository $roleDMRepository,
    ) {}

    /** ==============================
     *  MÉTODOS DE CONFIGURAÇÃO
     *  ============================== */
    private function createSettingAppearance($enterpriseID)
    {
        $settingAppearanceDTO = CreateSettingAppearanceDTO::fromRequest(['enterpriseID' => $enterpriseID]);

        $this->settingAppearanceRepository->create($settingAppearanceDTO->toArray());
    }

    private function createSettingSystem($enterpriseID)
    {
        $settingSystemDTO = CreateSettingSystemDTO::fromRequest(['enterpriseID' => $enterpriseID]);

        $this->settingSystemRepository->create($settingSystemDTO->toArray());
    }

    private function startRole($enterpriseID)
    {
        $roleDTO = RoleStartDTO::fromRequest(['enterpriseID' => $enterpriseID]);

        $this->roleDMRepository->start($roleDTO->toArray());
    }

    /** ==============================
     *  MÉTODOS DE USUÁRIOS
     *  ============================== */
    public function createUser($request)
    {
        UserHelper::existsEmail('dalle_manage', $request->email, 'create');

        $role = $this->roleDMRepository->findByName($request->enterpriseID, 'Master');

        $userDTO = CreateEnterpriseUserDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roleID' => $role->id,
        ]);

        return $this->userDMRepository->createUserWithEnterpriseId($request->enterpriseID, $userDTO->toArray());
    }

    public function updateUser($request)
    {
        UserHelper::existsEmail('mysql', $request->email, 'update', $request->userID);

        $userDTO = UpdateEnterpriseUserDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return $this->userDMRepository->update($request->userID, $userDTO->toArray());
    }

    /** ==============================
     *  MÉTODOS DE EMPRESAS
     *  ============================== */
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
            'sellerID' => $request->sellerID,
        ]);

        $enterprise = $this->repository->create($enterpriseDTO->toArray());

        $this->startRole($enterprise->id);
        $this->createSettingAppearance($enterprise->id);
        $this->createSettingSystem($enterprise->id);

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
            'sellerID' => $request->sellerID,
        ]);

        return $this->repository->update($request->id, $enterpriseDTO->toArray());
    }
}
