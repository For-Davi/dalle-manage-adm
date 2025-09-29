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
            'email' => 'required|string|email|max:50|unique:sellers',
            'phone' => 'required|string|max:20',
            'code' => 'required|string|unique:sellers|min:8|max:20',
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
            'email.string' => 'O e-mail deve ser um texto válido',
            'email.email' => 'O e-mail deve ser um endereço válido',
            'email.max' => 'O e-mail não pode ultrapassar 50 caracteres',
            'phone.required' => 'O telefone é obrigatório',
            'phone.string' => 'O telefone deve ser um texto válido',
            'phone.max' => 'O telefone não pode ultrapassar 20 caracteres',
            'code.required' => 'O código é obrigatório',
            'code.string' => 'O código deve ser um texto válido',
            'code.unique' => 'Este código já está cadastrado para outro vendedor',
            'code.min' => 'O código deve ter pelo menos 8 caracteres',
            'code.max' => 'O código não pode ultrapassar 20 caracteres',
        ];
    }
}
