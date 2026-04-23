<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat akun admin (jika perlu)
        User::firstOrCreate(
            ['email' => 'admin@blenderlms.com'],
            [
                'name'     => 'Admin Blender LMS',
                'password' => Hash::make('password123'),
                'role'     => 'admin',
            ]
        );

        // 2. Buat 20 user biasa (pastikan UserFactory sudah ada)
        User::factory(20)->create(['role' => 'user']);

        // 3. Panggil semua seeder yang sudah kita buat
        $this->call([
            ModulsTableSeeder::class,
            SubmodulModul1Seeder::class,
            SubmodulModul2Seeder::class,
            SubmodulModul3Seeder::class,
            SubmodulModul4Seeder::class,
            SubmodulModul5Seeder::class,
            MiniProjectsTableSeeder::class,
            QuizzesTableSeeder::class,
            QuestionsTableSeeder::class,
            TanyasTableSeeder::class,
            JawabsTableSeeder::class,
            ResourcesTableSeeder::class,
        ]);
    }
}
