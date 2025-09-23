<?php

namespace App\DTO\Enterprise;

class CreateOrUpdateEnterpriseDTO
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
        public int $active
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
            active: array_key_exists('active', $data) ? (int) $data['active'] : 1
        );
    }

    public function toArray(): array
    {
        $data = array_filter([
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
            'number_address' => $this->number_address,
            'complement' => $this->complement,
            'subscription_id' => $this->subscription_id,
        ], fn ($value) => ! is_null($value) && $value !== '');
        $data['active'] = $this->active;

        return $data;
    }
}
