<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data lama
        DB::table('moduls')->delete();

        DB::table('moduls')->insert([
            [
                'id' => 1,
                'judul' => 'Dasar Modeling & Presisi (The Shape)',
                'deskripsi' => 'Fokus pada cara membuat bentuk produk yang rapi dan sesuai ukuran asli. Pelajari UI Blender khusus produk, teknik Sub-D modeling, modifier Bevel & Subdivision Surface, serta modeling dari referensi foto.',
                'gambar' => null,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'judul' => 'Material & Branding (The Look)',
                'deskripsi' => 'Fokus pada tekstur agar objek tidak terlihat seperti plastik murah dan logo terlihat tajam. Pelajari prinsip material PBR, UV unwrapping sederhana, pemasangan logo & label, serta material kaca & cairan.',
                'gambar' => null,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'judul' => 'Pencahayaan Studio Profesional (The Mood)',
                'deskripsi' => 'Fokus pada estetika. Di sinilah "keajaiban" visual produk terjadi. Pelajari setup virtual studio, lighting 3 titik (standard), refleksi produk dengan rim lighting, serta kamera & fokus (depth of field).',
                'gambar' => null,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'judul' => 'Rendering & Output (The Result)',
                'deskripsi' => 'Fokus pada teknis menghasilkan gambar akhir yang bersih tanpa bintik (noise). Pelajari optimasi render engine Cycles, denoising & sampling, color management, serta exporting & format untuk cetak/media sosial.',
                'gambar' => null,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'judul' => 'Proyek Praktik & Portofolio (The Business)',
                'deskripsi' => 'Fokus pada penggabungan semua ilmu menjadi satu karya yang siap dijual. Pelajari studi kasus lengkap, post-processing sederhana, tips menyusun portofolio, dan checklist pengiriman klien.',
                'gambar' => null,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
