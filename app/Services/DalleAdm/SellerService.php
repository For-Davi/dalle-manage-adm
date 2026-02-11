<?php

namespace App\Services\DalleAdm;

use App\DTO\Seller\CreateOrUpdateSellerDTO;
use App\Helpers\SellerHelper;
use App\Repositories\DalleAdm\SellerRepository;

class SellerService
{
    public function __construct(
        protected SellerRepository $repository,
    ) {}

    public function create($request)
    {
        SellerHelper::existsEmail($request->email, 'create');
        SellerHelper::existsCode($request->code, 'create');

        $sellerDTO = CreateOrUpdateSellerDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'code' => str_replace(' ', '', $request->code),
        ]);

        $seller = $this->repository->create($sellerDTO->toArray());

        return $seller;
    }

    public function update($request)
    {

        SellerHelper::existsEmail($request->email, 'update', $request->route('seller'));
        SellerHelper::existsCode($request->code, 'update', $request->route('seller'));

        $sellerDTO = CreateOrUpdateSellerDTO::fromRequest([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'code' => $request->code,
        ]);

        return $this->repository->update($request->route('seller'), $sellerDTO->toArray());
    }
}
