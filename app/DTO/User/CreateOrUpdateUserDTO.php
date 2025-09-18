<?php

namespace App\DTO\User;

class CreateOrUpdateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $role,
        public ?string $password = null
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            role: $data['role'],
            password: $data['password'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => $this->password,
        ];
    }
}
