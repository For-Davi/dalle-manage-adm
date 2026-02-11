<?php

namespace App\Http\Requests\User\DalleManage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShowUserEnterpriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $enterpriseId = $this->route('enterprise');

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
        ];
    }

    public function messages(): array
    {
        return [
            'enterprise.required' => 'O ID da empresa é obrigatório.',
            'enterprise.exists' => 'A empresa informada não existe.',

            'user.required' => 'O ID do usuário é obrigatório.',
            'user.exists' => 'Usuário não encontrado para esta empresa.',
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
