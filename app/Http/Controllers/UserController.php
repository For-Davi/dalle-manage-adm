<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\NewPasswordRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\UpdateDataUserRequest;
use App\Http\Requests\User\UpdatePasswordUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Repositories\DalleAdm\UserRepository;
use App\Services\DalleAdm\UserService;
use App\Utils\ErrorLogger;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class UserController
{
    public function __construct(
        protected UserService $service,
        protected UserRepository $repository
    ) {}

    public function index()
    {
        $users = $this->repository->getAll();

        if ($users) {
            return Inertia::render('Users', [
                'users' => $users,
                'flash' => [
                    'success' => session('success'),
                    'error' => session('error'),
                ],
            ]);
        }
    }

    public function create(CreateUserRequest $request)
    {
        try {

            DB::beginTransaction();

            $user = $this->service->create($request);

            if ($user) {
                DB::commit();

                return redirect()->route('users')->with('success', 'Usuário criado com sucesso');
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::log('Erro ao criar usuário', $e, $request);

            return response()->json(['message' => $e->getMessage()], 500);
        }

        return back()->withErrors([
            'name' => 'Erro ao criar usuário.',
        ])->onlyInput('name');
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->route('dashboard');
            }
        } catch (Exception $e) {
            return back()->withErrors([
                'error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.',
            ]);
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function update(UpdateUserRequest $request)
    {
        try {

            DB::beginTransaction();

            $user = $this->service->update($request);

            if ($user) {
                DB::commit();

                return redirect()->route('users')->with('success', 'Usuário atualizado com sucesso');
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::log('Erro ao atualizar usuário', $e, $request);

            return back()->withErrors([
                'currentPassword' => 'A senha atual está incorreta.',
            ]);

        }

        return back()->withErrors([
            'name' => 'Erro ao atualizar usuário.',
        ])->onlyInput('name');
    }

    public function delete(DeleteUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->repository->findById($request->route('id'));

            if ($user) {
                Gate::authorize('delete-user', $user->created_by);

                $this->repository->delete($user);

                DB::commit();

                return redirect()->route('users')->with('success', 'Usuário deletado com sucesso');
            }
        } catch (AuthorizationException $e) {
            DB::rollBack();
            abort(403, 'VOCÊ NÃO TEM PERMISSÃO PARA FAZER ESTA AÇÃO.');
        } catch (\Exception $e) {
            DB::rollBack();
            ErrorLogger::log('Erro ao deletar usuário', $e, $request);

            return back()->withErrors(['name' => 'Erro ao deletar usuário.'])->onlyInput('name');
        }

        return redirect()->route('users')->with('error', 'Erro ao deletar usuário');
    }

    public function updateData(UpdateDataUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->service->updateDataProfile($request);

            if ($user) {
                DB::commit();

                return inertia()->location(url()->previous());
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::log('Erro ao atualizar dados', $e, $request);

            return back()->withErrors([
                'error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Erro ao atualizar dados.',
        ])->onlyInput('email');
    }

    public function updatePassword(UpdatePasswordUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $password = $this->service->updatePasswordProfile($request);

            if ($password) {
                DB::commit();

                return inertia()->location(url()->previous());
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::log('Erro ao atualizar senha', $e, $request);

            return back()->withErrors([
                'password' => $e->getMessage(),
            ]);
        }

        return back()->withErrors([
            'password' => 'Erro ao atualizar senha.',
        ])->onlyInput('password');
    }

    public function reset(ResetPasswordRequest $request)
    {
        try {
            $result = $this->service->reset($request);

            return redirect()->back()->with('message', $result);
        } catch (Exception $e) {
            ErrorLogger::log('Erro ao solicitar redefinição de senha', $e, $request);

            return back()->withErrors([
                'error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.',
            ])->withInput();
        }
    }

    public function showResetForm($token)
    {
        return Inertia::render('ResetPassword', [
            'token' => $token,
        ]);
    }

    public function resetPassword(NewPasswordRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->service->newPassword($request);

            if ($user) {
                DB::commit();

                return redirect()->route('login');
            }
        } catch (Exception $e) {
            DB::rollBack();

            ErrorLogger::log('Erro ao redefinir senha', $e, $request);

            return response()->json(['message' => $e->getMessage()], 500);
        }

        return back()->withErrors([
            'password' => 'Erro ao atualizar senha.',
        ])->onlyInput('password');
    }
}
