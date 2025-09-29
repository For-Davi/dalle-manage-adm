<?php

namespace App\Models\DalleManage;

use Illuminate\Database\Eloquent\Model;

class UsersDM extends Model
{
    protected $connection = 'dalle_manage';

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'enterprise_id',
        'role_id'
    ];

    public function enterprise()
    {
        return $this->belongsTo(EnterpriseDM::class);
    }
}
