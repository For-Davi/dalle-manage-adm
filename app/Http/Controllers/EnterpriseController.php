<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
use App\Http\Requests\Enterprise\DeleteEnterpriseRequest;
use App\Http\Requests\Enterprise\ShowEnterpriseRequest;
use App\Http\Requests\Enterprise\UpdateEnterpriseRequest;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleAdm\SellerRepository;
use App\Repositories\DalleManage\EnterpriseDMRepository;
use App\Repositories\DalleManage\UserDMRepository;
use App\Services\DalleAdm\EnterpriseService;

class EnterpriseController extends BaseController
{
    public function __construct(
        protected EnterpriseDMRepository $dmRepository,
        protected EnterpriseRepository $admRepository,
        protected EnterpriseService $service,
        protected UserDMRepository $userDmRepository,
        protected SellerRepository $sellerRepository,
    ) {}

    public function index()
    {
        return $this->safeExecute(function () {

            $enterprises = $this->dmRepository->getAll(['subscription']);

            return response()->json([
                'enterprises' => $enterprises,
            ]);

        }, 'Erro ao listar empresas');
    }

    public function show(ShowEnterpriseRequest $request)
    {
        return $this->safeExecute(function () use ($request) {

            $enterprise = $this->dmRepository->findById(
                $request->route('enterprise'),
                ['seller', 'subscription']
            );

            return response()->json([
                'enterprise' => $enterprise,
            ]);

        }, 'Erro ao buscar empresa', $request);
    }

    public function create(CreateEnterpriseRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $enterprise = $this->service->create($request);

            if (! $enterprise) {
                return response()->json([
                    'message' => 'Empresa não criada',
                ], 400);
            }

            return response()->json([
                'message' => 'Empresa criada',
            ], 201);

        }, 'Erro ao criar empresa', $request);
    }

    public function update(UpdateEnterpriseRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $enterprise = $this->service->update($request);

            if (! $enterprise) {
                return response()->json([
                    'message' => 'Empresa não atualizada',
                ], 400);
            }

            return response()->json([
                'message' => 'Empresa atualizada',
            ]);

        }, 'Erro ao atualizar empresa', $request);
    }

    public function delete(DeleteEnterpriseRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $enterprise = $this->dmRepository
                ->delete($request->route('enterprise'));

            if (! $enterprise) {
                return response()->json([
                    'message' => 'Empresa não encontrada',
                ], 404);
            }

            $enterprises = $this->dmRepository->getAll(['subscription']);

            return response()->json([
                'enterprises' => $enterprises,
                'message' => 'Empresa excluída',
            ]);

        }, 'Erro ao excluir empresa', $request);
    }
}
