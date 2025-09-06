<?php

namespace App\DTO\User;

class UpdatePasswordProfileDTO
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

    public function toArray(): array
    {
        return [
            'password' => $this->password,
        ];
    }
}
