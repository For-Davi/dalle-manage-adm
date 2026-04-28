<?php

namespace App\DTO\Enterprise\Payment;

use App\DTO\BaseDTO;

class FilterEnterprisePaymentDTO extends BaseDTO
{
    public function __construct(
        public ?string $start_date,
        public ?string $end_date,
        public ?string $enterprise,
        public ?string $status,
    ) {}

    public static function fromRequest($data): self
    {
        return new self(
        start_date: $data['startDate'] ? $data['startDate'] : null,
        end_date: $data['endDate'] !== '' ? $data['endDate'] : null,
        enterprise: $data['enterprise'] !== '' ? $data['enterprise'] : null,
        status: $data['status'] !== '' ? $data['status'] : null,
    );
    }
}
