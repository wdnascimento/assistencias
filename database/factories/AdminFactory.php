<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Admin::class;

    public function definition()
    {
        return [
            'name' => 'Wagner',
            'email' => 'wagnerinfo@hotmail.com',
            'password' => Hash::make('W@gner3012'),
            'atendimento' => '0'
        ];
    }
}
