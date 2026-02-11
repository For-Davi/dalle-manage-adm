<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seller' => 'required|exists:sellers',
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|max:50',
            'phone' => 'required|string|max:20',
            'code' => 'required|string|min:8|max:20',
        ];
    }

    public function messages(): array
    {
        return [
            'seller.required' => 'O ID do(a) vendedor(a) é obrigatório',
            'seller.exists' => 'O ID do(a) vendedor(a) não existe',
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser um texto válido',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres',
            'name.max' => 'O nome não pode ultrapassar 30 caracteres',
            'email.required' => 'O e-mail é obrigatório',
            'email.string' => 'O e-mail deve ser um texto válido',
            'email.email' => 'O e-mail deve ser um endereço válido',
            'email.max' => 'O e-mail não pode ultrapassar 50 caracteres',
            'phone.required' => 'O telefone é obrigatório',
            'phone.string' => 'O telefone deve ser um texto válido',
            'phone.max' => 'O telefone não pode ultrapassar 20 caracteres',
            'code.required' => 'O código é obrigatório',
            'code.string' => 'O código deve ser um texto válido',
            'code.min' => 'O código deve ter pelo menos 8 caracteres',
            'code.max' => 'O código não pode ultrapassar 20 caracteres',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
