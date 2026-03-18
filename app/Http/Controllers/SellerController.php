<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seller\CreateSellerRequest;
use App\Http\Requests\Seller\DeleteSellerRequest;
use App\Http\Requests\Seller\Registration\ApproveSellerRegistrationRequest;
use App\Http\Requests\Seller\ShowSellerRequest;
use App\Http\Requests\Seller\UpdateSellerRequest;
use App\Repositories\DalleAdm\SellerRepository;
use App\Services\DalleAdm\SellerService;

class SellerController extends BaseController
{
    public function __construct(
        protected SellerRepository $repository,
        protected SellerService $service
    ) {}

    public function index()
    {
        return $this->safeExecute(function () {

            $sellers = $this->repository->getAll();

            return response()->json([
                'sellers' => $sellers,
            ]);

        }, 'Erro ao listar vendedores');
    }

    public function show(ShowSellerRequest $request)
    {
        return $this->safeExecute(function () use ($request) {

            $seller = $this->repository
                ->findById($request->route('seller'));

            return response()->json([
                'seller' => $seller,
            ]);

        }, 'Erro ao buscar vendedor', $request);
    }

    public function create(CreateSellerRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $seller = $this->service->create($request);

            if (! $seller) {
                return response()->json([
                    'message' => 'Vendedor não criado',
                ], 400);
            }

            $sellers = $this->repository->getAll();

            return response()->json([
                'sellers' => $sellers,
                'message' => 'Vendedor criado',
            ], 201);

        }, 'Erro ao criar vendedor', $request);
    }

    public function approve(ApproveSellerRegistrationRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $approve = $this->service->approve($request);

            if (! $approve) {
                return response()->json([
                    'message' => 'Solicitação não finalizada',
                ], 400);
            }

            return response()->json([
                'message' => 'Solicitação aprovada',
            ], 201);

        }, 'Erro ao aprovar solicitação', $request);
    }

    public function update(UpdateSellerRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $seller = $this->service->update($request);

            if (! $seller) {
                return response()->json([
                    'message' => 'Vendedor não atualizado',
                ], 400);
            }

            $sellers = $this->repository->getAll();

            return response()->json([
                'sellers' => $sellers,
                'message' => 'Vendedor atualizado',
            ]);

        }, 'Erro ao atualizar vendedor', $request);
    }

    public function delete(DeleteSellerRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $this->repository
                ->delete($request->route('seller'));

            $sellers = $this->repository->getAll();

            return response()->json([
                'sellers' => $sellers,
                'message' => 'Vendedor excluído',
            ]);

        }, 'Erro ao excluir vendedor', $request);
    }
}
