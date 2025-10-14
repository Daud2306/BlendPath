<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Quiz;

class ResponQuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'quiz_id' => 1,
            'total_poin' => $this->faker->numberBetween(0, 100),
            'lulus' => $this->faker->boolean(),
        ];
    }
}