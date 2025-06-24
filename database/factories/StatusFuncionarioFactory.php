<?php

namespace Database\Factories;

use App\Models\StatusFuncionario;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFuncionarioFactory extends Factory
{
    protected $model = StatusFuncionario::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->word(),
            'descricao' => $this->faker->sentence(),
        ];
    }
}
