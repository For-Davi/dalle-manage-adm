<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\DalleAdm\NewPasswordRequest;
use App\Http\Requests\User\DalleAdm\ResetPasswordRequest;
use App\Repositories\DalleAdm\UserRepository;
use App\Services\DalleAdm\UserService;
use App\Utils\ErrorLogger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AuthController
{
    public function __construct(
        protected UserService $service,
        protected UserRepository $repository
    ) {}

    public function showAuthForm()
    {
        return Inertia::render('Auth');
    }

    public function showResetForm($token)
    {
        return Inertia::render('ResetPassword', [
            'token' => $token,
        ]);
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
