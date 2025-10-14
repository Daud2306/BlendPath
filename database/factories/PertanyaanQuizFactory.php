<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Quiz;

class PertanyaanQuizFactory extends Factory
{
    public function definition(): array
    {
        $pilihan = [
            $this->faker->sentence(5),
            $this->faker->sentence(5),
            $this->faker->sentence(5),
            $this->faker->sentence(5),
        ];

        return [
            'quiz_id' => 1,
            'pertanyaan' => $this->faker->sentence(10),
            'pilihan_jawaban' => $pilihan,
            'jawaban_benar' => $this->faker->numberBetween(0, 3),
            'poin' => $this->faker->numberBetween(1, 5),
        ];
    }
}
