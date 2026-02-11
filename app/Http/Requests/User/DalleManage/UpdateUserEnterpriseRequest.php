<?php

namespace App\Http\Requests\User\DalleManage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserEnterpriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $enterpriseId = $this->route('enterprise');
        $userId = $this->route('user');

        return [
            'enterprise' => [
                'required',
                'exists:dalle_manage.enterprises,id',
            ],

            'user' => [
                'required',
                Rule::exists('dalle_manage.users', 'id')
                    ->where(fn ($q) => $q->where('enterprise_id', $enterpriseId)
                    ),
            ],

            'name' => 'required|string|min:3|max:100',

            'email' => [
                'required',
                'string',
                'email',
                'max:50',
                Rule::unique('dalle_manage.users', 'email')
                    ->ignore($userId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'enterprise.required' => 'O ID da empresa é obrigatório.',
            'enterprise.exists' => 'A empresa informada não existe.',

            'user.required' => 'O ID do usuário é obrigatório.',
            'user.exists' => 'Usuário não encontrado para esta empresa.',

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
        return array_merge(
            $this->all(),
            $this->route()->parameters()
        );
    }
}
