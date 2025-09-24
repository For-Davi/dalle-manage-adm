<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
use App\Http\Requests\Enterprise\DeleteEnterpriseRequest;
use App\Http\Requests\Enterprise\UpdateEnterpriseRequest;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleManage\EnterpriseDMRepository;
use App\Services\DalleAdm\EnterpriseService;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class EnterpriseController
{
    public function __construct(
        protected EnterpriseDMRepository $dmRepository,
        protected EnterpriseRepository $admRepository,
        protected EnterpriseService $service
    ) {}

    public function index()
    {
        $enterprises = $this->dmRepository->getAll(['subscription']);

        return Inertia::render('Enterprises', [
            'enterprises' => $enterprises,
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
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

            return back()->withErrors(['error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.']);
        }
    }

    public function update(UpdateEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $enterprise = $this->service->update($request);

            if ($enterprise) {
                DB::commit();

                return redirect()->route('enterprises')->with('success', 'Empresa atualizada com sucesso');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao atualizar empresa', $e, $request);

            return back()->withErrors(['error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.']);
        }
    }

    public function delete(DeleteEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $enterprise = $this->admRepository->delete($request->route('id'));

            if ($enterprise) {

                DB::commit();

                return redirect()->route('enterprises')->with('success', 'Empresa deletada com sucesso');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao deletar a empresa', $e, $request);

            return back()->withErrors(['name' => 'Erro ao deletar a empresa.'])->onlyInput('name');
        }

        return redirect()->route('enterprises')->with('error', 'Erro ao deletar a empresa');
    }
}
