<?php

namespace App\Repositories\DalleAdm;

use App\Models\DalleManage\EnterpriseDM;

class EnterpriseRepository
{
    public function __construct(public EnterpriseDM $model) {}

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $enterprise = $this->findById($id);

        if ($enterprise) {
            $enterprise->update($data);

            return $enterprise;
        }

        return null;
    }
}
