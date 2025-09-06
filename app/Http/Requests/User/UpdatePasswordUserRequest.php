<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'currentPassword' => 'required|string|min:8',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'currentPassword.required' => 'Deve ser informado a senha atual',
            'currentPassword.string' => 'A senha atual deve ser uma string',
            'currentPassword.min' => 'A senha atual não pode ter menos de 8 caracteres',
            'password.required' => 'Deve ser informado a nova senha',
            'password.string' => 'A nova senha deve ser uma string',
            'password.min' => 'A nova senha não pode ter menos de 8 caracteres',
        ];
    }
}
