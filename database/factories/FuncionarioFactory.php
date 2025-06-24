<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Setor;
use App\Models\StatusFuncionario;

class FuncionarioFactory extends Factory
{
    public function definition(): array
    {
        $usuarios = User::whereIn('tipo_usuario', [2, 3])->pluck('id')->toArray();
        $setores = Setor::pluck('id')->toArray();
        $status = StatusFuncionario::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($usuarios),
            'setor_id' => $this->faker->randomElement($setores),
            'cargo' => $this->faker->jobTitle(),
            'salario' => $this->faker->randomFloat(2, 2000, 15000),
            'data_admissao' => $this->faker->date(),
            'data_desligamento' => $this->faker->optional()->date(),
            'status_id' => $this->faker->randomElement($status),
        ];
    }
}
