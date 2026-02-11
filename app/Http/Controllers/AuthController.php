<?php

namespace App\Http\Controllers;

use App\Helpers\UserHelper;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\User\DalleAdm\NewPasswordRequest;
use App\Http\Requests\User\DalleAdm\ResetPasswordRequest;
use App\Repositories\DalleAdm\UserRepository;
use App\Services\DalleAdm\UserService;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function __construct(
        protected UserService $service,
        protected UserRepository $repository
    ) {}

    public function login(LoginRequest $request)
    {
        return $this->safeExecute(function () use ($request) {

            $result = $this->service->login($request);

            return response()->json([
                'token' => $result['token'],
                'user' => $result['user'],
            ]);

        }, 'Erro ao realizar login', $request);
    }

    public function logout(Request $request)
    {
        return $this->safeExecute(function () use ($request) {

            UserHelper::clearTokenReset($request->user());

            return response()->json([], 200);

        }, 'Erro inesperado no logout', $request);
    }

    public function reset(ResetPasswordRequest $request)
    {
        return $this->safeExecute(function () use ($request) {

            $result = $this->service->reset($request);

            return redirect()
                ->back()
                ->with('message', $result);

        }, 'Erro ao solicitar redefinição de senha', $request);
    }

    public function resetPassword(NewPasswordRequest $request)
    {
        return $this->safeTransaction(function () use ($request) {

            $user = $this->service->newPassword($request);

            if ($user) {
                return redirect()->route('login');
            }

            return back()
                ->withErrors([
                    'password' => 'Erro ao atualizar senha.',
                ])
                ->onlyInput('password');

        }, 'Erro ao redefinir senha', $request);
    }
}
