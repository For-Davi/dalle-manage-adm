<?php

namespace App\Models\DalleAdm;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $table = 'registrations';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'cpf',
        'cnpj',
        'password',
        'description',
    ];
}
