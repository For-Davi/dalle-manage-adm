<?php

namespace App\Repositories\DalleAdm;

use App\Models\DalleManage\EnterpriseDM;

class EnterpriseRepository
{
    public function __construct(public EnterpriseDM $model) {}

    public function create($data)
    {
        return $this->model->create($data);
    }
}
