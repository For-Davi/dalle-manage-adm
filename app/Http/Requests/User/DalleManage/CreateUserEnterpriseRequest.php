<?php

namespace App\Http\Requests\User\DalleManage;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserEnterpriseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'enterpriseID' => 'required|exists:dalle_manage.enterprises,id',
            'roleID' => 'required|exists:dalle_manage.roles,id',
            'departmentID' => 'nullable|exists:dalle_manage.departments,id',
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|string|email|max:50',
            'password' => 'required|string|min:8',
            'createEmployee' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'enterpriseID.required' => 'O ID da empresa é obrigatório',
            'enterpriseID.exists' => 'O ID da empresa informada não é válido',
            'name.required' => 'O nome é obrigatório',
            'name.string' => 'O nome deve ser um texto válido',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres',
            'name.max' => 'O nome não pode ultrapassar 100 caracteres',
            'email.required' => 'O e-mail é obrigatório',
            'email.string' => 'O e-mail deve ser um texto válido',
            'email.email' => 'O e-mail deve ser um endereço válido',
            'email.max' => 'O e-mail não pode ultrapassar 50 caracteres',
            'password.required' => 'A senha é obrigatória',
            'password.string' => 'A senha deve ser um texto válido',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres',
            'createEmployee.required' => 'A criação de funcionário é obrigatória',
            'createEmployee.boolean' => 'A criação de funcionário deve ser um valor booleano',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'enterpriseID' => $this->route('enterpriseID'),
        ]);
    }
}
