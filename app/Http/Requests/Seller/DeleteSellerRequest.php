<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:sellers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID do(a) vendedor(a) é obrigatório.',
            'id.exists' => 'O ID  do(a) vendedor(a) informado(a) não existe.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
