<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'birthdate' => $this->faker->date(),
            'nationality' => $this->faker->country,
        ];
    }
}