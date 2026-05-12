<?php

namespace App\Http\Resources\Registration;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cpf' => $this->cpf,
            'code' => $this->code,
            'commission' => $this->commission,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
