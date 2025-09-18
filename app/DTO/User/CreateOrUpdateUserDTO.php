<?php

namespace App\DTO\User;

class CreateOrUpdateUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null
        );
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password !== null) {
            $data['password'] = $this->password;
        }

        return $data;
    }
}
