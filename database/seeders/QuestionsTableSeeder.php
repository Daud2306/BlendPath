<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('questions')->delete();

        DB::table('questions')->insert([
            // ===== QUIZ 1 (Submodul 2) - Sub-D Modeling =====
            [
                'quiz_id' => 1,
                'pertanyaan' => 'Anda memiliki model botol dengan permukaan melengkung. Setelah menambahkan Subdivision Surface modifier, bentuk botol menjadi terlalu bulat dan kehilangan ketajaman di area tutup. Apa solusi paling tepat tanpa menambah kepadatan mesh secara global?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Meningkatkan Levels Viewport menjadi 3',
                    'B' => 'Menambahkan Edge Crease pada edge di sekitar tutup (Shift+E)',
                    'C' => 'Mengganti Catmull-Clark dengan Simple subdivision',
                    'D' => 'Menghapus modifier dan menggunakan Smooth shading saja'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 1,
                'pertanyaan' => 'Mengapa teknik Sub-D modeling lebih disukai untuk produk hard-surface seperti elektronik atau botol, dibandingkan modeling dengan mesh dense (rapat) sejak awal?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Karena menghasilkan bentuk yang lebih tajam tanpa bevel',
                    'B' => 'Karena lebih mudah diedit dan non-destruktif, serta performa lebih ringan',
                    'C' => 'Karena tidak memerlukan edge loops sama sekali',
                    'D' => 'Karena otomatis menghasilkan UV mapping yang sempurna'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 1,
                'pertanyaan' => 'Pada objek dengan Subdivision Surface, Anda ingin mempertahankan sudut tajam pada beberapa sisi, tetapi tetap halus di area lain. Manakah pernyataan yang PALING tepat?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Menggunakan Bevel modifier setelah Subdivision Surface',
                    'B' => 'Menambahkan edge loops berdekatan di kedua sisi sudut yang ingin dipertahankan',
                    'C' => 'Mengaktifkan Optimal Display pada modifier',
                    'D' => 'Mengubah mode shading dari Flat ke Smooth'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 1,
                'pertanyaan' => 'Perbedaan utama antara Edge Crease dan support loop (edge loop ganda) dalam kontrol bentuk Subdivision Surface adalah...',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Edge Crease bersifat permanen, support loop dapat dihapus',
                    'B' => 'Support loop menambah jumlah vertex, Edge Crease tidak mengubah topologi',
                    'C' => 'Edge Crease hanya bekerja di Cycles, support loop untuk Eevee',
                    'D' => 'Tidak ada perbedaan signifikan'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // ===== QUIZ 2 (Submodul 5) - Material PBR =====
            [
                'quiz_id' => 2,
                'pertanyaan' => 'Sebuah produk botol parfum memiliki badan kaca bening dengan cairan berwarna emas di dalamnya. Anda menggunakan Principled BSDF. Parameter apa yang harus diatur pada material kaca agar terlihat seperti kaca mewah dengan refleksi tajam?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Metallic=1, Roughness=0.5, Transmission=0',
                    'B' => 'Metallic=0, Transmission=1, Roughness=0.05, IOR=1.45',
                    'C' => 'Metallic=0, Transmission=0, Roughness=0, Clearcoat=1',
                    'D' => 'Metallic=1, Transmission=1, Roughness=0.8'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 2,
                'pertanyaan' => 'Anda membuat material logam untuk smartwatch. Hasil render terlihat terlalu buram seperti logam yang sudah usang. Parameter mana yang paling mungkin menyebabkan kesan "buram" tersebut?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Metallic = 1, tetapi Base Color terlalu gelap',
                    'B' => 'Roughness terlalu tinggi (misal 0.7)',
                    'C' => 'IOR terlalu rendah (misal 1.1)',
                    'D' => 'Specular terlalu tinggi (misal 1.0)'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 2,
                'pertanyaan' => 'Anda ingin membuat material plastik berwarna merah dengan permukaan glossy (sedikit mengkilap). Setting Principled BSDF yang tepat adalah...',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Metallic=1, Roughness=0.9, Base Color=merah',
                    'B' => 'Metallic=0, Roughness=0.2, Base Color=merah',
                    'C' => 'Metallic=0, Roughness=0.8, Base Color=merah',
                    'D' => 'Metallic=0.5, Roughness=0, Base Color=merah'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 2,
                'pertanyaan' => 'Material kaca es (frosted glass) memiliki permukaan buram tembus cahaya. Parameter mana yang perlu ditingkatkan dari kaca bening untuk efek ini?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Metallic dan Transmission',
                    'B' => 'Roughness dan sedikit Subsurface Scattering',
                    'C' => 'IOR dan Clearcoat',
                    'D' => 'Emission Strength'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // ===== QUIZ 3 (Submodul 10) - Three-Point Lighting =====
            [
                'quiz_id' => 3,
                'pertanyaan' => 'Dalam setup three-point lighting untuk botol kaca, Anda ingin menonjolkan tepi botol agar terpisah dari latar belakang hitam. Lampu mana yang paling berperan untuk efek ini?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Key light dari depan',
                    'B' => 'Fill light dari samping',
                    'C' => 'Rim light (back light) dari belakang',
                    'D' => 'Ambient light merata'
                ]),
                'jawaban_benar' => 'C',
                'poin' => 25,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 3,
                'pertanyaan' => 'Produk Anda terlihat terlalu "datar" dan kurang dimensi meskipun sudah ada key light. Apa yang harus dilakukan?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Meningkatkan intensitas key light',
                    'B' => 'Menambahkan fill light dari sisi berlawanan dengan intensitas lebih rendah',
                    'C' => 'Mengganti area light dengan point light',
                    'D' => 'Mengurangi resolusi render'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 3,
                'pertanyaan' => 'Produk logam reflektif seringkali memantulkan lingkungan sekitar. Teknik lighting apa yang paling membantu untuk mengontrol pantulan tidak diinginkan?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Menggunakan HDRI dengan kontras tinggi',
                    'B' => 'Menempatkan papan hitam (negative light) di sisi reflektif',
                    'C' => 'Mengaktifkan Shadow Catcher',
                    'D' => 'Menggunakan lampu dengan ukuran sangat besar'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 3,
                'pertanyaan' => 'Jika bayangan produk terlalu keras dan tidak natural, pengaturan apa yang bisa dilakukan pada lampu?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Memperkecil ukuran (size) area light',
                    'B' => 'Memperbesar ukuran area light atau menambah jarak lampu',
                    'C' => 'Mengubah warna lampu menjadi lebih gelap',
                    'D' => 'Mengubah lampu dari Area ke Sun'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // ===== QUIZ 4 (Submodul 14) - Denoising & Sampling =====
            [
                'quiz_id' => 4,
                'pertanyaan' => 'Render produk Anda memakan waktu sangat lama (2 jam per frame). Anda ingin memotong waktu menjadi 30 menit tanpa kehilangan kualitas terlalu signifikan. Kombinasi terbaik adalah...',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Turunkan sample dari 1024 ke 256, aktifkan denoising OptiX',
                    'B' => 'Naikkan sample menjadi 2048, nonaktifkan denoising',
                    'C' => 'Gunakan CPU render saja',
                    'D' => 'Turunkan resolusi menjadi 50%'
                ]),
                'jawaban_benar' => 'A',
                'poin' => 25,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 4,
                'pertanyaan' => 'Setelah mengaktifkan denoising, Anda melihat area tertentu menjadi terlalu mulus (kehilangan tekstur seperti goresan halus). Apa penyebab paling mungkin?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Denoising terlalu agresif karena sample terlalu rendah',
                    'B' => 'Material tidak memiliki bump map',
                    'C' => 'Render menggunakan Eevee, bukan Cycles',
                    'D' => 'Light path terlalu tinggi'
                ]),
                'jawaban_benar' => 'A',
                'poin' => 25,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 4,
                'pertanyaan' => 'Parameter Light Paths mana yang paling penting untuk dinaikkan jika produk Anda banyak menggunakan material kaca dan cairan?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Diffuse bounces',
                    'B' => 'Glossy bounces',
                    'C' => 'Transmission bounces',
                    'D' => 'Volume bounces'
                ]),
                'jawaban_benar' => 'C',
                'poin' => 25,
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 4,
                'pertanyaan' => 'Apa fungsi Adaptive Sampling di Cycles?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Menghentikan sampling pada area yang sudah konvergen lebih awal',
                    'B' => 'Menyesuaikan resolusi render secara otomatis',
                    'C' => 'Mengubah tile size dinamis',
                    'D' => 'Mengaktifkan GPU secara adaptif'
                ]),
                'jawaban_benar' => 'A',
                'poin' => 25,
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // ===== QUIZ 5 (Submodul 17) - Studi Kasus Lengkap =====
            [
                'quiz_id' => 5,
                'pertanyaan' => 'Klien meminta render botol parfum dengan latar putih bersih, tetapi hasil render Anda memiliki bayangan keras di lantai dan pantulan lingkungan tidak terkendali. Langkah pertama yang paling tepat adalah...',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Mengganti render engine ke Eevee',
                    'B' => 'Membuat backdrop melengkung (curved plane) dan menggunakan lampu area dengan ukuran besar',
                    'C' => 'Menambahkan lebih banyak lampu',
                    'D' => 'Menggunakan HDRI outdoor'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 5,
                'pertanyaan' => 'Klien mengeluh bahwa logo pada produk terlihat buram dan melar. Padahal Anda sudah melakukan UV unwrapping. Apa yang paling mungkin menjadi penyebab?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Resolusi tekstur terlalu rendah (misal 256x256)',
                    'B' => 'Filter pada Image Texture diatur ke Linear, tetapi UV island tidak proporsional',
                    'C' => 'Material menggunakan Shader Mix tanpa UV map',
                    'D' => 'Lupa mencentang Alpha pada tekstur'
                ]),
                'jawaban_benar' => 'B',
                'poin' => 25,
                'urutan' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 5,
                'pertanyaan' => 'Dalam proyek turntable 360° untuk produk, Anda mengalami noise yang muncul di frame tertentu meskipun sudah menggunakan denoising. Strategi terbaik untuk mengatasi tanpa merender ulang semua frame adalah...',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Menggunakan OptiX temporal denoising di compositor',
                    'B' => 'Meningkatkan sample global untuk semua frame',
                    'C' => 'Mengganti background menjadi hitam',
                    'D' => 'Merender ulang hanya frame bermasalah dengan sample lebih tinggi'
                ]),
                'jawaban_benar' => 'D',
                'poin' => 25,
                'urutan' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'quiz_id' => 5,
                'pertanyaan' => 'Klien ingin hasil render digunakan untuk cetak poster A3 (3508x4968 px) dan juga untuk Instagram (1080x1080 px). Format file apa yang sebaiknya Anda kirim untuk memenuhi kedua kebutuhan?',
                'pilihan_jawaban' => json_encode([
                    'A' => 'Kirim file JPEG resolusi 1080px saja, klien bisa upscale sendiri',
                    'B' => 'Kirim file PNG resolusi 4K (3840x3840) dan file .blend',
                    'C' => 'Kirim dua file terpisah: PNG 3508x4968 untuk cetak, JPEG 1080x1080 untuk Instagram',
                    'D' => 'Kirim file EXR 32-bit, klien bisa resize'
                ]),
                'jawaban_benar' => 'C',
                'poin' => 25,
                'urutan' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
