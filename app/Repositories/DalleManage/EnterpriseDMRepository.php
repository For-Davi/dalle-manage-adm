<?php

namespace App\Repositories\DalleManage;

use App\Models\DalleManage\EnterpriseDM;

class EnterpriseDMRepository
{
    public function __construct(public EnterpriseDM $model) {}

    public function getAll()
    {
        return $this->model->all();
    }
}
