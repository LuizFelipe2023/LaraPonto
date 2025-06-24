<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Setor;

class SetorSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('tipo_usuario', 2)->count() < 3) {
            User::factory(3)->create([
                'tipo_usuario' => 2,
            ]);
        }
        Setor::factory(5)->create();
    }
}
