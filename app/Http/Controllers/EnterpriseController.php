<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
use App\Http\Requests\Enterprise\DeleteEnterpriseRequest;
use App\Http\Requests\Enterprise\UpdateEnterpriseRequest;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleAdm\SellerRepository;
use App\Repositories\DalleManage\EnterpriseDMRepository;
use App\Repositories\DalleManage\UserDMRepository;
use App\Services\DalleAdm\EnterpriseService;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EnterpriseController
{
    public function __construct(
        protected EnterpriseDMRepository $dmRepository,
        protected EnterpriseRepository $admRepository,
        protected EnterpriseService $service,
        protected UserDMRepository $userDmRepository,
        protected SellerRepository $sellerRepository,
    ) {}

    public function show()
    {
        $enterprises = $this->dmRepository->getAll(['subscription']);

        return Inertia::render('Enterprise', ['enterprises' => $enterprises]);
    }

    public function index()
    {
        $enterprises = $this->dmRepository->getAll(['subscription']);

        return response()->json(['enterprises' => $enterprises]);
    }

    public function create(CreateEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $enterprise = $this->service->create($request);

            if ($enterprise) {
                DB::commit();
                $enterprises = $this->dmRepository->getAll(['subscription']);

                return response()->json(['enterprises' => $enterprises, 'message' => 'Empresa criada'], 201);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao criar empresa', $e, $request);

            return response()->json(['message' => 'Erro ao criar empresa'], 500);
        }
    }

    public function update(UpdateEnterpriseRequest $request)
    {
        try {

            DB::beginTransaction();

            $enterprise = $this->service->update($request);

            if ($enterprise) {
                DB::commit();
                $enterprises = $this->dmRepository->getAll(['subscription']);

                return response()->json(['enterprises' => $enterprises, 'message' => 'Empresa atualizada'], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao atualizar empresa', $e, $request);

            return response()->json(['message' => 'Erro ao atualizar empresa'], 500);
        }
    }

    public function delete(DeleteEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $enterprise = $this->dmRepository->delete($request->route('id'));

            if ($enterprise) {

                DB::commit();

                $enterprises = $this->dmRepository->getAll(['subscription']);

                return response()->json(['enterprises' => $enterprises, 'message' => 'Empresa excluída'], 200);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao excluir a empresa', $e, $request);

            return response()->json(['message' => 'Erro ao excluir a empresa'], 500);
        }
    }
}
