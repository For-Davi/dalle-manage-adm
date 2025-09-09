<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\NewPasswordRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\UpdateDataUserRequest;
use App\Http\Requests\User\UpdatePasswordUserRequest;
use App\Services\UserService;
use App\Utils\ErrorLogger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class UserController
{
    public function __construct(
        protected UserService $service
    ) {}

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

    public function updateData(UpdateDataUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->service->updateDataProfile($request);

            if ($user) {
                DB::commit();

                return inertia()->location(url()->previous());
            }
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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

        } catch (\Exception $e) {
            ErrorLogger::log('Erro ao solicitar redefinição de senha', $e, $request);

            return back()->withErrors([
                'error' => 'Ocorreu um erro no servidor. Por favor, tente novamente.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Erro ao solicitar redefinição de senha.',
        ])->onlyInput('email');
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
        } catch (\Exception $e) {
            DB::rollBack();

            ErrorLogger::log('Erro ao redefinir senha', $e, $request);

            return response()->json(['message' => $e->getMessage()], 500);
        }

        return back()->withErrors([
            'password' => 'Erro ao atualizar senha.',
        ])->onlyInput('password');
    }
}
