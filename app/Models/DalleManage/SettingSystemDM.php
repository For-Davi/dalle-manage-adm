<?php

namespace App\Models\DalleManage;

use Illuminate\Database\Eloquent\Model;

class SettingSystemDM extends Model
{
    protected $connection = 'dalle_manage';

    protected $table = 'setting_system';

    protected $fillable = [
        'send_notification_stock_critical',
        'enterprise_id',
    ];

    public function enterprise()
    {
        return $this->belongsTo(EnterpriseDM::class, 'enterprise_id');
    }
}
