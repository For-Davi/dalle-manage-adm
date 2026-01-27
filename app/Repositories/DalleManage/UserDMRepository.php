<?php

namespace App\Repositories\DalleManage;

use App\Models\DalleManage\UsersDM;
use Illuminate\Support\Facades\DB;

class UserDMRepository
{
    public function __construct(public UsersDM $model) {}

    public function findUsersByEnterpriseID($id)
    {
        return $this->model->where('enterprise_id', $id)->get();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function findByID($id)
    {
        return $this->model->find($id);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function createUserWithEnterpriseId(int $enterpriseID, array $data)
    {
        $data['enterprise_id'] = $enterpriseID;

        return $this->model->create($data);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->findById($id);
        if ($user) {
            $user->update($data);

            return $user;
        }

        return null;
    }

    public function delete($id)
    {
        $user = $this->findById($id);
        if ($user) {
            DB::connection('dalle_manage')->table('employees')->where('user_id', $id)->delete();
            DB::connection('dalle_manage')->table('notifications')->where('user_id', $id)->delete();
            DB::connection('dalle_manage')->table('product_movements')->where('created_by', $id)
                ->whereNotNull('created_by')
                ->update(['created_by' => null]);

            return $user->delete();
        }

        return null;
    }
}
