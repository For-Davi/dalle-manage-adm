<?php

namespace App\DTO\Enterprise;

use App\DTO\BaseDTO;

class UpdateEnterpriseUserDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $email,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
        );
    }
}
