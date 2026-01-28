<?php

namespace Database\Seeders;

use App\Models\DalleAdm\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Carlos Davi',
            'email' => 'carlosdavi004@gmail.com',
            'password' => Hash::make('123456789'),
            'created_by' => 0,
        ]);
    }
}
