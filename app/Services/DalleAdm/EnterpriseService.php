<?php

namespace App\Services\DalleAdm;

use App\DTO\Enterprise\CreateOrUpdateEnterpriseDTO;
use App\DTO\Setting\Appearance\CreateSettingAppearanceDTO;
use App\DTO\Setting\System\CreateSettingSystemDTO;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleManage\SettingAppearanceDMRepository;
use App\Repositories\DalleManage\SettingSystemDMRepository;

class EnterpriseService
{
    public function __construct(
        protected EnterpriseRepository $repository,
        protected SettingAppearanceDMRepository $settingAppearanceRepository,
        protected SettingSystemDMRepository $settingSystemRepository,
    ) {}

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
        ]);

        $enterprise = $this->repository->update($request->id, $enterpriseDTO->toArray());

        return $enterprise;
    }
}
