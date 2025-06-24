<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Funcionario;
use App\Models\User;

class FuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        if (User::whereIn('tipo_usuario', [2, 3])->count() < 5) {
            User::factory(3)->create(['tipo_usuario' => 2]);
            User::factory(5)->create(['tipo_usuario' => 3]);
        }

        Funcionario::factory(10)->create();
    }
}
