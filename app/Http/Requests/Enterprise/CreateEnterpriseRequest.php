<?php

namespace App\Http\Requests\Enterprise;

use Illuminate\Foundation\Http\FormRequest;

class CreateEnterpriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:100',
            'email' => 'nullable|email|max:100',
            'cpf' => 'nullable|numeric',
            'cnpj' => 'nullable|numeric',
            'phone' => 'nullable|string|max:20',
            'state' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:50',
            'cep' => 'nullable|numeric',
            'neighborhood' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:100',
            'numberAddress' => 'nullable|numeric',
            'complement' => 'nullable|string|max:100',
            'subscriptionID' => 'required|integer',
            'sellerID' => 'nullable|exists:sellers,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da empresa é obrigatório.',
            'name.string' => 'O nome da empresa deve ser um texto.',
            'name.min' => 'O nome da empresa deve ter pelo menos 1 caractere.',
            'name.max' => 'O nome da empresa não pode exceder 100 caracteres.',

            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.max' => 'O e-mail não pode exceder 100 caracteres.',

            'cpf.numeric' => 'O CPF deve conter apenas números.',

            'cnpj.numeric' => 'O CNPJ deve conter apenas números.',

            'phone.string' => 'O telefone deve ser um texto.',
            'phone.max' => 'O telefone não pode exceder 20 caracteres.',

            'state.string' => 'O estado deve ser um texto.',
            'state.max' => 'O estado não pode exceder 20 caracteres.',

            'city.string' => 'A cidade deve ser um texto.',
            'city.max' => 'A cidade não pode exceder 50 caracteres.',

            'cep.numeric' => 'O CEP deve conter apenas números.',

            'neighborhood.string' => 'O bairro deve ser um texto.',
            'neighborhood.max' => 'O bairro não pode exceder 50 caracteres.',

            'address.string' => 'O endereço deve ser um texto.',
            'address.max' => 'O endereço não pode exceder 100 caracteres.',

            'numberAddress.numeric' => 'O número deve ser do tipo número',

            'complement.string' => 'O complemento deve ser um texto',
            'complement.max' => 'O complemento não pode exceder 100 caracteres',

            'subscriptionId.required' => 'Deve ser requerido o ID da assinatura',
            'subscriptionId.integer' => 'O ID da assinatura deve ser um número',

            'sellerID.string' => 'O ID do vendedor informado não existe.',
        ];
    }
}
