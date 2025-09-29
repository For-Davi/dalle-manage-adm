<?php

namespace App\Repositories\DalleManage;

use App\Models\DalleManage\RolesDM;

class RoleDMRepository
{
    public function __construct(public RolesDM $model) {}

    public function findByName($enterpriseID, $name)
    {
        return $this->model->where(['enterprise_id' => $enterpriseID, 'name' => $name])->first();
    }

    public function start($data)
    {
        return $this->model->create($data);
    }
}
