<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class ShowSellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seller' => 'required|exists:sellers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'seller.required' => 'O ID do(a) vendedor(a) é obrigatório.',
            'seller.exists' => 'O ID do(a) vendedor(a) informado(a) não existe.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
