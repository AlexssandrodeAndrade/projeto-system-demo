<?php

namespace Database\Factories;

use App\Models\Exemplo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExemploFactory extends Factory
{
    protected $model = Exemplo::class;

    public function definition(): array
    {
        return [
            'nome' => $this->faker->words(2, true),
            'descricao' => $this->faker->sentence(),
            'ativo' => $this->faker->boolean(80),
        ];
    }
}
