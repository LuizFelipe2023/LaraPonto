<?php

namespace Database\Seeders;

use App\Models\StatusFuncionario;
use Illuminate\Database\Seeder;

class StatusFuncionarioSeeder extends Seeder
{
    public function run(): void
    {
        $status = [
            ['nome' => 'Ativo', 'descricao' => 'Funcionário ativo e trabalhando'],
            ['nome' => 'Desligado', 'descricao' => 'Funcionário desligado da empresa'],
            ['nome' => 'Afastado', 'descricao' => 'Afastamento temporário'],
            ['nome' => 'Férias', 'descricao' => 'Em período de férias'],
        ];

        foreach ($status as $s) {
            StatusFuncionario::create($s);
        }
    }
}
