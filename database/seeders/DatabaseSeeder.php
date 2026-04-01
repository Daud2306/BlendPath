<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\AttemptAnswer;
use App\Models\Progress;
use App\Models\Tanya;
use App\Models\MiniProject;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Users ───────────────────────────────────────────────────────────
        $admin = User::factory()->create([
            'name'     => 'Admin Blender LMS',
            'email'    => 'admin@blenderlms.com',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        $users = User::factory(99)->create();

        // ─── Moduls ───────────────────────────────────────────────────────────
        $modulsData = [
            ['judul' => 'Blender Fundamentals',  'deskripsi' => 'Dasar-dasar Blender untuk pemula',                     'sort_order' => 1],
            ['judul' => '3D Modeling Mastery',   'deskripsi' => 'Menguasai teknik modeling 3D yang advanced',            'sort_order' => 2],
            ['judul' => 'Texturing & Materials', 'deskripsi' => 'Membuat texture dan material yang realistis',           'sort_order' => 3],
            ['judul' => 'Animation Basics',      'deskripsi' => 'Dasar-dasar animasi 3D di Blender',                    'sort_order' => 4],
            ['judul' => 'Rendering & Lighting',  'deskripsi' => 'Teknik rendering dan lighting untuk hasil terbaik',    'sort_order' => 5],
        ];

        $moduls = collect();
        foreach ($modulsData as $data) {
            $moduls->push(Modul::create($data));
        }

        // ─── Submoduls ────────────────────────────────────────────────────────
        // Key: modul judul → array submodul
        // Setiap submodul bisa punya quiz dan/atau mini project (nullable)
        $submodulMap = [
            'Blender Fundamentals' => [
                ['judul' => 'Pengenalan Interface',    'quiz' => null, 'project' => null],
                [
                    'judul' => 'Basic Navigation',
                    'quiz' => null,
                    'project' => [
                        'judul'            => 'Jelajahi Viewport',
                        'deskripsi'        => 'Rekam atau screenshot hasil navigasi viewport dari berbagai sudut pandang: front, side, top, dan perspektif.',
                        'passing_criteria' => 'Screenshot menampilkan 4 sudut pandang yang berbeda dengan objek default cube terlihat jelas.',
                    ],
                ],
                [
                    'judul' => 'Object Manipulation',
                    'quiz' => [
                        'judul_quiz'    => 'Quiz: Object Manipulation',
                        'deskripsi'     => 'Uji pemahaman kamu tentang transformasi objek di Blender',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Shortcut untuk mengubah ukuran objek secara proporsional adalah?',
                                'pilihan'       => ['A' => 'S', 'B' => 'G', 'C' => 'R', 'D' => 'E'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Untuk memindahkan objek hanya di sumbu X, tekan?',
                                'pilihan'       => ['A' => 'G lalu X', 'B' => 'S lalu X', 'C' => 'R lalu X', 'D' => 'G lalu Z'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Shortcut untuk duplicate objek adalah?',
                                'pilihan'       => ['A' => 'Ctrl+C', 'B' => 'Shift+D', 'C' => 'Alt+D', 'D' => 'Ctrl+D'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => null,
                ],
                ['judul' => 'Edit Mode Basics',        'quiz' => null, 'project' => null],
                [
                    'judul' => 'Mesh Tools',
                    'quiz' => null,
                    'project' => [
                        'judul'            => 'Buat Meja Sederhana',
                        'deskripsi'        => 'Gunakan Mesh Tools untuk membuat model meja 4 kaki sederhana menggunakan primitive cube.',
                        'passing_criteria' => 'Model memiliki meja dengan 4 kaki, proporsi realistis, dan tidak ada face yang terbalik (flip normal).',
                    ],
                ],
                ['judul' => 'Modifier Introduction',   'quiz' => null, 'project' => null],
                ['judul' => 'Basic Shading',           'quiz' => null, 'project' => null],
                ['judul' => 'Simple Animation',        'quiz' => null, 'project' => null],
                ['judul' => 'Render Setup',            'quiz' => null, 'project' => null],
                [
                    'judul' => 'Project Completion',
                    'quiz' => [
                        'judul_quiz'    => 'Final Quiz: Blender Fundamentals',
                        'deskripsi'     => 'Uji pemahaman kamu tentang dasar-dasar Blender',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Kamu baru membuat objek dan ingin mengubah ukurannya secara proporsional. Cara yang paling tepat adalah?',
                                'pilihan'       => ['A' => 'Tekan S lalu drag mouse', 'B' => 'Tekan G lalu drag mouse', 'C' => 'Tekan R lalu drag mouse', 'D' => 'Gunakan menu Object Properties'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Di Edit Mode, kamu ingin memilih semua vertex. Shortcut yang digunakan adalah?',
                                'pilihan'       => ['A' => 'Ctrl+A', 'B' => 'Shift+A', 'C' => 'A', 'D' => 'Alt+A'],
                                'jawaban_benar' => 'C',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Saat kamu berada di Object Mode dan menekan Tab, apa yang terjadi?',
                                'pilihan'       => ['A' => 'Buka tab baru di Blender', 'B' => 'Masuk ke Edit Mode untuk objek yang dipilih', 'C' => 'Pindah ke Sculpt Mode', 'D' => 'Membuka Preferences'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Viewport shading mana yang paling cocok untuk melihat material dan lighting secara real-time?',
                                'pilihan'       => ['A' => 'Wireframe', 'B' => 'Solid', 'C' => 'Material Preview', 'D' => 'Rendered'],
                                'jawaban_benar' => 'C',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Kamu perlu menambahkan Modifier tapi tidak ingin efeknya permanen. Tindakan yang benar adalah?',
                                'pilihan'       => ['A' => 'Apply modifier setelah selesai', 'B' => 'Biarkan modifier tanpa di-apply', 'C' => 'Duplicate objek dulu, baru apply', 'D' => 'Gunakan Ctrl+Z setelah apply'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => [
                        'judul'            => 'Render Scene Pertamamu',
                        'deskripsi'        => 'Buat scene sederhana berisi minimal 3 objek dengan material berbeda, lalu render dengan Eevee.',
                        'passing_criteria' => 'Render output resolusi minimal 1280x720, menggunakan minimal 2 material berbeda, dan pencahayaan yang cukup.',
                    ],
                ],
            ],

            '3D Modeling Mastery' => [
                ['judul' => 'Advanced Modeling Tools', 'quiz' => null, 'project' => null],
                [
                    'judul' => 'Subdivision Surface',
                    'quiz' => [
                        'judul_quiz'    => 'Quiz: Subdivision Surface',
                        'deskripsi'     => 'Uji pemahaman kamu tentang Subdivision Surface modifier',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Subdivision Surface modifier berfungsi untuk?',
                                'pilihan'       => ['A' => 'Mengurangi polygon', 'B' => 'Memperhalus mesh dengan menambah polygon secara algoritmik', 'C' => 'Membuat lubang pada mesh', 'D' => 'Mengubah material'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Untuk mengontrol sharpness edge saat menggunakan SubD, teknik yang digunakan adalah?',
                                'pilihan'       => ['A' => 'Menambah edge loop di dekat edge yang ingin tajam', 'B' => 'Meningkatkan level subdivisi', 'C' => 'Menggunakan Bevel modifier', 'D' => 'A dan C benar'],
                                'jawaban_benar' => 'D',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => null,
                ],
                ['judul' => 'Sculpting Basics',        'quiz' => null, 'project' => null],
                ['judul' => 'Retopology Techniques',   'quiz' => null, 'project' => null],
                [
                    'judul' => 'Hard Surface Modeling',
                    'quiz' => null,
                    'project' => [
                        'judul'            => 'Model Helm Sederhana',
                        'deskripsi'        => 'Buat model helm hard surface menggunakan teknik boolean dan bevel.',
                        'passing_criteria' => 'Helm memiliki visor, ventilasi, dan topology yang bersih tanpa n-gon berlebihan.',
                    ],
                ],
                ['judul' => 'Organic Modeling',        'quiz' => null, 'project' => null],
                ['judul' => 'Boolean Operations',      'quiz' => null, 'project' => null],
                ['judul' => 'Edge Flow Optimization',  'quiz' => null, 'project' => null],
                ['judul' => 'Model Detailing',         'quiz' => null, 'project' => null],
                [
                    'judul' => 'Final Model Polish',
                    'quiz' => [
                        'judul_quiz'    => 'Final Quiz: 3D Modeling',
                        'deskripsi'     => 'Uji kemampuan modeling 3D kamu',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Kamu sedang membuat karakter low-poly untuk mobile game. Subdivision Surface modifier sebaiknya digunakan di tahap mana?',
                                'pilihan'       => ['A' => 'Sebelum mulai modeling', 'B' => 'Selama proses modeling untuk preview', 'C' => 'Tidak digunakan sama sekali untuk low-poly', 'D' => 'Hanya di final render, jangan di-apply'],
                                'jawaban_benar' => 'C',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Kamu menemukan n-gon pada mesh. Kapan n-gon menjadi masalah serius?',
                                'pilihan'       => ['A' => 'Saat objek hanya untuk rendering statis', 'B' => 'Saat mesh akan di-rig dan dianimasi', 'C' => 'Saat menggunakan Eevee renderer', 'D' => 'N-gon tidak pernah menjadi masalah'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Perbedaan utama antara Extrude dan Inset adalah?',
                                'pilihan'       => ['A' => 'Extrude menambah geometri keluar/masuk, Inset membuat face baru di dalam face', 'B' => 'Keduanya sama, hanya shortcut berbeda', 'C' => 'Inset menambah geometri keluar, Extrude membuat face baru', 'D' => 'Extrude hanya untuk edge, Inset hanya untuk face'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Boolean modifier paling cocok digunakan untuk?',
                                'pilihan'       => ['A' => 'Membuat permukaan halus pada karakter organik', 'B' => 'Membuat lubang atau potongan pada hard surface', 'C' => 'Mengoptimasi jumlah polygon', 'D' => 'Membuat texture otomatis'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Edge loop yang baik pada area sendi (siku, lutut) karakter bertujuan untuk?',
                                'pilihan'       => ['A' => 'Mengurangi jumlah polygon', 'B' => 'Memudahkan proses UV unwrapping', 'C' => 'Mendukung deformasi yang natural saat animasi', 'D' => 'Mempercepat proses rendering'],
                                'jawaban_benar' => 'C',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => [
                        'judul'            => 'Final Model: Benda Sehari-hari',
                        'deskripsi'        => 'Buat model 3D benda sehari-hari pilihanmu (kursi, botol, sepatu, dll) dengan topology yang bersih.',
                        'passing_criteria' => 'Tidak ada n-gon, edge flow mengikuti bentuk objek, dan siap untuk di-UV unwrap.',
                    ],
                ],
            ],

            'Texturing & Materials' => [
                ['judul' => 'UV Unwrapping Basics',     'quiz' => null, 'project' => null],
                ['judul' => 'Advanced UV Techniques',   'quiz' => null, 'project' => null],
                ['judul' => 'Material Nodes Introduction', 'quiz' => null, 'project' => null],
                [
                    'judul' => 'PBR Material Creation',
                    'quiz' => [
                        'judul_quiz'    => 'Quiz: PBR Material',
                        'deskripsi'     => 'Uji pemahaman kamu tentang PBR workflow',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Tujuan utama UV unwrapping adalah?',
                                'pilihan'       => ['A' => 'Mengoptimasi jumlah polygon pada mesh', 'B' => 'Memetakan permukaan 3D ke koordinat 2D agar texture bisa diterapkan dengan benar', 'C' => 'Membuat normal map secara otomatis', 'D' => 'Mengurangi ukuran file texture'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Pada PBR workflow, Roughness map yang bernilai 0 berarti?',
                                'pilihan'       => ['A' => 'Permukaan sangat kasar (matte)', 'B' => 'Permukaan tidak memiliki metalik', 'C' => 'Permukaan sangat halus dan reflektif seperti cermin', 'D' => 'Permukaan transparan'],
                                'jawaban_benar' => 'C',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Perbedaan Normal Map dan Bump Map adalah?',
                                'pilihan'       => ['A' => 'Normal Map menyimpan informasi RGB (XYZ), Bump Map hanya grayscale (height)', 'B' => 'Bump Map lebih akurat dari Normal Map', 'C' => 'Keduanya identik, hanya format file berbeda', 'D' => 'Normal Map hanya untuk Cycles, Bump Map untuk Eevee'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => null,
                ],
                ['judul' => 'Texture Painting',         'quiz' => null, 'project' => null],
                [
                    'judul' => 'Procedural Textures',
                    'quiz' => null,
                    'project' => [
                        'judul'            => 'Buat Material Batu Procedural',
                        'deskripsi'        => 'Buat material batu realistis menggunakan hanya Procedural Texture (tanpa image texture).',
                        'passing_criteria' => 'Material menggunakan minimal Noise Texture + ColorRamp, terlihat realistis di Material Preview.',
                    ],
                ],
                ['judul' => 'Bump & Normal Maps',       'quiz' => null, 'project' => null],
                ['judul' => 'Transparency & Refraction', 'quiz' => null, 'project' => null],
                ['judul' => 'Material Libraries',       'quiz' => null, 'project' => null],
                [
                    'judul' => 'Advanced Shader Setup',
                    'quiz' => [
                        'judul_quiz'    => 'Final Quiz: Texturing & Materials',
                        'deskripsi'     => 'Uji pemahaman kamu tentang texturing dan material',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Seam pada UV unwrapping sebaiknya diletakkan di mana?',
                                'pilihan'       => ['A' => 'Di area yang paling terlihat agar mudah dikontrol', 'B' => 'Di area yang tersembunyi atau tidak terlihat dari kamera utama', 'C' => 'Secara acak, posisi seam tidak berpengaruh', 'D' => 'Hanya di bagian bawah objek'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Kapan sebaiknya menggunakan Procedural Texture dibanding Image Texture?',
                                'pilihan'       => ['A' => 'Selalu, karena Procedural lebih cepat di-render', 'B' => 'Saat kamu butuh texture yang seamless, scalable, dan tidak bergantung pada resolusi', 'C' => 'Hanya untuk material logam', 'D' => 'Saat file size harus sekecil mungkin'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Principled BSDF shader menggabungkan?',
                                'pilihan'       => ['A' => 'Diffuse, Specular, Subsurface, Metallic, dan banyak lagi dalam satu node', 'B' => 'Hanya Diffuse dan Specular', 'C' => 'Emission dan Transparency saja', 'D' => 'Ambient Occlusion dan Normal Map'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Metallic value 1.0 pada Principled BSDF berarti?',
                                'pilihan'       => ['A' => 'Material adalah plastik', 'B' => 'Material adalah logam murni', 'C' => 'Material transparan', 'D' => 'Material emissive'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Untuk membuat material kaca di Cycles, node yang wajib digunakan adalah?',
                                'pilihan'       => ['A' => 'Glass BSDF atau Principled BSDF dengan Transmission = 1', 'B' => 'Diffuse BSDF dengan Roughness = 0', 'C' => 'Emission shader', 'D' => 'Velvet BSDF'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => [
                        'judul'            => 'Texturing Model 3D',
                        'deskripsi'        => 'Terapkan material PBR lengkap (Albedo, Roughness, Metallic, Normal) pada model 3D yang sudah di-UV unwrap.',
                        'passing_criteria' => 'Semua channel PBR terkoneksi dengan benar, tidak ada UV stretching yang terlihat, render menggunakan Cycles.',
                    ],
                ],
            ],

            'Animation Basics' => [
                ['judul' => 'Keyframe Animation',  'quiz' => null, 'project' => null],
                [
                    'judul' => 'Graph Editor',
                    'quiz' => [
                        'judul_quiz'    => 'Quiz: Graph Editor & Keyframe',
                        'deskripsi'     => 'Uji pemahaman kamu tentang keyframe dan graph editor',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Kamu ingin animasi terasa lebih natural dengan ease-in dan ease-out. Di mana kamu mengatur ini?',
                                'pilihan'       => ['A' => 'Timeline editor', 'B' => 'Graph Editor dengan mengubah kurva interpolasi', 'C' => 'NLA Editor', 'D' => 'Properties panel'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Shortcut untuk menambah keyframe di Blender adalah?',
                                'pilihan'       => ['A' => 'K', 'B' => 'I', 'C' => 'Ctrl+K', 'D' => 'Alt+I'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => null,
                ],
                ['judul' => 'Shape Keys',          'quiz' => null, 'project' => null],
                ['judul' => 'Armature Setup',      'quiz' => null, 'project' => null],
                ['judul' => 'Rigging Basics',      'quiz' => null, 'project' => null],
                ['judul' => 'Weight Painting',     'quiz' => null, 'project' => null],
                ['judul' => 'Character Animation', 'quiz' => null, 'project' => null],
                [
                    'judul' => 'Walk Cycle',
                    'quiz' => null,
                    'project' => [
                        'judul'            => 'Buat Walk Cycle Sederhana',
                        'deskripsi'        => 'Buat walk cycle 24 frame untuk karakter bipedal sederhana menggunakan armature dan keyframe.',
                        'passing_criteria' => 'Animasi looping mulus, kaki bergantian dengan timing yang benar, menggunakan minimal 4 pose utama walk cycle.',
                    ],
                ],
                ['judul' => 'Facial Animation',   'quiz' => null, 'project' => null],
                [
                    'judul' => 'Animation Polish',
                    'quiz' => [
                        'judul_quiz'    => 'Final Quiz: Animation Basics',
                        'deskripsi'     => 'Uji pemahaman kamu tentang animasi dasar',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Shape Key digunakan untuk?',
                                'pilihan'       => ['A' => 'Menggerakkan tulang pada armature', 'B' => 'Animasi deformasi mesh seperti ekspresi wajah', 'C' => 'Mengatur weight painting', 'D' => 'Membuat path animation'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Saat weight painting, warna merah berarti?',
                                'pilihan'       => ['A' => 'Vertex tidak terpengaruh bone sama sekali', 'B' => 'Vertex terpengaruh penuh (weight = 1) oleh bone yang dipilih', 'C' => 'Terdapat error pada rigging', 'D' => 'Vertex terkunci'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Perbedaan Forward Kinematics (FK) dan Inverse Kinematics (IK) pada rigging adalah?',
                                'pilihan'       => ['A' => 'FK menggerakkan dari ujung ke pangkal, IK dari pangkal ke ujung', 'B' => 'FK menggerakkan dari pangkal ke ujung, IK dari ujung ke pangkal', 'C' => 'Keduanya sama, hanya penamaan berbeda', 'D' => 'FK untuk karakter manusia, IK untuk robot'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Dalam sebuah walk cycle, prinsip "squash and stretch" diterapkan untuk?',
                                'pilihan'       => ['A' => 'Membuat animasi lebih cepat dirender', 'B' => 'Memberikan kesan berat dan elastisitas yang membuat gerakan terasa hidup', 'C' => 'Mengurangi jumlah keyframe yang dibutuhkan', 'D' => 'Mengunci sumbu gerakan'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'NLA Editor di Blender digunakan untuk?',
                                'pilihan'       => ['A' => 'Membuat material animasi', 'B' => 'Menggabungkan dan mengatur beberapa action/clip animasi', 'C' => 'Render animasi ke video', 'D' => 'Mengatur physics simulation'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => [
                        'judul'            => 'Animasi Pendek 5 Detik',
                        'deskripsi'        => 'Buat animasi pendek 5 detik (120 frame @ 24fps) yang menampilkan minimal satu karakter atau objek bergerak dengan smooth interpolasi.',
                        'passing_criteria' => 'Animasi menggunakan ease-in/out, tidak ada popping keyframe, dan di-render sebagai video mp4.',
                    ],
                ],
            ],

            'Rendering & Lighting' => [
                ['judul' => 'Lighting Fundamentals',  'quiz' => null, 'project' => null],
                [
                    'judul' => 'Three-Point Lighting',
                    'quiz' => [
                        'judul_quiz'    => 'Quiz: Lighting Dasar',
                        'deskripsi'     => 'Uji pemahaman kamu tentang teknik lighting',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Three-point lighting terdiri dari?',
                                'pilihan'       => ['A' => 'Key light, Fill light, Back light', 'B' => 'Ambient, Diffuse, Specular', 'C' => 'Sun, Point, Spot', 'D' => 'Primary, Secondary, Tertiary'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Fungsi Fill light dalam three-point lighting adalah?',
                                'pilihan'       => ['A' => 'Sumber cahaya utama', 'B' => 'Memisahkan subjek dari background', 'C' => 'Mengisi bayangan yang terlalu keras dari key light', 'D' => 'Membuat lens flare'],
                                'jawaban_benar' => 'C',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => [
                        'judul'            => 'Setup Three-Point Lighting',
                        'deskripsi'        => 'Buat scene dengan three-point lighting setup pada objek karakter atau produk. Render hasilnya.',
                        'passing_criteria' => 'Tiga light source teridentifikasi jelas dalam scene, shadow terlihat natural, render menggunakan Cycles minimal 128 samples.',
                    ],
                ],
                ['judul' => 'HDRI Lighting',         'quiz' => null, 'project' => null],
                ['judul' => 'Eevee vs Cycles',       'quiz' => null, 'project' => null],
                ['judul' => 'Material Optimization', 'quiz' => null, 'project' => null],
                ['judul' => 'Render Settings',       'quiz' => null, 'project' => null],
                ['judul' => 'Compositing Basics',    'quiz' => null, 'project' => null],
                ['judul' => 'Post Processing',       'quiz' => null, 'project' => null],
                ['judul' => 'Render Layers',         'quiz' => null, 'project' => null],
                [
                    'judul' => 'Final Render Output',
                    'quiz' => [
                        'judul_quiz'    => 'Final Quiz: Rendering & Lighting',
                        'deskripsi'     => 'Uji pemahaman kamu tentang rendering dan lighting',
                        'passing_score' => 70,
                        'soal'          => [
                            [
                                'pertanyaan'    => 'Kapan sebaiknya menggunakan Cycles dibanding Eevee?',
                                'pilihan'       => ['A' => 'Saat kamu butuh hasil render yang cepat untuk preview animasi', 'B' => 'Saat kamu butuh akurasi pencahayaan fisik (caustics, global illumination) yang realistis', 'C' => 'Saat rendering untuk game engine', 'D' => 'Eevee selalu lebih baik dari Cycles'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'HDRI digunakan dalam lighting untuk?',
                                'pilihan'       => ['A' => 'Membuat texture pada objek', 'B' => 'Memberikan environment lighting yang realistis berdasarkan foto 360 derajat', 'C' => 'Mengoptimasi shadow quality', 'D' => 'Membuat post-processing effect'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Sample count di Cycles berpengaruh pada?',
                                'pilihan'       => ['A' => 'Ukuran output file', 'B' => 'Kecepatan animasi playback', 'C' => 'Tingkat noise — semakin tinggi sample, semakin bersih hasil render (tapi lebih lama)', 'D' => 'Jumlah polygon yang bisa di-render'],
                                'jawaban_benar' => 'C',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Render Layer dan Compositing berguna untuk?',
                                'pilihan'       => ['A' => 'Membagi scene menjadi beberapa bagian yang bisa diedit secara terpisah di post-production', 'B' => 'Mempercepat proses modeling', 'C' => 'Mengurangi polygon count', 'D' => 'Hanya untuk animasi, tidak untuk still render'],
                                'jawaban_benar' => 'A',
                                'poin'          => 10,
                            ],
                            [
                                'pertanyaan'    => 'Denoiser di Cycles berfungsi untuk?',
                                'pilihan'       => ['A' => 'Meningkatkan resolusi render', 'B' => 'Mengurangi noise pada render dengan sample rendah menggunakan AI/algoritma', 'C' => 'Mengubah format output', 'D' => 'Mempercepat viewport shading'],
                                'jawaban_benar' => 'B',
                                'poin'          => 10,
                            ],
                        ],
                    ],
                    'project' => [
                        'judul'            => 'Portfolio Render Final',
                        'deskripsi'        => 'Buat satu render berkualitas portfolio menggunakan semua yang telah dipelajari: model, material PBR, lighting, dan compositing.',
                        'passing_criteria' => 'Resolusi minimal 1920x1080, menggunakan Cycles dengan denoiser, minimal three-point lighting, dan ada post-processing di compositor.',
                    ],
                ],
            ],
        ];

        // ─── Seed Submoduls, Quiz, Questions, MiniProjects ────────────────────
        $submoduls = collect();
        $quizzes   = collect();

        $moduls->each(function (Modul $modul) use ($submodulMap, &$submoduls, &$quizzes) {
            $items = $submodulMap[$modul->judul] ?? [];

            foreach ($items as $i => $item) {
                $submodul = Submodul::create([
                    'modul_id'   => $modul->id,
                    'judul'      => $item['judul'],
                    'konten'     => $this->dummyKonten($modul->judul, $i + 1),
                    'sort_order' => $i + 1,
                ]);
                $submoduls->push($submodul);

                // Quiz (optional)
                if ($item['quiz']) {
                    $q = $item['quiz'];
                    $quiz = Quiz::create([
                        'submodul_id'   => $submodul->id,
                        'judul_quiz'    => $q['judul_quiz'],
                        'deskripsi'     => $q['deskripsi'],
                        'passing_score' => $q['passing_score'],
                    ]);
                    foreach ($q['soal'] as $urutan => $soal) {
                        Question::create([
                            'quiz_id'         => $quiz->id,
                            'pertanyaan'      => $soal['pertanyaan'],
                            'gambar_soal'     => null,
                            'pilihan_jawaban' => $soal['pilihan'],
                            'jawaban_benar'   => $soal['jawaban_benar'],
                            'poin'            => $soal['poin'],
                            'urutan'          => $urutan + 1,
                        ]);
                    }
                    $quizzes->push($quiz);
                }

                // Mini Project (optional)
                if ($item['project']) {
                    $p = $item['project'];
                    MiniProject::create([
                        'submodul_id'      => $submodul->id,
                        'judul'            => $p['judul'],
                        'deskripsi'        => $p['deskripsi'],
                        'passing_criteria' => $p['passing_criteria'],
                        'sort_order'       => 1,
                    ]);
                }
            }
        });

        // ─── Progress ─────────────────────────────────────────────────────────
        $users->each(function (User $user) use ($submoduls) {
            $submoduls->random(rand(15, 35))->each(function (Submodul $submodul) use ($user) {
                Progress::updateOrCreate(
                    ['user_id' => $user->id, 'submodul_id' => $submodul->id],
                    ['is_completed' => true, 'completed_at' => now()->subDays(rand(1, 90))]
                );
            });
        });

        // ─── Tanya ────────────────────────────────────────────────────────────
        for ($i = 0; $i < 20; $i++) {
            Tanya::factory()->create([
                'user_id'     => $users->random()->id,
                'submodul_id' => $submoduls->random()->id,
            ]);
        }

        // ─── QuizAttempts dummy ───────────────────────────────────────────────
        $quizzes->each(function (Quiz $quiz) use ($users) {
            $totalSoal = $quiz->questions()->count();
            if ($totalSoal === 0) return;

            $users->random(rand(10, 20))->each(function (User $user) use ($quiz, $totalSoal) {
                $jumlahBenar = rand(0, $totalSoal);
                $persentase  = round(($jumlahBenar / $totalSoal) * 100, 2);
                $lulus       = $persentase >= $quiz->passing_score;

                QuizAttempt::create([
                    'user_id'      => $user->id,
                    'quiz_id'      => $quiz->id,
                    'total_poin'   => $jumlahBenar * 10,
                    'total_soal'   => $totalSoal,
                    'jumlah_benar' => $jumlahBenar,
                    'persentase'   => $persentase,
                    'lulus'        => $lulus,
                    'completed_at'   => now()->subDays(rand(1, 60)),
                ]);
            });
        });
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    private function dummyKonten(string $modulJudul, int $no): string
    {
        return "<h2>Submodul {$no}: {$modulJudul}</h2>"
            . "<p>Materi ini mencakup konsep-konsep penting yang perlu dikuasai sebelum melanjutkan ke tahap berikutnya. "
            . "Pelajari dan praktikkan semua langkah yang diberikan.</p>"
            . "<p>Gunakan shortcut keyboard untuk mempercepat workflow kamu di Blender. "
            . "Konsistensi berlatih setiap hari jauh lebih efektif daripada belajar marathon sesekali.</p>";
    }
}
