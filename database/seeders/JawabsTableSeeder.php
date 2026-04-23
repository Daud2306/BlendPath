<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JawabsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('jawabs')->delete();

        DB::table('jawabs')->insert([
            // Jawaban untuk pertanyaan submodul_id 1
            [
                'user_id' => 5,
                'tanya_id' => 1,
                'jawaban' => 'Selain G,R,S, saya sering pakai E (extrude), Ctrl+R (loop cut), dan Ctrl+B (bevel). Untuk produk, Shift+D (duplicate) juga berguna. Ada juga shortcut untuk snapping (Shift+Tab) dan mengubah pivot point (.)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,
                'tanya_id' => 2,
                'jawaban' => 'Modeling workspace lebih fokus ke edit mesh, sementara Layout lebih ke pengaturan scene secara umum. Untuk product rendering, biasanya saya tetap di Layout tapi membuka tab tambahan untuk UV Editor dan Shader Editor.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 2
            [
                'user_id' => 9,
                'tanya_id' => 3,
                'jawaban' => 'Edge Crease lebih hemat vertex, cocok untuk area kecil. Support loops lebih aman untuk deformasi dan shading, tapi menambah kepadatan mesh. Untuk produk statis, crease sudah cukup asal tidak terlalu ekstrim.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11,
                'tanya_id' => 4,
                'jawaban' => 'Kemungkinan Anda lupa menambahkan edge loops di bagian atas dan bawah botol. Subdivision Surface akan melengkungkan semua edge, jadi jika tanpa support loops, silinder akan berubah jadi oval. Coba tambahkan loop cuts di sekitar area tutup dan dasar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 3
            [
                'user_id' => 13,
                'tanya_id' => 5,
                'jawaban' => 'Sangat mempengaruhi. Bevel di atas subdivision akan membuat bevel ikut dihaluskan, menghasilkan sudut lebih lembut. Bevel di bawah subdivision akan diterapkan sebelum smoothing, cocok untuk hard-surface dengan bevel tajam.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 4
            [
                'user_id' => 15,
                'tanya_id' => 6,
                'jawaban' => 'Gunakan alat ukur (Ruler/Protractor) dengan menyalakan addon MeasureIt. Atau, impor kedua gambar sebagai reference, lalu skala manual menggunakan objek pembanding (misal kubus dengan ukuran nyata). Pastikan unit di scene properties sudah sesuai (mm/cm).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 5
            [
                'user_id' => 17,
                'tanya_id' => 7,
                'jawaban' => 'Roughness rendah (0.1-0.3) sudah cukup untuk plastik mengkilap. Anda juga bisa menambah Clearcoat (0.5-1) untuk efek lapisan bening. Jangan lupa atur Specular ke 0.5 (default) atau sedikit lebih tinggi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 19,
                'tanya_id' => 8,
                'jawaban' => 'Cek Roughness-nya. Logam dengan Roughness tinggi (0.6 ke atas) akan terlihat seperti plastik metalik. Turunkan Roughness ke 0.2-0.3. Juga pastikan ada lingkungan (HDRI) yang memantul, karena logam membutuhkan refleksi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 6
            [
                'user_id' => 21,
                'tanya_id' => 9,
                'jawaban' => 'Di UV Editor, pilih semua pulau (A), lalu gunakan menu UV > Pack Islands. Atur Margin 0.02. Untuk menggabungkan pulau yang terpisah, Anda harus menyambung edge seam-nya di edit mode, lalu unwrap ulang.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 7
            [
                'user_id' => 3,
                'tanya_id' => 10,
                'jawaban' => 'Periksa filter pada Image Texture. Jika menggunakan Linear, pastikan resolusi tekstur cukup. Coba ganti filter ke Closest untuk ketajaman maksimal (tapi bisa pixelated). Juga pastikan UV island proporsional (tidak terlalu kecil).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 8
            [
                'user_id' => 5,
                'tanya_id' => 11,
                'jawaban' => 'Gelembung bisa dibuat dengan partikel instancing (sphere kecil) atau menggunakan texture voronoi dengan bump. Untuk realistis, modeling beberapa sphere dan duplikasi dengan particle system lebih baik.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 9
            [
                'user_id' => 7,
                'tanya_id' => 12,
                'jawaban' => 'Bayangan keras biasanya karena ukuran area light terlalu kecil. Perbesar size lampu atau tambahkan diffuser (plane dengan material transparan) di depan lampu. Backdrop yang terlalu dekat juga bisa menyebabkan bayangan tajam.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 10
            [
                'user_id' => 9,
                'tanya_id' => 13,
                'jawaban' => 'Tidak harus. Untuk gaya dramatic, fill light bisa sangat redup (10-20% key) atau bahkan tidak digunakan sama sekali. Yang penting key light dan rim light kuat. Fill light hanya untuk menampilkan detail di area bayangan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11,
                'tanya_id' => 14,
                'jawaban' => 'HDRI bisa menjadi key light sekaligus fill. Tapi untuk kontrol lebih, tetap tambahkan key light dan rim light. HDRI sebagai base ambient, lalu lampu buatan untuk aksen.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 11
            [
                'user_id' => 13,
                'tanya_id' => 15,
                'jawaban' => 'Kaca memantulkan cahaya secara berbeda. Coba gunakan area light dengan bentuk kotak panjang, posisikan di belakang botol, dan naikkan intensitasnya hingga 2-3x key light. Atur juga agar lampu sedikit lebih tinggi dari produk.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 12
            [
                'user_id' => 15,
                'tanya_id' => 16,
                'jawaban' => 'Pastikan Depth of Field diaktifkan di kamera, dan focus object sudah diatur. Di viewport, DOF hanya terlihat di render preview (Rendered view) atau setelah render. Di Eevee, harus aktifkan Depth of Field di render properties.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 13
            [
                'user_id' => 17,
                'tanya_id' => 17,
                'jawaban' => '3 jam terlalu lama untuk satu frame produk sederhana. Coba turunkan sample ke 256-512, aktifkan denoising OptiX, kurangi light paths (max bounces 8-10), gunakan GPU compute, dan atur tile size 256x256 (untuk GPU). Juga hindari caustics jika tidak perlu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 14
            [
                'user_id' => 19,
                'tanya_id' => 18,
                'jawaban' => 'Coba naikkan sample menjadi 512 atau 1024 sebelum denoising. Denoising yang terlalu agresif karena sample terlalu rendah (misal 128) akan menghilangkan detail. Gunakan juga Denoising Data passes di compositor untuk kontrol lebih.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 15
            [
                'user_id' => 21,
                'tanya_id' => 19,
                'jawaban' => 'Itu masalah color management. Di Blender, render menggunakan ruang warna linear, tapi PNG biasanya sRGB. Pastikan di Output Properties > Color Management, View Transform = Filmic, Look = None. Coba juga ekspor ke EXR lalu konversi di Photoshop.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 16
            [
                'user_id' => 2,
                'tanya_id' => 20,
                'jawaban' => 'PNG dengan alpha channel (RGBA) adalah yang paling aman. Pastikan di Render Properties > Film > Transparent dicentang. Ekspor dengan resolusi tinggi (minimal 1920x1920). Juga berikan file EXR jika klien profesional.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 17
            [
                'user_id' => 4,
                'tanya_id' => 21,
                'jawaban' => 'Gunakan reference image yang sudah dikoreksi warnanya. Atau, render dengan color chart (grey ball + color checker) lalu samakan di post-pro. Juga pastikan monitor Anda sudah kalibrasi. Lighting produk asli biasanya menggunakan softbox, jadi atur lampu dengan ukuran besar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 18
            [
                'user_id' => 6,
                'tanya_id' => 22,
                'jawaban' => 'Turunkan nilai Mix pada node Glare (0.2-0.4). Atau gunakan Glare tipe Simple dengan threshold lebih tinggi (0.8-0.9). Alternatif: pisahkan highlight dengan Color Ramp sebelum glare.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 19
            [
                'user_id' => 8,
                'tanya_id' => 23,
                'jawaban' => 'Tidak masalah, asalkan Anda mencantumkan link portfolio utama. Banyak seniman memposting karya yang sama di berbagai platform untuk menjangkau audiens berbeda. Yang penting jangan posting berulang di satu platform dalam waktu singkat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Jawaban submodul_id 20
            [
                'user_id' => 10,
                'tanya_id' => 24,
                'jawaban' => 'Sertakan jika klien meminta dan sudah disepakati di awal. Untuk keamanan, Anda bisa memberikan file tekstur dalam format PNG (bukan PSD/AI) agar tidak bisa diedit secara bebas. Jangan berikan file sumber tekstur vektor kecuali ada pembayaran ekstra.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
