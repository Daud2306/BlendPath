<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Roadmap;

class TutorialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'roadmap_id' => 1,
            'judul' => $this->faker->sentence(4),
            'konten' => $this->faker->paragraphs(3, true),
            'sort_order' => $this->faker->numberBetween(1, 20),
        ];
    }
}