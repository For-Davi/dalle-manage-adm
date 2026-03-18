<?php

namespace App\Http\Requests\Seller\Registration;

use Illuminate\Foundation\Http\FormRequest;

class ApproveSellerRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'registration' => 'required|exists:registrations,id',
            'code' => 'required|string|min:8|max:20',
            'commission' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'registration.required' => 'O ID da inscrição é obrigatório.',
            'registration.exists' => 'O ID da inscrição informado não existe.',
            'code.required' => 'O código é obrigatório',
            'code.string' => 'O código deve ser um texto válido',
            'code.min' => 'O código deve ter pelo menos 8 caracteres',
            'code.max' => 'O código não pode ultrapassar 20 caracteres',
            'commission.required' => 'A comissão é obrigatória',
            'commission.numeric' => 'A comissão deve ser um número',
            'commission.min' => 'A comissão mínima é de 0%',
            'commission.max' => 'A comissão máxima é de 100%',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
