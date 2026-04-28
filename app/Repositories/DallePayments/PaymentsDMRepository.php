<?php

namespace App\Repositories\DallePayments;

use App\DTO\Enterprise\Payment\FilterEnterprisePaymentDTO;
use App\Models\DallePayments\PaymentsDM;
use App\Models\DalleManage\EnterpriseDM;
use App\Models\DalleManage\UsersDM;
use Carbon\Carbon;

class PaymentsDMRepository
{
    public function __construct(public PaymentsDM $model) {}

    public function getAll()
    {
        return $this->model->get();
    }

    public function getAllWithFilter(FilterEnterprisePaymentDTO $filter)
{
    $query = $this->model->newQuery();

    $hasStart = !empty($filter->start_date);
    $hasEnd   = !empty($filter->end_date);

    if ($hasStart && !$hasEnd) {
        $start = Carbon::createFromFormat('d/m/Y', $filter->start_date)
            ->startOfDay()
            ->addHours(3);

        $query->where('created_at', '>=', $start);
    }

    if ($hasEnd && !$hasStart) {
        $end = Carbon::createFromFormat('d/m/Y', $filter->end_date)
            ->endOfDay()
            ->addHours(3);

        $query->where('created_at', '<=', $end);
    }

    if ($hasStart && $hasEnd) {
        $start = Carbon::createFromFormat('d/m/Y', $filter->start_date)
            ->startOfDay()
            ->addHours(3);

        $end = Carbon::createFromFormat('d/m/Y', $filter->end_date)
            ->endOfDay()
            ->addHours(3);

        $query->whereBetween('created_at', [$start, $end]);
    }

     if (! empty($filter->enterprise)) {
        $enterpriseIds = EnterpriseDM::where('name', $filter->enterprise)->pluck('id');

        $userIds = UsersDM::whereIn('enterprise_id', $enterpriseIds)->pluck('id');

        $query->whereIn('user_id', $userIds);
    }

    if (! empty($filter->status)) {
        $query->where('status', $filter->status);
    }

    return $query->get();
}
}
