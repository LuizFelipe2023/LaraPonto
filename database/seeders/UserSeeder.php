<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador do Sistema',
            'email' => 'admin@empresa.com',
            'password' => Hash::make('admin123'),
            'tipo_usuario' => 1, 
        ]);

        User::factory(3)->create([
            'tipo_usuario' => 2, 
        ]);

        User::factory(10)->create([
            'tipo_usuario' => 3, 
        ]);
    }
}
