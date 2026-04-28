<?php

namespace App\Http\Requests\Enterprise\Payment;

use Illuminate\Foundation\Http\FormRequest;

class FilterEnterprisePayments extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'startDate' => 'nullable|string',
            'endDate' => 'nullable|string',
            'enterprise' => 'nullable|string',
            'user' => 'nullable|string',
            'status' => 'nullable|in:PENDING,CONFIRMED|string',
        ];
    }

    public function messages(): array
    {
        return [
        'startDate.string' => 'A data inicial deve ser um texto.',
        'endDate.string' => 'A data final deve ser um texto.',
        'enterprise.string' => 'O nome da empresa deve ser um texto.',
        'user.string' => 'O nome do usuário deve ser um texto.',
        'status.string' => 'O status deve ser um texto.',
        'status.required_in' => 'O status informado é inválido. Os valores aceitos são: PENDING ou CONFIRMED.',
    ];
    }
}
