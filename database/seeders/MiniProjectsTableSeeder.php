<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MiniProjectsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data lama
        DB::table('mini_projects')->delete();

        DB::table('mini_projects')->insert([
            // ========== MODUL 1 ==========
            [
                'submodul_id' => 2, // Teknik Sub-D Modeling
                'judul' => 'Praktik: Membuat Botol dengan Subdivision Surface',
                'deskripsi' => 'Buat model botol sederhana menggunakan silinder. Terapkan Subdivision Surface modifier (Levels 2). Tambahkan edge loops di sekitar tutup dan dasar botol untuk mempertahankan ketajaman. Render hasilnya dengan material sementara (warna solid).',
                'passing_criteria' => 'Model botol terlihat halus, tidak ada facet. Edge loops berfungsi menjaga ketajaman pada area tertentu.',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'submodul_id' => 3, // Modifiers: Bevel & Subdivision Surface
                'judul' => 'Praktik: Meja dengan Pinggiran Halus',
                'deskripsi' => 'Buat model meja (kubus yang diskala pipih). Tambahkan Bevel modifier (Width 0.02, Segments 2) dan Subdivision Surface (Levels 1). Render dari sudut isometrik.',
                'passing_criteria' => 'Pinggiran meja terlihat sedikit bulat (tidak tajam). Hasil render menunjukkan pantulan cahaya di tepi.',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // ========== MODUL 2 ==========
            [
                'submodul_id' => 6, // UV Unwrapping Sederhana
                'judul' => 'Praktik: UV Unwrapping Kotak Produk',
                'deskripsi' => 'Buat model kotak (kubus). Lakukan UV unwrapping dengan metode Cube Projection. Gunakan checker texture untuk memverifikasi tidak ada stretching. Screenshot hasil UV editor.',
                'passing_criteria' => 'Tidak ada stretching (kotak-kotak pada checker texture seragam di semua sisi).',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'submodul_id' => 7, // Pemasangan Logo & Label
                'judul' => 'Praktik: Menempel Logo pada Produk',
                'deskripsi' => 'Gunakan model kotak dari proyek sebelumnya. Buat material baru dengan image texture (logo sederhana, misal teks "BlendPath"). Atur UV mapping sehingga logo hanya muncul di satu sisi. Render hasilnya.',
                'passing_criteria' => 'Logo terlihat rapi tanpa distorsi, hanya pada satu sisi kotak.',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // ========== MODUL 3 ==========
            [
                'submodul_id' => 10, // Three-Point Lighting
                'judul' => 'Praktik: Three-Point Lighting untuk Botol',
                'deskripsi' => 'Gunakan model botol dari modul 1. Setup key light (Area, power 500W, sudut 45° kiri), fill light (200W, kanan), dan rim light (800W, belakang). Render hasilnya dengan material plastik glossy.',
                'passing_criteria' => 'Produk terlihat memiliki dimensi: ada bayangan, highlight di tepi, dan tidak ada area yang terlalu gelap.',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'submodul_id' => 12, // Depth of Field
                'judul' => 'Praktik: Depth of Field untuk Fokus Produk',
                'deskripsi' => 'Gunakan scene yang sama (botol dengan three-point lighting). Aktifkan Depth of Field pada kamera, focus object ke botol, atur aperture f/2.8. Render dan perhatikan efek blur pada latar belakang.',
                'passing_criteria' => 'Latar belakang terlihat blur, botol tetap tajam. Efek bokeh halus.',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // ========== MODUL 4 ==========
            [
                'submodul_id' => 14, // Denoising & Sampling
                'judul' => 'Praktik: Render Bebas Noise dengan Denoising',
                'deskripsi' => 'Render scene botol dengan 256 sample, aktifkan OptiX/OpenImageDenoise. Bandingkan dengan render tanpa denoising (128 sample). Ekspor kedua hasil.',
                'passing_criteria' => 'Render dengan denoising terlihat bersih tanpa noise, sementara yang tanpa denoising masih berbintik.',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'submodul_id' => 15, // Color Management
                'judul' => 'Praktik: Koreksi Warna dengan Compositor',
                'deskripsi' => 'Render ulang botol dengan pencahayaan standar. Buka compositor, tambahkan Color Balance node. Naikkan kontras midtone dan sedikit saturasi. Simpan hasil akhir.',
                'passing_criteria' => 'Warna lebih hidup dan kontras tanpa terlihat terlalu edit.',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],

            // ========== MODUL 5 ==========
            [
                'submodul_id' => 17, // Studi Kasus Lengkap
                'judul' => 'Final Project: Render Produk Skincare Premium',
                'deskripsi' => 'Buat model botol parfum atau skincare (termasuk cairan di dalam). Gunakan material kaca + logam. Setup lighting studio (three-point + rim). Render 3 angle (depan, 3/4, close-up). Lakukan post-processing di compositor. Kirimkan file .blend dan PNG.',
                'passing_criteria' => 'Hasil final terlihat profesional, siap ditampilkan di portofolio. Minimal 3 angle, tanpa noise, material realistis.',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'submodul_id' => 20, // Checklist Pengiriman Klien
                'judul' => 'Simulasi Pengiriman Proyek ke Klien',
                'deskripsi' => 'Berdasarkan final project di atas, buat folder pengiriman sesuai checklist (render final, file .blend, tekstur, delivery note). Screenshot struktur folder dan tulis delivery note singkat.',
                'passing_criteria' => 'Folder terstruktur rapi, delivery note berisi informasi yang jelas (versi Blender, daftar file, lisensi).',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
