<?php

namespace App\Http\Requests\User\DalleAdm;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:users,id',
            'changePassword' => 'required|in:0,1',
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|max:50',
            'currentPassword' => 'nullable|string|min:8',
            'password' => 'nullable|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID do usuário é obrigatório.',
            'id.exists' => 'O ID do usuário informado não existe.',
            'changePassword.required' => 'O campo de alteração de senha é obrigatório.',
            'changePassword.in' => 'O campo de alteração de senha deve ser 0  ou 1.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'O nome não pode ultrapassar 30 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto válido.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.max' => 'O e-mail não pode ultrapassar 50 caracteres.',
            'currentPassword.string' => 'A senha atual deve ser um texto válido.',
            'currentPassword.min' => 'A senha atual deve ter no mínimo 8 caracteres.',
            'password.string' => 'A senha deve ser um texto válido.',
            'password.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
