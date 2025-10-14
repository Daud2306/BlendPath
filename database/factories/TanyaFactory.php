<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Tutorial;

class TanyaFactory extends Factory
{
    public function definition(): array
    {
        $questions = [
            'Bagaimana cara menggunakan tool extrude?',
            'Apa perbedaan antara Object Mode dan Edit Mode?',
            'Kenapa texture saya tidak muncul dengan benar?',
            'Bagaimana setup lighting yang baik untuk interior?',
            'Cara membuat animasi yang smooth?',
            'Apa optimasi yang bisa dilakukan untuk render lebih cepat?',
            'Bagaimana cara unwrap UV yang efisien?',
            'Kenapa model saya terlihat pecah-pecah?',
            'Cara menggunakan modifier array dengan benar?',
            'Apa bedanya Eevee dan Cycles render?'
        ];

        return [
            'user_id' => 1,
            'tutorial_id' => 1,
            'pertanyaan' => $this->faker->randomElement($questions),
            'created_at' => $this->faker->dateTimeBetween('-90 days', 'now'),
            'updated_at' => now(),
        ];
    }
}