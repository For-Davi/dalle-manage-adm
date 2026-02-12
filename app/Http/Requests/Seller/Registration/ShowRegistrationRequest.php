<?php

namespace App\Http\Requests\Seller\Registration;

use Illuminate\Foundation\Http\FormRequest;

class ShowRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'registration' => 'required|exists:registrations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'registration.required' => 'O ID da inscrição é obrigatório.',
            'registration.exists' => 'O ID da inscrição informado não existe.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
