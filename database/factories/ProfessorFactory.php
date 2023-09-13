<?php

namespace Database\Factories;

use App\Models\Professor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ProfessorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Professor::class;

    public function definition()
    {
        return [
            //id, name, email, password, remember_token, created_at, updated_at, deleted_at
            'name' => 'Wagner',
            'email' => 'wagnerinfo@gmail.com',
            'password' => Hash::make('W@gner3012'),
        ];
    }
}
