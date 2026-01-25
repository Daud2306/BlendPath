<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Modul;

class SubmodulFactory extends Factory
{
    public function definition(): array
    {
        return [
            'modul_id' => 1,
            'judul' => $this->faker->sentence(4),
            'konten' => $this->faker->paragraphs(3, true),
            'sort_order' => $this->faker->numberBetween(1, 20),
        ];
    }
}