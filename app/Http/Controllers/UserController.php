<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DalleAdm\CreateUserRequest;
use App\Http\Requests\User\DalleAdm\DeleteUserRequest;
use App\Http\Requests\User\DalleAdm\UpdatePasswordUserRequest;
use App\Http\Requests\User\DalleAdm\UpdateProfileRequest;
use App\Http\Requests\User\DalleAdm\UpdateUserRequest;
use App\Http\Requests\User\DalleManage\CreateUserEnterpriseRequest;
use App\Http\Requests\User\DalleManage\DeleteUserEnterpriseRequest;
use App\Http\Requests\User\DalleManage\ShowUserEnterpriseRequest;
use App\Http\Requests\User\DalleManage\ShowUsersEnterpriseRequest;
use App\Http\Requests\User\DalleManage\UpdateUserEnterpriseRequest;
use App\Repositories\DalleAdm\UserRepository;
use App\Repositories\DalleManage\UserDMRepository;
use App\Services\DalleAdm\UserService as DalleAdmUserService;
use App\Services\DalleManage\UserService as DalleManageUserService;
use App\Utils\ErrorLogger;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserController
{
    public function __construct(
        protected DalleAdmUserService $dalleAdmService,
        protected DalleManageUserService $dalleManageService,
        protected UserRepository $repository,
        protected UserDMRepository $userDmRepository,
    ) {}

    public function index()
    {
        $users = $this->repository->getAll();

        return response()->json(['users' => $users]);
    }

    public function create(CreateUserRequest $request)
    {
        try {

            DB::beginTransaction();

            $user = $this->dalleAdmService->create($request);

            if ($user) {
                DB::commit();
                $users = $this->repository->getAll();

                return response()->json(['users' => $users, 'message' => 'Usuário criado'], 201);
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::critical('Erro ao criar usuário', $e, $request);

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateUserRequest $request)
    {
        try {

            DB::beginTransaction();

            $user = $this->dalleAdmService->update($request);

            if ($user) {
                DB::commit();

                $users = $this->repository->getAll();

                return response()->json(['users' => $users, 'message' => 'Usuário atualizado']);
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::critical('Erro ao atualizar usuário', $e, $request);

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function delete(DeleteUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->repository->findByID($request->route('id'));
            Gate::authorize('delete-user', $user->created_by);

            if ($user) {

                $this->repository->delete($user);

                DB::commit();

                $users = $this->repository->getAll();

                return response()->json(['users' => $users, 'message' => 'Usuário excluído']);

            }
        } catch (AuthorizationException $e) {
            DB::rollBack();
            abort(403, 'Você não tem permissão para fazer esta ação.');
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::critical('Erro ao deletar usuário', $e, $request);

            return response()->json(['message' => 'Erro ao deletar usuário'], 500);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->dalleAdmService->updateProfile($request);

            if ($user) {
                DB::commit();

                return response()->json(['message' => 'Perfil atualizado']);
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::critical('Erro ao atualizar dados', $e, $request);

            return response()->json(['message' => 'Erro ao atualizar perfil'], 500);
        }
    }

    public function updatePasswordProfile(UpdatePasswordUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $password = $this->dalleAdmService->updatePasswordProfile($request);

            if ($password) {
                DB::commit();

                return response()->json(['message' => 'Senha atualizada']);
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::critical('Erro ao atualizar senha', $e, $request);

            return response()->json(['message' => 'Erro ao atualizar senha'], 500);
        }
    }

    public function indexUsersByEnterprise(ShowUsersEnterpriseRequest $request)
    {
        try {
            $enterpriseId = $request->route('enterprise');

            $users = $this->userDmRepository
                ->findUsersByEnterpriseID($enterpriseId);

            return response()->json(['users' => $users]);

        } catch (\Exception $e) {
            ErrorLogger::critical('Erro ao listar usuários da organização', $e, $request);

            return response()->json(['message' => 'Erro ao buscar usuários'], 500);
        }
    }

    public function showUserByEnterprise(ShowUserEnterpriseRequest $request)
    {
        try {
            $user = $this->userDmRepository
                ->findByID($request->route('user'));

            return response()->json(['user' => $user]);

        } catch (\Exception $e) {
            ErrorLogger::critical('Erro ao buscar usuário da organização', $e, $request);

            return response()->json(['message' => 'Erro ao buscar usuário'], 500);
        }
    }

    public function createUserByEnterprise(CreateUserEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->dalleManageService->create($request);

            if ($user) {
                DB::commit();

                $users = $this->userDmRepository->findUsersByEnterpriseID($request->route('enterprise'));

                return response()->json(['users' => $users, 'message' => 'Usuário criado'], 201);
            }
        } catch (Exception $e) {
            DB::rollBack();
            ErrorLogger::critical('Erro ao criar usuário da organização', $e, $request);

            return response()->json(['message' => 'Erro ao criar usuário'], 500);
        }
    }

    public function updateUserByEnterprise(UpdateUserEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->dalleManageService->update($request);

            if ($user) {
                DB::commit();

                $user = $this->userDmRepository->findByID($request->route('user'));
                $users = $this->userDmRepository->findUsersByEnterpriseID($user->enterprise_id);

                return response()->json(['users' => $users, 'message' => 'Usuário atualizado']);

            }
        } catch (Exception $e) {
            DB::rollBack();
            ErrorLogger::critical('Erro ao atualizar usuário da organização', $e, $request);

            return response()->json(['message' => 'Erro ao atualizar usuário'], 500);
        }
    }

    public function deleteUserByEnterprise(DeleteUserEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->userDmRepository->delete($request->route('user'));

            if ($user) {

                DB::commit();

                $user = $this->userDmRepository->findByID($request->route('user'));
                $users = $this->userDmRepository->findUsersByEnterpriseID($user->enterprise_id);

                return response()->json(['users' => $users, 'message' => 'Usuário deletado']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::critical('Erro ao deletar usuário da organização', $e, $request);

            return response()->json(['message' => 'Erro ao deletar usuário'], 500);
        }
    }
}
