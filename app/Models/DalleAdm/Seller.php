<?php

namespace App\Models\DalleAdm;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'sellers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'code',
        'cpf',
        'password',
        'commission',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
}
