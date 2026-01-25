<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Submodul;

class QuizFactory extends Factory
{
    public function definition(): array
    {
        return [
            'submodul_id' => 1,
            'judul_quiz' => $this->faker->sentence(3),
            'urutan' => $this->faker->numberBetween(1, 5),
            'passing_score' => $this->faker->numberBetween(60, 80),
        ];
    }
}