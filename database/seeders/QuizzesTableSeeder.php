<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizzesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('quizzes')->delete();

        DB::table('quizzes')->insert([
            [
                'id' => 1,
                'submodul_id' => 2,  // Teknik Sub-D Modeling
                'sort_order' => 1,
                'judul_quiz' => 'Kuis: Sub-D Modeling',
                'deskripsi' => 'Jawab pertanyaan berikut berdasarkan pemahaman Anda tentang subdivision surface, edge loops, dan crease.',
                'passing_score' => 70,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'submodul_id' => 5,  // Prinsip Material PBR
                'sort_order' => 1,
                'judul_quiz' => 'Kuis: Material PBR',
                'deskripsi' => 'Uji pemahaman Anda tentang parameter Principled BSDF untuk menciptakan material realistis.',
                'passing_score' => 70,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 3,
                'submodul_id' => 10, // Three-Point Lighting
                'sort_order' => 1,
                'judul_quiz' => 'Kuis: Three-Point Lighting',
                'deskripsi' => 'Pertanyaan tentang teknik pencahayaan studio profesional untuk produk.',
                'passing_score' => 70,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 4,
                'submodul_id' => 14, // Denoising & Sampling
                'sort_order' => 1,
                'judul_quiz' => 'Kuis: Denoising & Sampling',
                'deskripsi' => 'Evaluasi pengetahuan Anda tentang optimasi render di Cycles.',
                'passing_score' => 70,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => 5,
                'submodul_id' => 17, // Studi Kasus Lengkap
                'sort_order' => 1,
                'judul_quiz' => 'Kuis: Studi Kasus Produk',
                'deskripsi' => 'Soal analisis situasi nyata dalam proyek rendering produk.',
                'passing_score' => 70,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
