<?php

namespace App\Repositories;

use App\DTO\User\FilterUserDTO;
use App\Models\User;

class UserRepository
{
    public function __construct(public User $model) {}

    public function getAll()
    {
        return $this->model->all();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }
}
