<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Submodul;

class ProgressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'submodul_id' => 1,
            'is_completed' => $this->faker->boolean(),
            'completed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}