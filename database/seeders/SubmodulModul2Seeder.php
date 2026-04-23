<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmodulModul2Seeder extends Seeder
{
    public function run(): void
    {
        // Hapus hanya submodul milik modul 2
        DB::table('submoduls')->where('modul_id', 2)->delete();

        DB::table('submoduls')->insert([
            [
                'id' => 5,
                'modul_id' => 2,
                'judul' => 'Prinsip Material PBR (Physically Based Rendering)',
                'konten' => '<h2>Memahami Material PBR untuk Produk Realistis</h2>
<p>PBR (Physically Based Rendering) adalah pendekatan material yang meniru perilaku cahaya di dunia nyata. Di Blender, shader <strong>Principled BSDF</strong> adalah implementasi PBR lengkap.</p>

<h3>Parameter Kunci Principled BSDF</h3>
<ul>
    <li><strong>Base Color</strong>: Warna dasar material. Untuk logam, ini adalah warna pantulan.</li>
    <li><strong>Metallic</strong>: Nilai 0 = non-logam (plastik, keramik, kaca), 1 = logam (emas, perak, besi).</li>
    <li><strong>Roughness</strong>: Kekasaran permukaan. 0 = mengkilap sempurna (cermin), 1 = matte (kertas, karet).</li>
    <li><strong>Specular</strong>: Kekuatan pantulan specular untuk non-logam (default 0.5 sudah realistis).</li>
    <li><strong>Clearcoat</strong>: Lapisan transparan tambahan (seperti pernis pada cat mobil). Nilai 0-1.</li>
    <li><strong>Clearcoat Roughness</strong>: Kekasaran lapisan clearcoat.</li>
    <li><strong>IOR (Index of Refraction)</strong>: Indeks bias. Air=1.33, Kaca=1.45, Berlian=2.42.</li>
    <li><strong>Transmission</strong>: Untuk material transparan (kaca, air). Atur ke 1 untuk kaca.</li>
</ul>

<h3>Tabel Referensi Material Cepat</h3>
<table style="width:100%; border-collapse:collapse; border:1px solid #ddd;">
    <thead style="background:#f0f0f0;"><tr><th>Material</th><th>Metallic</th><th>Roughness</th><th>Base Color</th><th>Catatan</th></tr></thead>
    <tbody>
        <tr><td>Plastik ABS (matte)</td><td>0</td><td>0.6</td><td>Sesuai produk</td><td>Banyak produk elektronik</td></tr>
        <tr><td>Plastik glossy</td><td>0</td><td>0.2-0.3</td><td>Sesuai produk</td><td>Remote, mainan</td></tr>
        <tr><td>Aluminium brush</td><td>1</td><td>0.3-0.4</td><td>#B8B8B8</td><td>Dengan anisotropic</td></tr>
        <tr><td>Emas murni</td><td>1</td><td>0.2</td><td>#FFD700</td><td>Perhiasan</td></tr>
        <tr><td>Kaca bening</td><td>0</td><td>0.1</td><td>Putih</td><td>Transmission=1, IOR=1.45</td></tr>
    </tbody>
</table>

<h3>Menambahkan Variasi dengan Texture</h3>
<p>Material realistis jarang seragam. Gunakan <strong>Noise Texture</strong> atau <strong>Voronoi</strong> yang dihubungkan ke <strong>Roughness</strong> untuk membuat efek permukaan tidak rata. Untuk goresan, gunakan <strong>Musgrave Texture</strong> dengan skala kecil.</p>

<p>Untuk produk kulit (seperti tas atau kursi), kombinasikan <strong>Subsurface Scattering</strong> dengan nilai <strong>Subsurface</strong> sekitar 0.1-0.3 dan warna kemerahan pada <strong>Subsurface Color</strong>.</p>',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'modul_id' => 2,
                'judul' => 'UV Unwrapping Sederhana untuk Stiker dan Label',
                'konten' => '<h2>Membuka Permukaan Objek dengan UV Mapping</h2>
<p>UV mapping adalah proses memproyeksikan model 3D ke bidang 2D agar tekstur (seperti logo atau label) bisa ditempel dengan presisi. Untuk produk, UV unwrapping yang rapi sangat penting agar branding tidak terlihat melar atau terpotong.</p>

<h3>Langkah Dasar UV Unwrapping</h3>
<ol>
    <li>Pilih objek, masuk ke <strong>Edit Mode</strong> (Tab).</li>
    <li>Pilih edge yang akan menjadi <strong>seam</strong> (garis potong). Gunakan <strong>Ctrl + E > Mark Seam</strong>. Untuk botol, seam biasanya di sisi belakang atau di bagian bawah tutup.</li>
    <li>Tekan <strong>A</strong> untuk memilih semua face.</li>
    <li>Tekan <strong>U > Unwrap</strong>. Hasilnya bisa dilihat di <strong>UV Editor</strong> (bisa ubah workspace ke UV Editing).</li>
</ol>

<h3>Teknik Seam untuk Berbagai Bentuk</h3>
<ul>
    <li><strong>Silinder (botol, gelas)</strong>: Satu seam vertikal di sisi belakang, plus seam di lingkaran atas dan bawah.</li>
    <li><strong>Kubus (kotak produk)</strong>: Seam berbentuk "T" atau salib. Unwrap otomatis dengan <strong>Cube Projection</strong> sering sudah cukup.</li>
    <li><strong>Bola (tombol, kenop)</strong>: Gunakan <strong>Sphere Projection</strong>.</li>
    <li><strong>Permukaan datar (layar HP, panel)</strong>: Cukup pilih face lalu <strong>U > Unwrap</strong> (tanpa seam khusus).</li>
</ul>

<h3>Mengatur Ulang UV Layout</h3>
<p>Di UV Editor, Anda bisa memindahkan, memutar, dan menskalakan pulau-pulau UV. Pastikan semua pulau berada di dalam kotak 0-1 (area tekstur). Untuk label yang akan ditempel di area tertentu, gunakan <strong>UV Sync Selection</strong> agar pemilihan di viewport sinkron dengan UV. Kemudian scale dan posisikan pulau UV yang sesuai hingga menutupi area yang diinginkan.</p>

<h3>Menggunakan Checker Texture untuk Verifikasi</h3>
<p>Sebelum membuat tekstur final, buat material sementara dengan <strong>Checker Texture</strong> (UV output). Jika kotak-kotak terlihat seragam tanpa distorsi (tidak melar), maka unwrapping Anda sudah benar. Jika kotak memanjang, lakukan <strong>U > Unwrap</strong> ulang dengan seam yang lebih baik atau gunakan <strong>Follow Active Quads</strong> untuk permukaan kontinu.</p>',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'modul_id' => 2,
                'judul' => 'Pemasangan Logo & Label pada Produk',
                'konten' => '<h2>Menempelkan Branding pada Permukaan Produk</h2>
<p>Logo klien atau label produk harus terlihat tajam dan mengikuti kontur objek. Ada dua pendekatan utama: menggunakan texture image dengan UV mapping, atau menggunakan decal machine (add-on).</p>

<h3>Metode 1: Image Texture pada Area Tertentu</h3>
<p>Setelah UV unwrapping selesai, buat material baru. Tambahkan <strong>Image Texture</strong> node. Load file logo (PNG dengan latar transparan). Hubungkan ke <strong>Base Color</strong>. Untuk membuat logo hanya muncul di area tertentu, Anda perlu mengatur posisi UV island yang sesuai. Jika logo ingin muncul di satu sisi saja (misal depan kotak), maka pilih face depan di edit mode, lalu <strong>U > Unwrap</strong> dari tampilan depan (View > Align View > Front), kemudian di UV Editor, posisikan pulau tersebut tepat di atas logo pada gambar tekstur.</p>

<h3>Metode 2: Mix Shader dengan Masking</h3>
<p>Untuk logo di atas permukaan yang sudah memiliki material (misal logo putih di bodi hitam), gunakan <strong>Mix Shader</strong>. Siapkan dua material (dasar dan logo). Gunakan <strong>Image Texture</strong> hitam-putih sebagai <strong>fac</strong> input. Area putih akan menampilkan material logo, area hitam material dasar. Tekstur mask ini bisa digambar di software eksternal (Photoshop, GIMP) dengan UV layout sebagai panduan.</p>

<h3>Metode 3: UV Project Modifier (Tanpa Unwrap Ulang)</h3>
<p>Jika hanya butuh satu proyeksi dari kamera tertentu (misal logo di bagian depan botol), Anda bisa gunakan <strong>UV Project</strong> modifier. Tambahkan <strong>Empty</strong> sebagai proyektor. Atur posisi empty sehingga menghadap ke area produk. Pada material, gunakan <strong>Texture Coordinate</strong> dengan output <strong>UV</strong> dari modifier. Cara ini cepat untuk mockup, tetapi kurang fleksibel jika produk diputar.</p>

<h3>Tips agar Logo Terlihat Tajam</h3>
<ul>
    <li>Gunakan resolusi tekstur minimal 1024x1024 untuk produk yang akan dirender close-up.</li>
    <li>Pastikan <strong>Filter</strong> pada Image Texture diatur ke <strong>Linear</strong> atau <strong>Smart</strong>, jangan <strong>Cubic</strong> jika ingin ketajaman maksimal.</li>
    <li>Untuk logo dengan teks kecil, gunakan <strong>Closest</strong> filter agar tidak buram, tapi akan terlihat pixelated jika terlalu dekat.</li>
    <li>Tambahkan sedikit <strong>Bump</strong> atau <strong>Normal Map</strong> pada logo untuk efek cetak timbul (emboss).</li>
</ul>',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'modul_id' => 2,
                'judul' => 'Material Kaca & Cairan (Botol Parfum, Minuman)',
                'konten' => '<h2>Menciptakan Kaca Bening dan Cairan Elegan</h2>
<p>Kaca dan cairan adalah material transparan yang bergantung pada indeks bias (IOR) dan efek absorpsi cahaya. Untuk botol parfum atau minuman, penampilan yang realistis membutuhkan beberapa lapisan.</p>

<h3>Material Kaca Dasar</h3>
<p>Di Principled BSDF, atur parameter berikut untuk kaca standar:</p>
<ul>
    <li><strong>Metallic</strong> = 0</li>
    <li><strong>Transmission</strong> = 1.0 (mengaktifkan transparansi)</li>
    <li><strong>Roughness</strong> = 0.0 - 0.05 (kaca bening mengkilap) atau 0.2-0.4 untuk kaca es (frosted)</li>
    <li><strong>IOR</strong> = 1.45 (kaca soda-lime) atau 1.52 (kristal)</li>
    <li><strong>Base Color</strong> = putih, atau sedikit warna untuk kaca berwarna (misal biru kehijauan untuk botol wine)</li>
</ul>
<p>Kaca juga butuh ketebalan. Pastikan model botol memiliki <strong>solid geometry</strong> (ada ketebalan dinding). Gunakan modifier <strong>Solidify</strong> jika model masih berupa permukaan tipis.</p>

<h3>Material Cairan di Dalam Botol</h3>
<p>Cairan (parfum, air, minyak) memiliki IOR berbeda: air=1.33, alkohol=1.36, minyak=1.47. Buat objek cairan terpisah yang bentuknya mengikuti bagian dalam botol. Material cairan:</p>
<ul>
    <li><strong>Transmission</strong> = 1.0</li>
    <li><strong>IOR</strong> = sesuai cairan</li>
    <li><strong>Base Color</strong> = warna cairan (misal kuning emas untuk parfum, biru untuk air)</li>
    <li><strong>Roughness</strong> = 0.0 (cairan bening) atau sedikit untuk minyak</li>
    <li><strong>Volume Absorption</strong> (opsional): Tambahkan node <strong>Volume Absorption</strong> ke output volume material. Atur <strong>Color</strong> dan <strong>Density</strong> (0.1-0.5) untuk efek warna yang lebih dalam pada ketebalan tinggi.</li>
</ul>

<h3>Efek Botol Parfum Mewah</h3>
<p>Botol parfum sering memiliki bevel dan detail. Tambahkan <strong>Clearcoat</strong> pada material kaca (nilai 1) untuk kilau ekstra. Untuk bagian botol yang berwarna solid (misal tutup hitam), buat material terpisah dengan Metallic=0, Roughness=0.4. Agar kilau lebih dramatis, gunakan <strong>HDRI</strong> dengan kontras tinggi sebagai lingkungan.</p>

<h3>Kaca Es (Frosted Glass)</h3>
<p>Untuk kaca buram (seperti kaca shower atau botol susu), atur <strong>Roughness</strong> = 0.2-0.4, dan tambahkan sedikit <strong>Subsurface Scattering</strong> (Subsurface = 0.1, Subsurface Color = putih). Alternatif: gunakan <strong>Noise Texture</strong> yang dihubungkan ke <strong>Roughness</strong> melalui <strong>ColorRamp</strong> untuk variasi kekasaran.</p>

<h3>Catatan Penting untuk Render</h3>
<p>Kaca membutuhkan <strong>Ray Tracing</strong> yang lebih tinggi. Di Cycles, set <strong>Max Bounces</strong> > 12 (terutama Transmission bounces minimal 8). Aktifkan <strong>Caustics</strong> jika ingin efek fokus cahaya (tapi akan memperlambat render). Untuk hasil cepat, gunakan <strong>Eevee</strong> dengan pengaturan <strong>Screen Space Refraction</strong> diaktifkan.</p>',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
