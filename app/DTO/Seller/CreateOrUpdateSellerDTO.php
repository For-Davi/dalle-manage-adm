<?php

namespace App\DTO\Seller;

use App\DTO\BaseDTO;

class CreateOrUpdateSellerDTO extends BaseDTO
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
}
