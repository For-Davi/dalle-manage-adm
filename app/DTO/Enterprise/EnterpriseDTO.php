<?php

namespace App\DTO\Enterprise;

class EnterpriseDTO
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
        public ?string $complement,
        public int $subscription_id
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
            address: $data['numberAddress'] ?? null,
            complement: $data['complement'] ?? null,
            subscription_id: $data['subscriptionId'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'cnpj' => $this->cnpj,
            'cpf' => $this->cpf,
            'cep' => $this->cep,
            'state' => $this->state,
            'city' => $this->city,
            'neighborhood' => $this->neighborhood,
            'address' => $this->address,
            'complement' => $this->complement,
            'subscription_id' => $this->subscription_id,
        ];
    }
}
