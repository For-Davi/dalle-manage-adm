<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DalleAdm\CreateUserRequest;
use App\Http\Requests\User\DalleAdm\DeleteUserRequest;
use App\Http\Requests\User\DalleAdm\ShowUserRequest;
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
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Gate;

class UserController extends BaseController
{
    public function __construct(
        protected DalleAdmUserService $dalleAdmService,
        protected DalleManageUserService $dalleManageService,
        protected UserRepository $repository,
        protected UserDMRepository $userDmRepository,
    ) {}

    public function index()
    {
        return $this->safeExecute(function () {

            $users = $this->repository->getAll();

            return response()->json([
                'users' => $users,
            ]);

        }, 'Erro ao listar usuários');
    }

    public function show(ShowUserRequest $request)
    {
        return $this->safeExecute(function () use ($request) {

            $user = $this->repository->findByID(
                $request->route('user')
            );

            return response()->json([
                'user' => $user,
            ]);

        }, 'Erro ao buscar usuário', $request);
    }

    public function create(CreateUserRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $user = $this->dalleAdmService->create($request);

            if (! $user) {
                return response()->json([
                    'message' => 'Usuário não criado',
                ], 400);
            }

            $users = $this->repository->getAll();

            return response()->json([
                'users' => $users,
                'message' => 'Usuário criado',
            ], 201);

        }, 'Erro ao criar usuário', $request);
    }

    public function update(UpdateUserRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $user = $this->dalleAdmService->update($request);

            if (! $user) {
                return response()->json([
                    'message' => 'Usuário não atualizado',
                ], 400);
            }

            $users = $this->repository->getAll();

            return response()->json([
                'users' => $users,
                'message' => 'Usuário atualizado',
            ]);

        }, 'Erro ao atualizar usuário', $request);
    }

    public function delete(DeleteUserRequest $request)
    {
        try {
            return $this->safeTransaction(function () use ($request) {

                $user = $this->repository->findByID(
                    $request->route('user')
                );

                Gate::authorize('delete-user', $user->created_by);

                $this->repository->delete($user);

                $users = $this->repository->getAll();

                return response()->json([
                    'users' => $users,
                    'message' => 'Usuário excluído',
                ]);

            }, 'Erro ao deletar usuário', $request);

        } catch (AuthorizationException $e) {
            abort(403, 'Você não tem permissão para fazer esta ação.');
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $this->dalleAdmService->updateProfile($request);

            return response()->json([
                'message' => 'Perfil atualizado',
            ]);

        }, 'Erro ao atualizar perfil', $request);
    }

    public function updatePasswordProfile(UpdatePasswordUserRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $this->dalleAdmService->updatePasswordProfile($request);

            return response()->json([
                'message' => 'Senha atualizada',
            ]);

        }, 'Erro ao atualizar senha', $request);
    }

    public function indexUsersByEnterprise(ShowUsersEnterpriseRequest $request)
    {
        return $this->safeExecute(function () use ($request) {

            $enterpriseId = $request->route('enterprise');

            $users = $this->userDmRepository
                ->findUsersByEnterpriseID($enterpriseId);

            return response()->json([
                'users' => $users,
            ]);

        }, 'Erro ao listar usuários da organização', $request);
    }

    public function showUserByEnterprise(ShowUserEnterpriseRequest $request)
    {
        return $this->safeExecute(function () use ($request) {

            $user = $this->userDmRepository
                ->findByID($request->route('user'));

            return response()->json([
                'user' => $user,
            ]);

        }, 'Erro ao buscar usuário da organização', $request);
    }

    public function createUserByEnterprise(CreateUserEnterpriseRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $this->dalleManageService->create($request);

            $users = $this->userDmRepository
                ->findUsersByEnterpriseID(
                    $request->route('enterprise')
                );

            return response()->json([
                'users' => $users,
                'message' => 'Usuário criado',
            ], 201);

        }, 'Erro ao criar usuário da organização', $request);
    }

    public function updateUserByEnterprise(UpdateUserEnterpriseRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $this->dalleManageService->update($request);

            $user = $this->userDmRepository
                ->findByID($request->route('user'));

            $users = $this->userDmRepository
                ->findUsersByEnterpriseID($user->enterprise_id);

            return response()->json([
                'users' => $users,
                'message' => 'Usuário atualizado',
            ]);

        }, 'Erro ao atualizar usuário da organização', $request);
    }

    public function deleteUserByEnterprise(DeleteUserEnterpriseRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $user = $this->userDmRepository
                ->findByID($request->route('user'));

            $enterpriseId = $user->enterprise_id;

            $this->userDmRepository
                ->delete($request->route('user'));

            $users = $this->userDmRepository
                ->findUsersByEnterpriseID($enterpriseId);

            return response()->json([
                'users' => $users,
                'message' => 'Usuário deletado',
            ]);

        }, 'Erro ao deletar usuário da organização', $request);
    }
}
