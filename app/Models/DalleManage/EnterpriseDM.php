<?php

namespace App\Models\DalleManage;

use App\Models\DalleAdm\Seller;
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
        'number_address',
        'complement',
        'subscription_id',
        'active',
        'seller_id',
    ];

    public function subscription()
    {
        return $this->belongsTo(SubscriptionDM::class, 'subscription_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function roles()
    {
        return $this->hasMany(RolesDM::class, 'enterprise_id');
    }
}
