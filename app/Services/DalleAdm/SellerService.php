<?php

namespace App\Services\DalleAdm;

use App\DTO\Seller\ApproveSellerRegistrationDTO;
use App\DTO\Seller\CreateOrUpdateSellerDTO;
use App\Helpers\SellerHelper;
use App\Repositories\DalleAdm\RegistrationRepository;
use App\Repositories\DalleAdm\SellerRepository;

class SellerService
{
    public function __construct(
        protected SellerRepository $repository,
        protected RegistrationRepository $registrationRepository,
    ) {}

    public function create($request)
    {
        SellerHelper::existsEmail($request->email, 'create');
        SellerHelper::existsCode($request->code, 'create');

        $sellerDTO = CreateOrUpdateSellerDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cpf' => $request->cpf,
            'password' => $request->password,
            'commission' => $request->commission,
            'code' => str_replace(' ', '', $request->code),
        ]);

        $seller = $this->repository->create($sellerDTO->toArray());

        return $seller;
    }

    public function approve($request)
    {
        $registration = $this->registrationRepository->findById($request->route('registration'));

        SellerHelper::existsEmail($registration->email, 'create');
        SellerHelper::existsPhone($registration->phone, 'create');
        SellerHelper::existsCode($request->code, 'create');

        $sellerDTO = ApproveSellerRegistrationDTO::fromRequest([
            'name' => $registration->name,
            'email' => $registration->email,
            'phone' => $registration->phone,
            'cpf' => $registration->cpf,
            'password' => $registration->password,
            'commission' => $request->commission,
            'code' => str_replace(' ', '', $request->code),
        ]);

        $registration = $this->repository->create($sellerDTO->toArray());

        $this->registrationRepository->delete($request->route('registration'));

        return $registration;
    }

    public function update($request)
    {

        SellerHelper::existsEmail($request->email, 'update', $request->route('seller'));
        SellerHelper::existsCode($request->code, 'update', $request->route('seller'));

        $sellerDTO = CreateOrUpdateSellerDTO::fromRequest($request);

        return $this->repository->update($request->route('seller'), $sellerDTO->toArray());
    }
}
