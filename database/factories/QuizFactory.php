<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tutorial;

class QuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tutorial_id' => 1,
            'judul_quiz' => $this->faker->sentence(3),
            'urutan' => $this->faker->numberBetween(1, 5),
            'passing_score' => $this->faker->numberBetween(60, 80),
        ];
    }
}