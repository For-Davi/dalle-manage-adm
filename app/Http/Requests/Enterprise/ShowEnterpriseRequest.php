<?php

namespace App\Http\Requests\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class ShowEnterpriseRequest extends FormRequest
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
            'id.exists' => 'A empresa informada não foi encontrada.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
