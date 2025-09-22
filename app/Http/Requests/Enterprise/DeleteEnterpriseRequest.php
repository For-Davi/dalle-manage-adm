<?php

namespace App\Http\Requests\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class DeleteEnterpriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:dalle_manage.enterprises,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID da empresa é obrigatório.',
            'id.exists' => 'O ID da empresa informada não existe.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
