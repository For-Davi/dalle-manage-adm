<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DalleAdm\CreateUserRequest;
use App\Http\Requests\User\DalleAdm\DeleteUserRequest;
use App\Http\Requests\User\DalleAdm\UpdatePasswordUserRequest;
use App\Http\Requests\User\DalleAdm\UpdateProfileRequest;
use App\Http\Requests\User\DalleAdm\UpdateUserRequest;
use App\Http\Requests\User\DalleManage\CreateUserEnterpriseRequest;
use App\Http\Requests\User\DalleManage\DeleteUserEnterpriseRequest;
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

            ErrorLogger::log('Erro ao criar usuário', $e, $request);

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

            ErrorLogger::log('Erro ao atualizar usuário', $e, $request);

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
            ErrorLogger::log('Erro ao deletar usuário', $e, $request);

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

            ErrorLogger::log('Erro ao atualizar dados', $e, $request);

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

            ErrorLogger::log('Erro ao atualizar senha', $e, $request);

            return response()->json(['message' => 'Erro ao atualizar senha'], 500);
        }
    }

    public function indexUsersByEnterprise(ShowUsersEnterpriseRequest $request)
    {
        $users = $this->userDmRepository->findUsersByEnterpriseID($request->route('enterpriseID'));

        return response()->json(['users' => $users]);
    }

    public function createUserByEnterprise(CreateUserEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->dalleManageService->create($request);

            if ($user) {
                DB::commit();

                $users = $this->userDmRepository->findUsersByEnterpriseID($request->route('enterpriseID'));

                return response()->json(['users' => $users, 'message' => 'Usuário criado'], 201);
            }
        } catch (Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao criar usuário', $e, $request);

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

                $user = $this->userDmRepository->findByID($request->route('userID'));
                $users = $this->userDmRepository->findUsersByEnterpriseID($user->enterprise_id);

                return response()->json(['users' => $users, 'message' => 'Usuário atualizado']);

            }
        } catch (Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao atualizar usuário', $e, $request);

            return response()->json(['message' => 'Erro ao atualizar usuário'], 500);
        }
    }

    public function deleteUserByEnterprise(DeleteUserEnterpriseRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->userDmRepository->delete($request->route('userID'));

            if ($user) {

                DB::commit();

                $user = $this->userDmRepository->findByID($request->route('userID'));
                $users = $this->userDmRepository->findUsersByEnterpriseID($user->enterprise_id);

                return response()->json(['users' => $users, 'message' => 'Usuário deletado']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao deletar usuário', $e, $request);

            return response()->json(['message' => 'Erro ao deletar usuário'], 500);
        }
    }
}
