<?php

namespace App\Repositories\DalleManage;

use App\Models\DalleManage\SubscriptionsDM;

class SubscriptionsDMRepository
{
    public function __construct(
        public SubscriptionsDM $model,
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
