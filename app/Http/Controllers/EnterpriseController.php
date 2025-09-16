<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
use App\Repositories\DalleManage\EnterpriseDMRepository;
use App\Services\DalleAdm\EnterpriseService;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EnterpriseController
{
    public function __construct(protected EnterpriseDMRepository $repository, protected EnterpriseService $service) {}

    public function index()
    {
        $enterprises = $this->repository->getAll(['subscription']);

        return Inertia::render('Enterprises', [
            'enterprises' => $enterprises,
        ]);
    }

    public function create(CreateEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $enterprise = $this->service->create($request);

            if ($enterprise) {
                DB::commit();

                return redirect()->route('enterprises');
            }
        } catch (\Exception $e) {
            DB::rollBack();

            ErrorLogger::log('Erro ao criar empresa', $e, $request);

            return back()->withErrors([
                'error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.',
            ]);
        }

        return back()->withErrors([
            'name' => 'Erro ao criar empresa.',
        ])->onlyInput('name');
    }
}
