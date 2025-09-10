<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFromDM extends Model
{
    protected $connection = 'dalle_manage'; 
    protected $table = 'users';        
}
