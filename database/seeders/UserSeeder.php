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
            'name' => 'Usuário',
            'email' => 'useremail@gmail.com',
            'password' => Hash::make('usersenha123456'),
            'role' => 'super_admin',
        ]);
    }
}
