<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmodulModul3Seeder extends Seeder
{
    public function run(): void
    {
        // Hapus hanya submodul milik modul 3
        DB::table('submoduls')->where('modul_id', 3)->delete();

        DB::table('submoduls')->insert([
            [
                'id' => 9,
                'modul_id' => 3,
                'judul' => 'Setup Virtual Studio (Backdrop Mulus)',
                'konten' => '<h2>Menciptakan Background Studio yang Profesional</h2>
<p>Background yang mulus (seamless backdrop) adalah ciri khas fotografi produk studio. Di Blender, Anda bisa membuatnya dengan bidang lengkung (curved plane) atau lingkungan HDRI.</p>

<h3>Metode 1: Bidang Lengkung (Curved Backdrop)</h3>
<ol>
    <li>Buat bidang (plane) dengan ukuran besar (misal 10x10 meter).</li>
    <li>Tambahkan modifier <strong>Subdivision Surface</strong> (Levels = 2).</li>
    <li>Masuk ke Edit Mode, pilih satu sisi bidang, gunakan <strong>Extrude</strong> (E) dan <strong>Scale</strong> (S) untuk membentuk kurva ke atas.</li>
    <li>Atur posisi produk di tengah bidang, sehingga latar belakang terlihat mulus tanpa garis sambungan.</li>
</ol>

<h3>Metode 2: Lingkungan HDRI + Ground Plane</h3>
<p>Gunakan HDRI dengan studio lighting (banyak tersedia gratis di Poly Haven). Tambahkan plane di bawah produk sebagai "lantai" dengan material glossy atau matte sesuai kebutuhan. Keuntungan: pencahayaan langsung realistis, kekurangan: kontrol terbatas dibanding lampu buatan sendiri.</p>

<h3>Material Backdrop</h3>
<p>Backdrop biasanya berwarna putih, hitam, atau abu-abu gradien. Gunakan <strong>Principled BSDF</strong> dengan Base Color putih, Roughness 0.5-0.8. Untuk efek gradien, tambahkan <strong>Gradient Texture</strong> yang dihubungkan ke <strong>ColorRamp</strong>, lalu ke Base Color.</p>

<h3>Tips Komposisi</h3>
<ul>
    <li>Jarak produk ke backdrop sekitar 1-2 meter untuk menghindari bayangan keras.</li>
    <li>Gunakan <strong>Shadow Catcher</strong> (pada plane) jika ingin latar belakang transparan untuk compositing.</li>
    <li>Aktifkan <strong>Film > Transparent</strong> di Render Properties untuk output PNG dengan alpha.</li>
</ul>',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'modul_id' => 3,
                'judul' => 'Lighting 3 Titik (Three-Point Lighting)',
                'konten' => '<h2>Teknik Dasar Pencahayaan Studio untuk Dimensi Produk</h2>
<p>Three-point lighting adalah standar industri untuk menyinari produk agar terlihat memiliki volume, tekstur, dan kedalaman. Terdiri dari tiga elemen utama.</p>

<h3>1. Key Light (Lampu Utama)</h3>
<p>Lampu paling terang, ditempatkan di sudut 30-45° dari kamera, sedikit di atas produk. Fungsinya: memberikan pencahayaan dominan dan menentukan arah bayangan. Gunakan <strong>Area Light</strong> atau <strong>Point Light</strong> dengan intensitas tinggi (misal 500-1000 W).</p>

<h3>2. Fill Light (Lampu Pengisi)</h3>
<p>Ditempatkan di sisi berlawanan dari key light, lebih redup (intensitas 30-50% key light). Fungsinya: mengisi bayangan agar tidak terlalu gelap, menjaga detail di area gelap. Bisa menggunakan <strong>Area Light</strong> dengan warna sedikit hangat atau dingin untuk efek tertentu.</p>

<h3>3. Rim Light / Back Light (Lampu Tepi)</h3>
<p>Ditempatkan di belakang produk, menyorot tepi dari belakang. Fungsinya: memisahkan produk dari latar belakang, menciptakan efek "glow" di pinggiran. Intensitas bisa sama dengan key light atau lebih tinggi. Untuk produk logam atau kaca, rim light sangat penting.</p>

<h3>Praktik Pengaturan di Blender</h3>
<ul>
    <li>Gunakan <strong>Area Light</strong> dengan bentuk persegi panjang untuk cahaya lembut.</li>
    <li>Atur <strong>Size</strong> area light: semakin besar, semakin lembut bayangan.</li>
    <li>Gunakan <strong>Power</strong> (Watt) atau <strong>Strength</strong> (dalam satuan irradiance).</li>
    <li>Aktifkan <strong>Use Nodes</strong> pada lampu untuk mengontrol warna dan intensitas secara presisi.</li>
</ul>

<h3>Variasi</h3>
<p>Untuk produk logam reflektif, kurangi fill light dan perkuat rim light agar pantulan lebih dramatis. Untuk produk matte (plastik, kertas), fill light bisa lebih tinggi untuk menonjolkan tekstur permukaan.</p>',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 11,
                'modul_id' => 3,
                'judul' => 'Refleksi Produk (Rim Lighting) untuk Kesan Premium',
                'konten' => '<h2>Menciptakan Garis Cahaya di Pinggiran Produk</h2>
<p>Rim lighting (juga disebut edge light atau kicker) adalah teknik menempatkan lampu di belakang produk sehingga menciptakan garis terang di tepi objek. Efek ini memberikan kesan premium, dramatis, dan memisahkan produk dari latar.</p>

<h3>Cara Setup Rim Light</h3>
<ol>
    <li>Posisikan <strong>Area Light</strong> atau <strong>Spot Light</strong> di belakang produk, mengarah ke produk.</li>
    <li>Tinggikan sedikit lampu (30-45° di atas produk) agar cahaya mengenai tepi atas dan samping.</li>
    <li>Atur intensitas lebih tinggi dari key light (bisa 1.5x - 2x).</li>
    <li>Gunakan bentuk area light yang panjang (ratio lebar:tinggi = 2:1 atau lebih) untuk garis cahaya yang kontinu.</li>
</ol>

<h3>Mengontrol Lebar dan Kekuatan Garis</h3>
<ul>
    <li><strong>Lebar garis</strong>: Dipengaruhi oleh jarak lampu ke produk. Semakin dekat, garis semakin tegas dan lebar.</li>
    <li><strong>Kekuatan</strong>: Atur strength lampu. Untuk produk gelap, rim light harus lebih kuat agar terlihat.</li>
    <li><strong>Warna</strong>: Rim light sering diberi warna hangat (kuning emas) untuk produk mewah, atau dingin (biru) untuk elektronik modern.</li>
</ul>

<h3>Contoh untuk Berbagai Jenis Produk</h3>
<table style="width:100%; border-collapse:collapse; border:1px solid #ddd;">
    <thead style="background:#f0f0f0;"><tr><th>Produk</th><th>Rekomendasi Rim Light</th><th>Efek yang Diharapkan</th></tr></thead>
    <tbody>
        <tr><td>Botol parfum kaca</td><td>Dua rim light (kiri dan kanan belakang)</td><td>Garis cahaya di kedua sisi, efek mewah</td></tr>
        <tr><td>Smartphone metal</td><td>Satu rim light dari atas belakang</td><td>Garis tipis di tepi atas, kesan premium</td></tr>
        <tr><td>Sepatu kulit</td><td>Rim light dari samping belakang</td><td>Menonjolkan tekstur dan bentuk</td></tr>
    </tbody>
</table>

<h3>Teknik Lanjutan: Negative Rim Light</h3>
<p>Untuk produk transparan, gunakan papan hitam di belakang rim light (bukan cahaya putih). Ini akan menciptakan garis gelap di tepi produk, sering digunakan untuk kaca bening agar lebih dramatis.</p>',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'modul_id' => 3,
                'judul' => 'Kamera & Fokus (Depth of Field)',
                'konten' => '<h2>Mengatur Kamera untuk Depth of Field dan Bokeh</h2>
<p>Depth of Field (DOF) adalah efek blur pada latar belakang atau latar depan, yang memfokuskan mata pada produk. Di Blender, DOF diatur dari properti kamera.</p>

<h3>Langkah Mengaktifkan DOF</h3>
<ol>
    <li>Pilih kamera di Outliner atau 3D Viewport.</li>
    <li>Di Properties > Camera, aktifkan <strong>Depth of Field</strong>.</li>
    <li>Atur <strong>Focus Object</strong> ke produk Anda (atau gunakan <strong>Empty</strong> sebagai target fokus).</li>
    <li>Atur nilai <strong>Aperture F-stop</strong>: semakin kecil nilai, semakin kuat blur (misal f/1.4 blur kuat, f/16 blur tipis).</li>
</ol>

<h3>Parameter Penting</h3>
<ul>
    <li><strong>Focus Distance</strong>: Jarak dari kamera ke titik fokus (otomatis jika pakai Focus Object).</li>
    <li><strong>Aperture Blades</strong>: Jumlah blade untuk bentuk bokeh (default 0 = lingkaran sempurna, 4-8 untuk efek poligon).</li>
    <li><strong>Rotation</strong>: Memutar bentuk bokeh (misal untuk efek anamorphic).</li>
    <li><strong>Ratio</strong>: Anamorphic ratio (untuk efek lensa sinema).</li>
</ul>

<h3>Memilih Focal Length</h3>
<p>Focal length lensa mempengaruhi perspektif dan komposisi:</p>
<ul>
    <li><strong>50mm – 85mm</strong>: Ideal untuk produk (perspektif natural, tidak terlalu distort).</li>
    <li><strong>100mm – 135mm</strong>: Untuk close-up detail produk kecil (perhiasan, arloji).</li>
    <li><strong>24mm – 35mm</strong>: Hanya untuk produk besar atau ingin efek dramatis (waspada distorsi).</li>
</ul>

<h3>Komposisi Kamera</h3>
<p>Gunakan panduan <strong>Composition Guides</strong> (di kamera > Viewport Display > Composition Guides) seperti <strong>Rule of Thirds</strong> atau <strong>Center</strong>. Tempatkan produk di titik perpotongan garis untuk komposisi terbaik.</p>

<h3>Tips Bokeh yang Indah</h3>
<ul>
    <li>Bokeh yang bagus membutuhkan latar belakang dengan titik-titik cahaya kecil (misal lampu atau pantulan).</li>
    <li>Gunakan <strong>Anisotropic</strong> (ratio 0.2-0.5) untuk efek lensa vintage.</li>
    <li>Di Cycles, pastikan <strong>Max Bounces</strong> cukup tinggi (minimal 8) agar blur tidak menghasilkan noise.</li>
    <li>Untuk preview cepat, gunakan <strong>Viewport DOF</strong> di Eevee (aktifkan <strong>Depth of Field</strong> di Render Properties).</li>
</ul>

<p>Dengan DOF yang tepat, produk akan tampak seperti difoto dengan kamera profesional, bukan sekadar render 3D biasa.</p>',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
