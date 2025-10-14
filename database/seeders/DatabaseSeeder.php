<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roadmap;
use App\Models\Tutorial;
use App\Models\Quiz;
use App\Models\PertanyaanQuiz;
use App\Models\Progress;
use App\Models\Tanya;
use App\Models\ResponQuiz;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin Blender LMS',
            'email' => 'admin@blenderlms.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $users = User::factory(99)->create();

        $roadmaps = Roadmap::factory()->createMany([
            [
                'judul' => 'Blender Fundamentals',
                'deskripsi' => 'Belajar dasar-dasar Blender untuk pemula',
                'gambar' => 'fundamentals.jpg',
                'sort_order' => 1,
            ],
            [
                'judul' => '3D Modeling Mastery',
                'deskripsi' => 'Menguasai teknik modeling 3D yang advanced',
                'gambar' => 'modeling.jpg',
                'sort_order' => 2,
            ],
            [
                'judul' => 'Texturing & Materials',
                'deskripsi' => 'Belajar membuat texture dan material yang realistis',
                'gambar' => 'texturing.jpg',
                'sort_order' => 3,
            ],
            [
                'judul' => 'Animation Basics',
                'deskripsi' => 'Dasar-dasar animasi 3D di Blender',
                'gambar' => 'animation.jpg',
                'sort_order' => 4,
            ],
            [
                'judul' => 'Rendering & Lighting',
                'deskripsi' => 'Teknik rendering dan lighting untuk hasil terbaik',
                'gambar' => 'rendering.jpg',
                'sort_order' => 5,
            ],
        ]);

        $tutorials = collect();

        $roadmaps->each(function ($roadmap) use (&$tutorials) {
            $roadmapTutorials = [];

            for ($i = 1; $i <= 10; $i++) {
                $roadmapTutorials[] = [
                    'roadmap_id' => $roadmap->id,
                    'judul' => "Tutorial {$i}: " . $this->getTutorialTitle($roadmap->judul, $i),
                    'konten' => $this->getTutorialContent($roadmap->judul, $i),
                    'sort_order' => $i,
                ];
            }

            $createdTutorials = Tutorial::factory()->createMany($roadmapTutorials);
            $tutorials = $tutorials->merge($createdTutorials);
        });

        $quizzes = collect();

        $roadmaps->each(function ($roadmap) use ($tutorials, &$quizzes) {
            $lastTutorial = $tutorials->where('roadmap_id', $roadmap->id)
                ->where('sort_order', 10)
                ->first();

            if ($lastTutorial) {
                $quiz = Quiz::factory()->create([
                    'tutorial_id' => $lastTutorial->id,
                    'judul_quiz' => "Final Quiz: " . $roadmap->judul,
                    'urutan' => 1,
                    'passing_score' => 75,
                ]);
                $quizzes->push($quiz);
            }
        });

        $questions = [
            [
                'quiz_id' => 1,
                'pertanyaan' => 'Apa fungsi utama dari area 3D Viewport di Blender?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 1,
                'poin' => 10
            ],
            [
                'quiz_id' => 1,
                'pertanyaan' => 'Shortcut untuk menambah objek baru di Blender?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 0,
                'poin' => 10
            ],

            [
                'quiz_id' => 2,
                'pertanyaan' => 'Teknik apa yang digunakan untuk membuat permukaan yang halus?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 2,
                'poin' => 10
            ],
            [
                'quiz_id' => 2,
                'pertanyaan' => 'Apa fungsi dari modifier Array?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 1,
                'poin' => 10
            ],

            [
                'quiz_id' => 3,
                'pertanyaan' => 'Apa tujuan utama dari UV unwrapping?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 0,
                'poin' => 10
            ],
            [
                'quiz_id' => 3,
                'pertanyaan' => 'Node yang digunakan untuk texture bump mapping?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 3,
                'poin' => 10
            ],

            [
                'quiz_id' => 4,
                'pertanyaan' => 'Apa fungsi keyframe dalam animasi?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 1,
                'poin' => 10
            ],
            [
                'quiz_id' => 4,
                'pertanyaan' => 'Tools untuk rigging karakter disebut?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 2,
                'poin' => 10
            ],

            [
                'quiz_id' => 5,
                'pertanyaan' => 'Perbedaan utama antara Eevee dan Cycles?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 0,
                'poin' => 10
            ],
            [
                'quiz_id' => 5,
                'pertanyaan' => 'Teknik lighting three-point terdiri dari?',
                'pilihan_jawaban' => $this->generateAnswerOptions(),
                'jawaban_benar' => 1,
                'poin' => 10
            ],
        ];

        foreach ($questions as $question) {
            PertanyaanQuiz::factory()->create($question);
        }

        $users->each(function ($user) use ($tutorials) {
            $randomTutorials = $tutorials->random(rand(20, 40));

            $randomTutorials->each(function ($tutorial) use ($user) {
                Progress::factory()->create([
                    'user_id' => $user->id,
                    'tutorial_id' => $tutorial->id,
                    'is_completed' => true,
                    'completed_at' => now()->subDays(rand(1, 90)),
                ]);
            });
        });

        for ($i = 0; $i < 20; $i++) {
            Tanya::factory()->create([
                'user_id' => $users->random()->id,
                'tutorial_id' => $tutorials->random()->id,
            ]);
        }

        for ($i = 0; $i < 50; $i++) {
            ResponQuiz::factory()->create([
                'user_id' => $users->random()->id,
                'quiz_id' => $quizzes->random()->id,
                'total_poin' => rand(60, 100),
                'lulus' => rand(0, 1),
            ]);
        }
    }

    private function getTutorialTitle(string $roadmapTitle, int $tutorialNumber): string
    {
        $titles = [
            'Blender Fundamentals' => [
                'Pengenalan Interface',
                'Basic Navigation',
                'Object Manipulation',
                'Edit Mode Basics',
                'Mesh Tools',
                'Modifier Introduction',
                'Basic Shading',
                'Simple Animation',
                'Render Setup',
                'Project Completion'
            ],
            '3D Modeling Mastery' => [
                'Advanced Modeling Tools',
                'Subdivision Surface',
                'Sculpting Basics',
                'Retopology Techniques',
                'Hard Surface Modeling',
                'Organic Modeling',
                'Boolean Operations',
                'Edge Flow Optimization',
                'Model Detailing',
                'Final Model Polish'
            ],
            'Texturing & Materials' => [
                'UV Unwrapping Basics',
                'Advanced UV Techniques',
                'Material Nodes Introduction',
                'PBR Material Creation',
                'Texture Painting',
                'Procedural Textures',
                'Bump & Normal Maps',
                'Transparency & Refraction',
                'Material Libraries',
                'Advanced Shader Setup'
            ],
            'Animation Basics' => [
                'Keyframe Animation',
                'Graph Editor',
                'Shape Keys',
                'Armature Setup',
                'Rigging Basics',
                'Weight Painting',
                'Character Animation',
                'Walk Cycle',
                'Facial Animation',
                'Animation Polish'
            ],
            'Rendering & Lighting' => [
                'Lighting Fundamentals',
                'Three-Point Lighting',
                'HDRI Lighting',
                'Eevee vs Cycles',
                'Material Optimization',
                'Render Settings',
                'Compositing Basics',
                'Post Processing',
                'Render Layers',
                'Final Render Output'
            ]
        ];

        return $titles[$roadmapTitle][$tutorialNumber - 1] ?? "Tutorial {$tutorialNumber}";
    }

    private function getTutorialContent(string $roadmapTitle, int $tutorialNumber): string
    {
        return "Ini adalah tutorial {$tutorialNumber} dari roadmap {$roadmapTitle}. " .
            "Materi ini mencakup konsep-konsep penting yang perlu dikuasai untuk melanjutkan ke tahap berikutnya. " .
            "Pelajari dengan seksama dan praktikkan semua langkah-langkah yang diberikan.";
    }

    private function generateAnswerOptions(): array
    {
        return [
            'Pilihan jawaban A',
            'Pilihan jawaban B',
            'Pilihan jawaban C',
            'Pilihan jawaban D'
        ];
    }
}
