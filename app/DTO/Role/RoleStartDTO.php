<?php

namespace App\DTO\Role;

class RoleStartDTO
{
    public function __construct(
        public string $name,
        public array $permissions,
        public string $enterprise_id
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
            name: 'Master',
            enterprise_id: $data['enterpriseID'],
            permissions: []
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'enterprise_id' => $this->enterprise_id,
            'permissions' => json_encode($this->permissions),
        ];
    }
}
