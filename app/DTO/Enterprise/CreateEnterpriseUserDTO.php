<?php

namespace App\DTO\Enterprise;

class CreateEnterpriseUserDTO
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

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->role_id,
        ];

        return $data;
    }
}
