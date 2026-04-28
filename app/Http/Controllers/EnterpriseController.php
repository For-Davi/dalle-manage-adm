<?php

namespace App\Http\Controllers;

use App\DTO\Enterprise\Payment\FilterEnterprisePaymentDTO;
use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
use App\Http\Requests\Enterprise\DeleteEnterpriseRequest;
use App\Http\Requests\Enterprise\Payment\FilterEnterprisePayments;
use App\Http\Requests\Enterprise\ShowEnterpriseRequest;
use App\Http\Requests\Enterprise\UpdateEnterpriseRequest;
use App\Http\Resources\Enterprise\EnterprisePaymentResource;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleAdm\SellerRepository;
use App\Repositories\DalleManage\EnterpriseDMRepository;
use App\Repositories\DalleManage\UserDMRepository;
use App\Repositories\DallePayments\PaymentsDMRepository;
use App\Services\DalleAdm\EnterpriseService;
use Illuminate\Support\Facades\Log;

class EnterpriseController extends BaseController
{
    public function __construct(
        protected EnterpriseDMRepository $dmRepository,
        protected EnterpriseRepository $admRepository,
        protected PaymentsDMRepository $pmRepository,
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

    public function indexPayments()
    {
        return $this->safeExecute(function () {

            $payments = $this->pmRepository->getAll();

            return response()->json([
                'payments' => EnterprisePaymentResource::collection($payments),
            ]);

        }, 'Erro ao listar pagamentos das empresas');
    }

    public function filterPayments(FilterEnterprisePayments $request)
    {
        return $this->safeExecute(function () use ($request) {
            $paymentsFilterDTO = FilterEnterprisePaymentDTO::fromRequest($request);
            $payments = $this->pmRepository->getAllWithFilter($paymentsFilterDTO);

            return response()->json(['payments' => EnterprisePaymentResource::collection($payments)], 200);
        }, 'Erro ao filtrar clientes', $request);
    }
}
