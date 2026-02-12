<?php

namespace App\Repositories\DalleAdm;

use App\Models\DalleAdm\Registration;

class RegistrationRepository
{
    public function __construct(public Registration $model) {}

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
        $registration = $this->findById($id);

        if ($registration) {
            $registration->update($data);

            return $registration;
        }

        return null;
    }

    public function delete($id)
    {
        $registration = $this->findById($id);

        if ($registration) {
            $registration->delete();

            return $registration;
        }

        return null;
    }
}
