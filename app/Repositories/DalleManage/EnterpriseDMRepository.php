<?php

namespace App\Repositories\DalleManage;

use App\Models\DalleManage\EnterpriseDM;

class EnterpriseDMRepository
{
    public function __construct(public EnterpriseDM $model) {}

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function getAll(array $relations = [])
    {
        if (! empty($relations)) {
            return $this->model->with($relations)->get();
        }

        return $this->model->all();
    }
}
