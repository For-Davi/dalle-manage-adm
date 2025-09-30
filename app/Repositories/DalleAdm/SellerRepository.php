<?php

namespace App\Repositories\DalleAdm;

use App\Models\DalleAdm\Seller;

class SellerRepository
{
    public function __construct(public Seller $model) {}

    public function getAll()
    {
        return $this->model->all();
    }

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

    public function delete($id)
    {
        $seller = $this->findById($id);

        if ($seller) {
            $seller->delete();

            return $seller;
        }

        return null;
    }
}
