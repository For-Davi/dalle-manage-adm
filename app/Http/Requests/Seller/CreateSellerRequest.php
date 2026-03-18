<?php

namespace App\Http\Requests\Seller;

use Illuminate\Foundation\Http\FormRequest;

class CreateSellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|max:50|unique:sellers,email',
            'phone' => 'required|string|max:20',
            'commission' => 'required|numeric|min:0|max:100',
            'code' => 'required|string|min:8|max:20|unique:sellers,code',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser um texto válido',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres',
            'name.max' => 'O nome não pode ultrapassar 30 caracteres',
            'email.required' => 'O e-mail é obrigatório',
            'email.email' => 'O e-mail deve ser um endereço válido',
            'email.max' => 'O e-mail não pode ultrapassar 50 caracteres',
            'email.unique' => 'Este e-mail já está sendo utilizado',
            'phone.required' => 'O telefone é obrigatório',
            'phone.max' => 'O telefone não pode ultrapassar 20 caracteres',
            'commission.required' => 'A comissão é obrigatória',
            'commission.numeric' => 'A comissão deve ser um número',
            'commission.min' => 'A comissão mínima é de 0%',
            'commission.max' => 'A comissão máxima é de 100%',
            'code.required' => 'O código é obrigatório',
            'code.min' => 'O código deve ter pelo menos 8 caracteres',
            'code.max' => 'O código não pode ultrapassar 20 caracteres',
            'code.unique' => 'Este código já está em uso',
        ];
    }
}
