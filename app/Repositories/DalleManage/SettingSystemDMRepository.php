<?php

namespace App\Repositories\DalleManage;

use App\Models\DalleManage\SettingSystemDM;

class SettingSystemDMRepository
{
    public function __construct(protected SettingSystemDM $model) {}

    public function create($data)
    {
        return $this->model->create($data);
    }
}
