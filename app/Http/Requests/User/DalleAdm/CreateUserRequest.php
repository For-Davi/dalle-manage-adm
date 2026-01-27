<?php

namespace App\Http\Requests\User\DalleAdm;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser um texto válido',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres',
            'name.max' => 'O nome não pode ultrapassar 30 caracteres',
            'email.required' => 'O e-mail é obrigatório',
            'email.string' => 'O e-mail deve ser um texto válido',
            'email.email' => 'O e-mail deve ser um endereço válido',
            'email.max' => 'O e-mail não pode ultrapassar 50 caracteres',
            'password.required' => 'A senha é obrigatória',
            'password.string' => 'A senha deve ser um texto válido',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
        ];
    }
}
