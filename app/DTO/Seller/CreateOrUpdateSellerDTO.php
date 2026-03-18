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
        public int $commission,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            commission: $data['commission'],
            code: $data['code'],
        );
    }
}
