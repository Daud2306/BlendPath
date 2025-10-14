<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoadmapFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence(3),
            'deskripsi' => $this->faker->paragraph(),
            'gambar' => null,
            'sort_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
