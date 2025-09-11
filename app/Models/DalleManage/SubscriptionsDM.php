<?php

namespace App\Models\DalleManage;

use Illuminate\Database\Eloquent\Model;

class SubscriptionsDM extends Model
{
    protected $connection = 'dalle_manage';

    protected $table = 'subscriptions';

    public function enterprises()
    {
        return $this->hasMany(EnterpriseDM::class, 'subscription_id');
    }
}
