<?php

namespace App\Repositories\DalleManage;

use App\Models\DalleManage\SettingAppearanceDM;

class SettingAppearanceDMRepository
{
    public function __construct(protected SettingAppearanceDM $model) {}

    public function create($data)
    {
        return $this->model->create($data);
    }
}
