<?php

namespace App\Services\DalleAdm;

use App\DTO\Enterprise\EnterpriseDTO;
use App\Repositories\DalleAdm\EnterpriseRepository;

class EnterpriseService
{
    public function __construct(
        protected EnterpriseRepository $repository,
    ) {}

    public function create($request)
    {
        $enterpriseDTO = EnterpriseDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'cnpj' => $request->cnpj,
            'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'cep' => $request->cep,
            'neighborhood' => $request->neighborhood,
            'numberAddress' => $request->numberAddress,
            'complement' => $request->complement,
            'subscriptionId' => $request->subscriptionId,
        ]);
        $enterprise = $this->repository->create($enterpriseDTO->toArray());

        return $enterprise;
    }
}
