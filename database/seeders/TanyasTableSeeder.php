<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanyasTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tanyas')->delete();

        DB::table('tanyas')->insert([
            // ===== MODUL 1 (submodul_id 1-4) =====
            [
                'user_id' => 2,
                'submodul_id' => 1, // Pengenalan UI Blender Khusus Produk
                'pertanyaan' => 'Apakah ada rekomendasi shortcut keyboard yang paling sering digunakan untuk modeling produk selain G, R, S?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'submodul_id' => 1,
                'pertanyaan' => 'Saya bingung membedakan workspace Modeling dan Layout. Mana yang lebih efisien untuk product rendering?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'submodul_id' => 2, // Teknik Sub-D Modeling
                'pertanyaan' => 'Kapan sebaiknya menggunakan Edge Crease dibandingkan support loops? Apakah ada dampak pada performa?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'submodul_id' => 2,
                'pertanyaan' => 'Saya membuat botol, setelah Subdivision Surface bentuknya jadi seperti telur. Apa yang salah?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'submodul_id' => 3, // Bevel & Subdivision Surface
                'pertanyaan' => 'Apakah urutan modifier Bevel dan Subdivision Surface mempengaruhi hasil akhir? Tolong jelaskan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,
                'submodul_id' => 4, // Modeling dari Referensi
                'pertanyaan' => 'Saya punya foto produk dari sisi depan dan samping tapi ukurannya tidak proporsional. Bagaimana cara menyamakan skala di Blender?',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ===== MODUL 2 (submodul_id 5-8) =====
            [
                'user_id' => 8,
                'submodul_id' => 5, // Prinsip Material PBR
                'pertanyaan' => 'Untuk material plastik mengkilap, apakah cukup mengatur Roughness rendah saja? Atau ada parameter lain yang perlu diperhatikan?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 9,
                'submodul_id' => 5,
                'pertanyaan' => 'Mengapa material logam saya terlihat seperti plastik meskipun Metallic sudah 1?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 10,
                'submodul_id' => 6, // UV Unwrapping
                'pertanyaan' => 'Setelah unwrap, UV saya keluar dalam banyak potongan kecil. Bagaimana cara menggabungkannya agar lebih rapi?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11,
                'submodul_id' => 7, // Pemasangan Logo & Label
                'pertanyaan' => 'Logo saya terlihat buram meskipun sudah menggunakan gambar resolusi tinggi. Apa penyebabnya?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 12,
                'submodul_id' => 8, // Material Kaca & Cairan
                'pertanyaan' => 'Bagaimana cara membuat efek gelembung udara di dalam cairan botol? Apakah harus modeling atau bisa dengan texture?',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ===== MODUL 3 (submodul_id 9-12) =====
            [
                'user_id' => 13,
                'submodul_id' => 9, // Setup Virtual Studio
                'pertanyaan' => 'Saya pakai backdrop lengkung tapi bayangan produk tetap keras. Apa solusi terbaik?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 14,
                'submodul_id' => 10, // Three-Point Lighting
                'pertanyaan' => 'Apakah fill light harus selalu lebih redup dari key light? Bagaimana jika ingin gaya dramatic dengan bayangan kuat?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 15,
                'submodul_id' => 10,
                'pertanyaan' => 'Saya menggunakan HDRI sebagai pencahayaan utama. Apakah masih perlu menambah key light?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 16,
                'submodul_id' => 11, // Rim Lighting
                'pertanyaan' => 'Rim light saya tidak muncul di produk kaca. Apakah ada pengaturan khusus?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 17,
                'submodul_id' => 12, // Kamera & Fokus
                'pertanyaan' => 'Depth of Field tidak memberikan efek blur meskipun sudah diaktifkan. Mungkin apa penyebabnya?',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ===== MODUL 4 (submodul_id 13-16) =====
            [
                'user_id' => 18,
                'submodul_id' => 13, // Optimasi Cycles
                'pertanyaan' => 'Render produk saya memakan waktu 3 jam untuk satu frame. Apakah normal? Bagaimana cara mempercepat tanpa menurunkan kualitas drastis?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 19,
                'submodul_id' => 14, // Denoising & Sampling
                'pertanyaan' => 'Denoising membuat tekstur halus pada produk saya menjadi terlalu mulus. Apakah ada cara untuk mempertahankan detail?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 20,
                'submodul_id' => 15, // Color Management
                'pertanyaan' => 'Warna render saya di Blender terlihat bagus, tapi setelah diekspor ke PNG menjadi lebih gelap. Kenapa?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 21,
                'submodul_id' => 16, // Exporting & Format
                'pertanyaan' => 'Klien minta file dengan latar belakang transparan untuk diedit di Photoshop. Format apa yang paling aman?',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ===== MODUL 5 (submodul_id 17-20) =====
            [
                'user_id' => 2,
                'submodul_id' => 17, // Studi Kasus Lengkap
                'pertanyaan' => 'Dalam final project, saya kesulitan menyamakan intensitas cahaya antara render dengan referensi produk asli. Ada tips?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'submodul_id' => 18, // Post-Processing
                'pertanyaan' => 'Efek Glare di compositor membuat gambar terlalu terang di area highlight. Bagaimana mengontrolnya?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'submodul_id' => 19, // Tips Portofolio
                'pertanyaan' => 'Apakah boleh menampilkan render yang sama di beberapa platform (ArtStation, Behance, Instagram) atau dianggap spam?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 8,
                'submodul_id' => 20, // Checklist Pengiriman Klien
                'pertanyaan' => 'Selain file .blend dan PNG, apakah perlu menyertakan file tekstur asli (PSD, AI) jika klien tidak meminta?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
