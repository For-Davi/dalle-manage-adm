<?php

namespace App\Http\Requests\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserEnterpriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'userID' => 'required|exists:dalle_manage.users,id',
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|string|email|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID do usuário é obrigatório.',
            'id.exists' => 'O ID do usuário informado não existe.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto válido.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'name.max' => 'O nome não pode ultrapassar 100 caracteres.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto válido.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.max' => 'O e-mail não pode ultrapassar 50 caracteres.',
            'email.unique' => 'Este e-mail já está registrado.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'userID' => $this->route('userID'),
        ]);
    }
}
