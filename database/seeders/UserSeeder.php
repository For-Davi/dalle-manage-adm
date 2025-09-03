<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Usuário',
            'email' => 'useremail@gmail.com',
            'password' => Hash::make('usersenha123456'), 
        ]);
    }
}
