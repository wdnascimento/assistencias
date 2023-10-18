<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // id, turma_id, ano, name, numero, password, celular, cabine, send_sms, created_at, updated_at

        return [
            'turma_id' => 1,
            'ano' => 2023,
            'name' => $this->faker->name,
            'numero' => $this->faker->randomNumber(8),
            'password' => '$2y$10$RNwjjqQzaghLpL0.tFzLi.wZFlWsditYPVF5NIQz1t0qHG2a/ID8S', // 25041982
            'celular' => $this->faker->randomNumber(9),
            'cabine' => $this->faker->numberBetween(1,99),
            'send_sms' => 1
        ];
    }
}
