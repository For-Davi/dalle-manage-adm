<?php

namespace App\Models\DalleManage;

use Illuminate\Database\Eloquent\Model;

class EnterpriseDM extends Model
{
    protected $connection = 'dalle_manage';

    protected $table = 'enterprises';

    public function subscription()
    {
        return $this->belongsTo(SubscriptionsDM::class, 'subscription_id');
    }
}
