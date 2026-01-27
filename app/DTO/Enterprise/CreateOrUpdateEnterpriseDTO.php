<?php

namespace App\DTO\Enterprise;

use App\DTO\BaseDTO;

class CreateOrUpdateEnterpriseDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public ?string $email,
        public ?string $phone,
        public ?string $cnpj,
        public ?string $cpf,
        public ?string $cep,
        public ?string $state,
        public ?string $city,
        public ?string $neighborhood,
        public ?string $address,
        public ?string $number_address,
        public ?string $complement,
        public int $subscription_id,
        public int $active,
        public ?int $seller_id,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            cnpj: $data['cnpj'] ?? null,
            cpf: $data['cpf'] ?? null,
            cep: $data['cep'] ?? null,
            state: $data['state'] ?? null,
            city: $data['city'] ?? null,
            neighborhood: $data['neighborhood'] ?? null,
            address: $data['address'] ?? null,
            complement: $data['complement'] ?? null,
            number_address: $data['numberAddress'] ?? null,
            subscription_id: $data['subscriptionId'],
            active: array_key_exists('active', $data) ? (int) $data['active'] : 1,
            seller_id: $data['sellerID'] ?? null,
        );
    }
}
