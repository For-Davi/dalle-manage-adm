<?php

namespace App\DTO\Seller;

class CreateOrUpdateSellerDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $code,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            code: $data['code']
        );
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'code' => $this->code,
        ];

        return $data;
    }
}
