<?php

namespace App\Models\DalleManage;

use Illuminate\Database\Eloquent\Model;

class RolesDM extends Model
{
    protected $connection = 'dalle_manage';

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'enterprise_id',
    ];

    public function enterprise()
    {
        return $this->belongsTo(EnterpriseDM::class, 'enterprise_id');
    }
}
