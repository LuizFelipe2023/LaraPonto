<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setor>
 */
class SetorFactory extends Factory
{
    public function definition(): array
    {
        $gestores = User::where('tipo_usuario', 2)->pluck('id')->toArray();

        return [
            'nome' => $this->faker->unique()->company(),
            'gestor_id' => $this->faker->optional()->randomElement($gestores),
        ];
    }
}
