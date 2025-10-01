<?php

namespace App\Http\Controllers;

use App\Http\Requests\Enterprise\CreateEnterpriseRequest;
use App\Http\Requests\Enterprise\CreateUserEnterpriseRequest;
use App\Http\Requests\Enterprise\DeleteEnterpriseRequest;
use App\Http\Requests\Enterprise\DeleteUserEnterpriseRequest;
use App\Http\Requests\Enterprise\ShowUsersEnterpriseRequest;
use App\Http\Requests\Enterprise\UpdateEnterpriseRequest;
use App\Http\Requests\Enterprise\UpdateUserEnterpriseRequest;
use App\Repositories\DalleAdm\EnterpriseRepository;
use App\Repositories\DalleAdm\SellerRepository;
use App\Repositories\DalleManage\EnterpriseDMRepository;
use App\Repositories\DalleManage\UserDMRepository;
use App\Services\DalleAdm\EnterpriseService;
use App\Utils\ErrorLogger;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class EnterpriseController
{
    public function __construct(
        protected EnterpriseDMRepository $dmRepository,
        protected EnterpriseRepository $admRepository,
        protected EnterpriseService $service,
        protected UserDMRepository $userdmRepository,
        protected SellerRepository $sellerRepository,
    ) {}

    public function index()
    {
        $enterprises = $this->dmRepository->getAll(['subscription']);
        $sellers = $this->sellerRepository->getAll();

        return Inertia::render('Enterprises', [
            'enterprises' => $enterprises,
            'sellers' => $sellers,
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],
        ]);
    }

    public function indexUsers(ShowUsersEnterpriseRequest $request)
    {
        $users = $this->userdmRepository->findUsersByEnterpriseId($request->route('enterpriseID'));

        return response()->json([
            'users' => $users,
        ]);

    }

    public function create(CreateEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $enterprise = $this->service->create($request);

            if ($enterprise) {
                DB::commit();

                return redirect()->route('enterprises')->with('success', 'Empresa criada com sucesso');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao criar empresa', $e, $request);

            return back()->withErrors(['error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.']);
        }
    }

    public function createUser(CreateUserEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->service->createUser($request);

            if ($user) {
                DB::commit();

                return redirect()->route('enterprises')->with('success', 'Usuário criado com sucesso');
            }
        } catch (ValidationException $e) {
            DB::rollBack();

            return back()->withErrors($e->errors())->withInput();
        } catch (ValidationException $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao criar usuário', $e, $request);

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
        } catch (ValidationException $e) {
            DB::rollBack();

            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao atualizar empresa', $e, $request);

            return back()->withErrors(['error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.']);
        }
    }

    public function updateUser(UpdateUserEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->service->updateUser($request);

            if ($user) {
                DB::commit();

                return redirect()->route('enterprises')->with('success', 'Usuário atualizado com sucesso');
            }
        } catch (ValidationException $e) {
            DB::rollBack();

            return back()->withErrors($e->errors())->withInput();
        } catch (ValidationException $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao atualizar usuário', $e, $request);

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

    public function deleteUser(DeleteUserEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $enterprise = $this->userdmRepository->delete($request->route('userID'));

            if ($enterprise) {

                DB::commit();

                return redirect()->route('enterprises')->with('success', 'Usuário deletado com sucesso');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao deletar a empresa', $e, $request);

            return back()->withErrors(['name' => 'Erro ao deletar usuário.'])->onlyInput('name');
        }

        return redirect()->route('enterprises')->with('error', 'Erro ao deletar usuário');
    }
}
