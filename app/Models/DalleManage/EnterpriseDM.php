<?php

namespace App\Models\DalleManage;

use Illuminate\Database\Eloquent\Model;

class EnterpriseDM extends Model
{
    protected $connection = 'dalle_manage';

    protected $table = 'enterprises';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cpf',
        'cnpj',
        'cep',
        'state',
        'city',
        'neighborhood',
        'address',
        'complement',
        'subscription_id',
        'active',
    ];

    public function subscription()
    {
        return $this->belongsTo(SubscriptionsDM::class, 'subscription_id');
    }

    public function roles()
    {
        return $this->hasMany(RolesDM::class, 'enterprise_id');
    }
}
