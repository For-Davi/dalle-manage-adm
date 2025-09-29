<?php

namespace App\Models\DalleAdm;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $table = 'sellers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'code',
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
