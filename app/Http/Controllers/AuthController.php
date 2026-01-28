<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\DalleAdm\NewPasswordRequest;
use App\Http\Requests\User\DalleAdm\ResetPasswordRequest;
use App\Repositories\DalleAdm\UserRepository;
use App\Services\DalleAdm\UserService;
use App\Utils\ErrorLogger;
use Exception;
use Illuminate\Http\Request;
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
        try {
            $result = $this->service->login($request);

            return response()->json([
                'token' => $result['token'],
                'user' => $result['user'],
            ]);

        } catch (\Exception $e) {
            ErrorLogger::critical('Erro inesperado no login', $e, $request);

            return response()->json(['message' => 'Erro ao realizar login'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            UserHelper::clearTokenReset($request->user());

            return response()->json([], 200);
        } catch (\Exception $e) {
            ErrorLogger::critical('Erro inesperado no logout', $e, $request);

            return response()->json(['message' => 'Erro'], 500);
        }
    }

    public function reset(ResetPasswordRequest $request)
    {
        try {
            $result = $this->service->reset($request);

            return redirect()->back()->with('message', $result);
        } catch (Exception $e) {
            ErrorLogger::critical('Erro ao solicitar redefinição de senha', $e, $request);

            return back()->withErrors([
                'message' => 'Ocorreu um erro no servidor. Por favor, tente novamente.',
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

            ErrorLogger::critical('Erro ao redefinir senha', $e, $request);

            return response()->json(['message' => $e->getMessage()], 500);
        }

        return back()->withErrors([
            'password' => 'Erro ao atualizar senha.',
        ])->onlyInput('password');
    }
}
