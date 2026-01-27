<?php

namespace App\DTO\User;

use App\DTO\BaseDTO;

class UpdatePasswordProfileDTO extends BaseDTO
{
    public function __construct(
        public string $password,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            password: $data['password'],
        );
    }
}
