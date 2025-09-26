<?php

namespace App\Http\Requests\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class ShowUsersEnterpriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'enterpriseID' => 'required|exists:dalle_manage.enterprises,id',
        ];
    }

    public function messages(): array
    {
        return [
            'enterpriseID.required' => 'O ID da empresa é obrigatório.',
            'enterpriseID.exists' => 'O ID da empresa informada não existe.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
