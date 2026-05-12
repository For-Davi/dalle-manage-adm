<?php

namespace App\DTO\Seller;

use App\DTO\BaseDTO;

class ApproveSellerRegistrationDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $phone,
        public string $cpf,
        public string $password,
        public string $commission,
        public string $code,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            cpf: $data['cpf'],
            password: $data['password'],
            commission: $data['commission'],
            code: $data['code'],
        );
    }
}
