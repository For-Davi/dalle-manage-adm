<?php

namespace App\Http\Requests\User\DalleAdm;

use Illuminate\Foundation\Http\FormRequest;

class ShowUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user' => 'required|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'user.required' => 'O ID do usuário é obrigatório.',
            'user.exists' => 'O ID do usuário informado não existe.',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), $this->route()->parameters());
    }
}
