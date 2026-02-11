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
            'user' => 'required|exists:users,id',
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => 'O ID do usuário é obrigatório.',
            'user.exists' => 'O ID do usuário informado não existe.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'O nome não pode ultrapassar 30 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto válido.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.max' => 'O e-mail não pode ultrapassar 50 caracteres.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
