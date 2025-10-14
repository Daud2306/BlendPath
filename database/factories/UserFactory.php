<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['user', 'admin']),
            'email_verified_at' => now(),
        ];
    }

    public function admin()
    {
        return $this->state([
            'role' => 'admin',
        ]);
    }

    public function user()
    {
        return $this->state([
            'role' => 'user',
        ]);
    }
}