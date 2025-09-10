<?php

namespace App\Services\DalleAdm;

use App\DTO\User\UpdateDataProfileDTO;
use App\DTO\User\UpdatePasswordProfileDTO;
use App\Helpers\UserHelper;
use App\Jobs\SendResetPasswordEmail;
use App\Models\DalleAdm\PasswordResetToken;
use App\Repositories\DalleAdm\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function __construct(
        protected UserRepository $repository,
    ) {}

    public function login($request)
    {
        $user = $this->repository->findByEmail($request->email);

        $this->hasUser($user);
        UserHelper::checkPassword($user, $request->password);

        return $user;
    }

    public function reset($request)
    {
        $user = $this->repository->findByEmail($request->email);

        if ($user) {
            $token = app('auth.password.broker')->createToken($user);
            SendResetPasswordEmail::dispatch($user, $token);
        }

        return 'Caso o e-mail esteja em nossos registro, você receberá um email para a redefinição de senha';
    }

    private function hasUser($user)
    {
        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Credenciais não constam em nosso registro.'],
            ]);
        }
    }

    public function updateDataProfile($request)
    {
        UserHelper::existsEmail(
            $request->user(),
            $request->email,
        );

        $profileDataDTO = UpdateDataProfileDTO::fromRequest(
            $request->only(['name', 'email']),
        );

        return $this->repository->update($request->user()->id, $profileDataDTO->toArray());
    }

    public function updatePasswordProfile($request)
    {
        UserHelper::isPasswordEqual(
            $request->user(),
            $request->currentPassword
        );

        $profilePasswordDTO = UpdatePasswordProfileDTO::fromRequest([
            'password' => Hash::make($request->password),
        ]);

        return $this->repository->update($request->user()->id, $profilePasswordDTO->toArray());
    }

    public function newPassword($request)
    {
        $register = PasswordResetToken::where('token', $request->input('token'))->first();

        if (! $register) {
            return response()->json(['error' => 'Token inválido.'], 400);
        }

        $isExpired = Carbon::parse($register->created_at)->addMinutes(30)->isPast();

        if ($isExpired) {
            throw ValidationException::withMessages([
                'token' => ['Token expirado'],
            ]);
        }

        $data = ['password' => Hash::make($request->input('password'))];

        $result = $this->repository->newPassword($register->email, $data);

        $register->delete();

        return $result;
    }
}
