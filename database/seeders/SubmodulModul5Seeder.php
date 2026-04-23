<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmodulModul5Seeder extends Seeder
{
    public function run(): void
    {
        // Hapus hanya submodul milik modul 5
        DB::table('submoduls')->where('modul_id', 5)->delete();

        DB::table('submoduls')->insert([
            [
                'id' => 17,
                'modul_id' => 5,
                'judul' => 'Studi Kasus Lengkap: Dari Nol Sampai Jadi (Botol Skincare / Gadget)',
                'konten' => '<h2>Menyatukan Semua Ilmu dalam Satu Proyek Produk</h2>
<p>Proyek praktik ini akan memandu Anda membuat satu produk secara utuh, mulai dari modeling hingga render akhir. Pilih salah satu: botol skincare atau gadget (misal smartwatch). Berikut alur lengkapnya.</p>

<h3>Tahap 1: Modeling & Referensi</h3>
<ul>
    <li>Cari gambar referensi produk asli (depan, samping, atas).</li>
    <li>Impor sebagai <strong>Background Image</strong> atau <strong>Reference</strong> di Blender.</li>
    <li>Gunakan teknik <strong>Sub-D modeling</strong> untuk membuat bentuk utama (silinder untuk botol, kubus dengan bevel untuk gadget).</li>
    <li>Tambahkan detail seperti tutup, label area, tombol (untuk gadget).</li>
    <li>Gunakan <strong>Bevel modifier</strong> pada semua pinggiran (width 0.002–0.005 meter).</li>
</ul>

<h3>Tahap 2: Material & Branding</h3>
<ul>
    <li>Buat material: plastik glossy untuk bodi, logam untuk aksen (jika ada).</li>
    <li>Untuk botol skincare: material kaca (Transmission=1, IOR=1.45) + cairan di dalam (IOR=1.33, warna sesuai produk).</li>
    <li>Pasang logo/label dengan UV mapping: buat seam, unwrap, lalu gunakan <strong>Image Texture</strong> (PNG transparan) di area label.</li>
</ul>

<h3>Tahap 3: Pencahayaan Studio</h3>
<ul>
    <li>Setup backdrop melengkung (plane dengan subdivision).</li>
    <li>Pasang <strong>Three-point lighting</strong>: Key light (Area, power 500W, sudut 45° kiri depan), Fill light (Area, power 200W, kanan depan), Rim light (Area di belakang, power 800W).</li>
    <li>Atur agar rim light menciptakan garis cahaya di tepi produk.</li>
</ul>

<h3>Tahap 4: Kamera & Render</h3>
<ul>
    <li>Pilih focal length 85mm untuk perspektif natural.</li>
    <li>Aktifkan <strong>Depth of Field</strong> dengan focus object ke produk, aperture f/2.8–f/5.6.</li>
    <li>Atur resolusi 1920x1920 (persegi untuk Instagram).</li>
    <li>Render dengan Cycles: 512 sample + OptiX/OpenImageDenoise.</li>
</ul>

<h3>Tahap 5: Post-Processing (Compositor)</h3>
<ul>
    <li>Buka Compositor, tambahkan node <strong>Denoise</strong> (jika belum).</li>
    <li>Tambah <strong>Color Balance</strong>: naikkan <strong>Midtones Contrast</strong> sedikit, <strong>Highlights</strong> +0.1.</li>
    <li>Tambah <strong>Glare</strong> (Fog Glow) untuk efek kilau pada area terang (threshold 0.8, size 9).</li>
    <li>Simpan sebagai PNG dengan alpha (jika perlu transparan).</li>
</ul>

<p>Hasil akhir dari studi kasus ini akan menjadi karya portofolio utama Anda.</p>',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 18,
                'modul_id' => 5,
                'judul' => 'Post-Processing Sederhana di Blender Compositor',
                'konten' => '<h2>Sentuhan Akhir Agar Gambar Lebih "Pop" Tanpa Software Lain</h2>
<p>Compositor internal Blender sudah cukup untuk melakukan koreksi warna dan efek sederhana yang membuat render produk lebih menarik.</p>

<h3>Setup Compositor Dasar</h3>
<ol>
    <li>Buka workspace <strong>Compositing</strong>.</li>
    <li>Centang <strong>Use Nodes</strong> (otomatis muncul node Render Layers dan Composite).</li>
    <li>Tambahkan node dengan <strong>Shift + A</strong>.</li>
</ol>

<h3>Node Wajib untuk Product Rendering</h3>

<h4>1. Denoise (jika render dengan sample rendah)</h4>
<p>Tambahkan node <strong>Denoise</strong>. Hubungkan <strong>Image</strong> dari Render Layers ke <strong>Image</strong> Denoise. Hubungkan output Denoise ke Composite. Jika ada <strong>Denoising Normal</strong> dan <strong>Denoising Albedo</strong> di Render Layers (harus diaktifkan di Passes sebelum render), sambungkan juga untuk hasil optimal.</p>

<h4>2. Color Balance (Koreksi Warna)</h4>
<p>Tambahkan node <strong>Color Balance</strong> (bukan RGB Curves untuk pemula). Atur <strong>Correction Mode</strong> = <strong>Lift/Gamma/Gain</strong> (lebih intuitif).</p>
<ul>
    <li><strong>Lift</strong> (bayangan): sedikit hijau/sian untuk menghilangkan merah berlebih, atau sebaliknya.</li>
    <li><strong>Gamma</strong> (midtones): naikkan nilai 1.05–1.1 untuk mencerahkan midtone.</li>
    <li><strong>Gain</strong> (highlight): turunkan sedikit (0.95) jika highlight terlalu terang.</li>
</ul>

<h4>3. Glare (Efek Flare / Kilau)</h4>
<p>Tambahkan node <strong>Glare</strong>. Pilih <strong>Fog Glow</strong> untuk efek glow halus pada area terang. Parameter:</p>
<ul>
    <li><strong>Threshold</strong>: 0.8–0.9 (hanya area sangat terang yang terkena).</li>
    <li><strong>Size</strong>: 9–15 (semakin besar semakin luas glow).</li>
    <li><strong>Mix</strong>: 0.2–0.4 (jangan terlalu kuat).</li>
</ul>

<h4>4. Hue Saturation Value (HSV)</h4>
<p>Tambahkan node <strong>Hue/Saturation</strong>. Untuk produk dengan warna jenuh, naikkan <strong>Saturation</strong> menjadi 1.1–1.2. Untuk kulit atau tekstil natural, turunkan menjadi 0.9.</p>

<h3>Contoh Rantai Node Standar</h3>
<p>Render Layers → Denoise → Color Balance → Glare → Hue/Saturation → Composite.</p>

<h3>Tips Cepat</h3>
<ul>
    <li>Jangan terlalu banyak efek. Cukup 2-3 node sudah membuat perbedaan besar.</li>
    <li>Gunakan <strong>Viewer Node</strong> (Shift+A > Output > Viewer) untuk membandingkan sebelum-sesudah.</li>
    <li>Simpan preset compositor dengan <strong>Node Tree > Make Group</strong> untuk digunakan ulang.</li>
</ul>

<p>Dengan compositing sederhana ini, render produk Anda akan terlihat lebih profesional dan siap dipamerkan ke klien.</p>',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 19,
                'modul_id' => 5,
                'judul' => 'Tips Menyusun Portofolio agar Dilirik Klien di Platform Freelance',
                'konten' => '<h2>Membangun Portofolio Product Rendering yang Efektif</h2>
<p>Portofolio adalah aset terpenting untuk mendapatkan klien. Berikut panduan menyusun portofolio yang menarik perhatian di platform seperti Fiverr, Upwork, atau Sribulancer.</p>

<h3>1. Pilih 5–10 Karya Terbaik (Bukan Puluhan)</h3>
<p>Kualitas lebih penting daripada kuantitas. Klien hanya butuh melihat beberapa contoh yang mewakili kemampuan terbaik Anda. Sertakan berbagai jenis material: plastik, logam, kaca, dan tekstil.</p>

<h3>2. Tampilkan Multiple Angle</h3>
<p>Untuk setiap produk, tunjukkan minimal 3 sudut: depan, 3/4, dan close-up detail. Ini menunjukkan bahwa Anda bisa menangani komposisi yang beragam.</p>

<h3>3. Sertakan Wireframe atau Breakdown</h3>
<p>Tambahkan satu gambar wireframe (edit mode) atau breakdown material untuk menunjukkan bahwa Anda memahami topologi dan shading. Klien profesional menghargai transparansi teknis.</p>

<h3>4. Gunakan Platform yang Tepat</h3>
<ul>
    <li><strong>ArtStation</strong>: Standar industri untuk seniman 3D. Cocok untuk portofolio utama.</li>
    <li><strong>Behance</strong>: Lebih luas, banyak klien desain grafis.</li>
    <li><strong>Instagram</strong>: Untuk menjangkau klien langsung (gunakan tagar seperti #productrendering #blender3d).</li>
    <li><strong>Portofolio Website sendiri</strong> (pakai Carrd, WordPress, atau Framer): Tampil lebih profesional.</li>
</ul>

<h3>5. Struktur Portofolio yang Direkomendasikan</h3>
<ul>
    <li><strong>Halaman depan</strong>: Karya unggulan (1 render terbaik) + judul dan tagline.</li>
    <li><strong>Galeri proyek</strong>: Setiap proyek memiliki halaman sendiri dengan judul, deskripsi singkat (software, durasi, tantangan), dan 3-5 gambar.</li>
    <li><strong>Tentang Saya</strong>: Skill (Blender, Cycles, UV mapping, dll), pengalaman (meskipun hanya proyek pribadi), dan tools yang dikuasai.</li>
    <li><strong>Kontak</strong>: Email, tautan freelance, atau formulir sederhana.</li>
</ul>

<h3>6. Contoh Deskripsi Proyek yang Menarik</h3>
<blockquote style="border-left: 4px solid #ff6b6b; padding-left: 16px;">
"Botol skincare dengan material kaca dan cairan transparan. Saya menggunakan teknik three-point lighting untuk menonjolkan refleksi dan depth of field untuk efek premium. Render dengan Cycles pada 4K, post-processing di Blender Compositor."
</blockquote>

<h3>7. Perbarui Portofolio Secara Berkala</h3>
<p>Hapus karya lama yang sudah tidak mewakili kemampuan Anda. Tambahkan proyek baru setiap 1-2 bulan untuk menunjukkan perkembangan.</p>

<p>Dengan portofolio yang rapi dan profesional, Anda akan lebih mudah mendapatkan klien pertama.</p>',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 20,
                'modul_id' => 5,
                'judul' => 'Checklist Pengiriman Hasil Kerja ke Klien',
                'konten' => '<h2>Apa Saja yang Harus Diberikan Saat Proyek Selesai?</h2>
<p>Agar klien puas dan mengurangi revisi, kirimkan paket lengkap yang berisi semua elemen yang diperlukan. Berikut checklist standar untuk freelance product rendering.</p>

<h3>Wajib Disertakan</h3>
<ul>
    <li><strong>Gambar final</strong> (JPEG/PNG) sesuai angle yang disepakati. Resolusi minimal 1920x1080 atau sesuai permintaan klien.</li>
    <li><strong>File sumber (.blend)</strong> – termasuk model, material, tekstur, pencahayaan, dan kamera. Beri nama folder yang rapi (contoh: "NamaProduk_BlendFile").</li>
    <li><strong>Folder tekstur</strong> (jika ada) – semua image texture yang digunakan (logo, bump map, dll). Pastikan path relatif atau sudah di-pack (File > External Data > Pack Resources).</li>
</ul>

<h3>Opsional tetapi Disarankan</h3>
<ul>
    <li><strong>Render tanpa background (alpha)</strong> – PNG transparan untuk keperluan klien mengedit latar sendiri.</li>
    <li><strong>Wireframe overlay</strong> – satu gambar yang menunjukkan topologi model (bisa dari viewport dengan Wireframe material).</li>
    <li><strong>Turntable video</strong> (360°) – animasi singkat (10-15 frame) dalam format MP4 atau GIF.</li>
    <li><strong>Render passes</strong> (jika klien minta) – misal Diffuse, Glossy, Shadow, Normal untuk compositing lanjutan. Ekspor dalam format OpenEXR multilayer.</li>
</ul>

<h3>Struktur Folder yang Rapi</h3>
<pre style="background:#f0f0f0; padding:10px; border-radius:8px;">
Project_NamaProduk/
├── 01_Final_Renders/
│   ├── angle_1.png
│   ├── angle_2.png
│   └── angle_3.png
├── 02_Source_Files/
│   └── product.blend
├── 03_Textures/
│   ├── logo.png
│   └── label_diffuse.jpg
├── 04_Extras/
│   ├── wireframe.png
│   └── turntable.mp4
└── 05_Delivery_Note.txt
</pre>

<h3>Catatan Pengiriman (Delivery Note)</h3>
<p>Sertakan file teks (.txt) yang berisi:</p>
<ul>
    <li>Daftar file yang disertakan.</li>
    <li>Versi Blender yang digunakan (misal 4.2).</li>
    <li>Instruksi singkat: cara membuka file, render ulang jika diperlukan.</li>
    <li>Lisensi penggunaan (apakah klien boleh mengedit, mencetak, dll).</li>
</ul>

<h3>Tips Komunikasi Setelah Pengiriman</h3>
<ul>
    <li>Kirim melalui Google Drive atau WeTransfer (jangan email attachment besar).</li>
    <li>Beri tahu klien bahwa file sudah siap, sertakan link download.</li>
    <li>Tanyakan apakah ada revisi kecil (sesuai kontrak).</li>
    <li>Setelah final, minta testimoni untuk portofolio.</li>
</ul>

<p>Dengan mengikuti checklist ini, Anda akan terlihat profesional dan klien lebih mungkin merekomendasikan Anda ke orang lain.</p>',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
