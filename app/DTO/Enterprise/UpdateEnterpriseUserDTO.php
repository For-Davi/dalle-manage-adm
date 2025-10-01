<?php

namespace App\DTO\Enterprise;

class UpdateEnterpriseUserDTO
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

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        return $data;
    }
}
