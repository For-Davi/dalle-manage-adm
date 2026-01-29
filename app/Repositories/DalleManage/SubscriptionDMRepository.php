<?php

namespace App\Repositories\DalleManage;

use App\Models\DalleManage\SubscriptionDM;

class SubscriptionDMRepository
{
    public function __construct(
        public SubscriptionDM $model,
    ) {}

    public function getAll()
    {
        return $this->model->all();
    }

    public function getAllEnterprisesBySubscriptions()
    {
        return $this->model->withCount('enterprises')->get();
    }
}
