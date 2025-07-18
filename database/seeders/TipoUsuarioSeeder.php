<?php

namespace Database\Seeders;

use App\Models\TipoUsuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           TipoUsuario::factory()->create([
               'nome' => 'Admin'
           ]);
           TipoUsuario::factory()->create([
                'nome' => 'Gestor'
           ]);
           TipoUsuario::factory()->create([
                 'nome' => 'funcionario'
           ]);
    }
}
