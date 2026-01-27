<?php

namespace App\DTO\Enterprise;

use App\DTO\BaseDTO;

class CreateEnterpriseUserDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public int $role_id,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            role_id: $data['roleID']
        );
    }
}
