<?php

namespace App\Repositories\DalleAdm;

use App\Models\DalleManage\EnterpriseDM;
use Illuminate\Support\Facades\DB;

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

    public function delete($enterprise)
    {
        if ($enterprise) {
            $enterpriseId = $enterprise->id;

            $roleIds = DB::connection('dalle_manage')
                ->table('roles')
                ->where('enterprise_id', $enterpriseId)
                ->pluck('id');
            if ($roleIds->isNotEmpty()) {
                DB::connection('dalle_manage')
                    ->table('users')
                    ->whereIn('role_id', $roleIds)
                    ->delete();
            }
            DB::connection('dalle_manage')
                ->table('roles')
                ->where('enterprise_id', $enterpriseId)
                ->delete();
            DB::connection('dalle_manage')
                ->table('setting_appearance')
                ->where('enterprise_id', $enterpriseId)
                ->delete();

            $enterprise->delete();

            return true;
        }

        return false;
    }
}
