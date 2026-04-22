<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Modul;
use App\Models\Submodul;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\MiniProject;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat admin
        User::create([
            'name'     => 'Admin Blender LMS',
            'email'    => 'admin@blenderlms.com',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        // 2. Buat 20 user biasa (role user) - pastikan UserFactory sudah ada
        User::factory(20)->create(['role' => 'user']);

        // 3. Panggil seeder modul
        $this->callModulSeeders();
    }

    private function callModulSeeders()
    {
        // === MODUL 1: Product Rendering Fundamentals ===
        $modul1 = Modul::create([
            'judul'      => 'Product Rendering Fundamentals',
            'deskripsi'  => 'Pelajari dasar-dasar rendering produk dengan Blender 3D. Cocok untuk pemula.',
            'sort_order' => 1,
            'gambar'     => null,
        ]);

        // Submodul 1.1
        $sub11 = Submodul::create([
            'modul_id'   => $modul1->id,
            'judul'      => 'Pengantar Product Rendering',
            'konten'     => $this->getIntroContent(),
            'sort_order' => 1,
        ]);
        $this->createQuiz($sub11->id, 'Kuis Pengantar', [
            ['Apa itu product rendering?', 'Membuat model 3D', 'Menghasilkan gambar 2D dari model 3D', 'Animasi karakter', 'Editing video', 'B'],
            ['Software utama yang digunakan?', 'AutoCAD', 'SketchUp', 'Blender', 'Maya', 'C'],
            ['Keuntungan rendering untuk klien?', 'Hemat biaya', 'Visualisasi sebelum produksi', 'Fleksibel', 'Semua benar', 'D'],
        ]);

        // Submodul 1.2
        $sub12 = Submodul::create([
            'modul_id'   => $modul1->id,
            'judul'      => 'Setup Scene dan Kamera',
            'konten'     => $this->getCameraContent(),
            'sort_order' => 2,
        ]);
        $this->createQuiz($sub12->id, 'Kuis Kamera', [
            ['Apa fungsi Depth of Field?', 'Memperjelas latar', 'Mengaburkan latar', 'Mengubah warna', 'Menambah kontras', 'B'],
            ['Focal length terbaik untuk produk?', '24mm', '50-85mm', '200mm', '15mm', 'B'],
        ]);

        // Mini Project di submodul 1.2
        MiniProject::create([
            'submodul_id'      => $sub12->id,
            'judul'            => 'Praktik: Setup Kamera',
            'deskripsi'        => 'Buat scene sederhana dengan kamera, atur Depth of Field, dan render satu frame.',
            'passing_criteria' => 'Hasil render menunjukkan efek blur latar yang jelas.',
            'sort_order'       => 1,
        ]);

        // === MODUL 2: Advanced Materials ===
        $modul2 = Modul::create([
            'judul'      => 'Advanced Materials for Products',
            'deskripsi'  => 'Pelajari material realistis: metal, plastik, kaca, dan tekstur custom.',
            'sort_order' => 2,
            'gambar'     => null,
        ]);

        $sub21 = Submodul::create([
            'modul_id'   => $modul2->id,
            'judul'      => 'Principled BSDF Deep Dive',
            'konten'     => $this->getPrincipledContent(),
            'sort_order' => 1,
        ]);
        $this->createQuiz($sub21->id, 'Kuis Material', [
            ['Parameter untuk material logam?', 'Metallic = 1', 'Roughness = 1', 'Specular = 0', 'IOR = 1', 'A'],
            ['Cara membuat kaca?', 'Metallic=1, Transmission=1', 'Metallic=0, Transmission=1', 'Roughness=0', 'Emission=1', 'B'],
        ]);

        $sub22 = Submodul::create([
            'modul_id'   => $modul2->id,
            'judul'      => 'UV Mapping dan Tekstur',
            'konten'     => $this->getUVContent(),
            'sort_order' => 2,
        ]);
        MiniProject::create([
            'submodul_id'      => $sub22->id,
            'judul'            => 'Tekstur Custom',
            'deskripsi'        => 'Buat UV mapping produk sederhana dan aplikasikan tekstur custom (logo atau pola).',
            'passing_criteria' => 'Tekstur menempel dengan rapi tanpa stretching.',
            'sort_order'       => 1,
        ]);

        // === MODUL 3: Lighting & Rendering ===
        $modul3 = Modul::create([
            'judul'      => 'Lighting & Rendering Techniques',
            'deskripsi'  => 'Teknik pencahayaan studio, HDRI, dan pengaturan render untuk hasil maksimal.',
            'sort_order' => 3,
            'gambar'     => null,
        ]);

        $sub31 = Submodul::create([
            'modul_id'   => $modul3->id,
            'judul'      => 'Studio Lighting (Three-Point)',
            'konten'     => $this->getLightingContent(),
            'sort_order' => 1,
        ]);
        $this->createQuiz($sub31->id, 'Kuis Lighting', [
            ['Apa fungsi fill light?', 'Menerangi bayangan', 'Pencahayaan utama', 'Menerangi tepi objek', 'Membuat efek flare', 'A'],
            ['HDRI kepanjangan dari?', 'High Dynamic Range Image', 'Hard Disk Rendering', 'High Density Image', 'None', 'A'],
        ]);

        $sub32 = Submodul::create([
            'modul_id'   => $modul3->id,
            'judul'      => 'Render Settings & Denoising',
            'konten'     => $this->getRenderContent(),
            'sort_order' => 2,
        ]);
        MiniProject::create([
            'submodul_id'      => $sub32->id,
            'judul'            => 'Final Render',
            'deskripsi'        => 'Render produk lengkap dengan pencahayaan studio dan material realistis. Gunakan denoising.',
            'passing_criteria' => 'Hasil render bersih, minim noise, pencahayaan merata.',
            'sort_order'       => 1,
        ]);

        // === MODUL 4: Post-Processing ===
        $modul4 = Modul::create([
            'judul'      => 'Post-Processing & Compositing',
            'deskripsi'  => 'Sempurnakan hasil render dengan Blender Compositor dan teknik pasca-produksi.',
            'sort_order' => 4,
            'gambar'     => null,
        ]);

        $sub41 = Submodul::create([
            'modul_id'   => $modul4->id,
            'judul'      => 'Compositor Nodes Dasar',
            'konten'     => $this->getCompositorContent(),
            'sort_order' => 1,
        ]);
        $this->createQuiz($sub41->id, 'Kuis Compositing', [
            ['Node untuk mengatur warna?', 'Color Balance', 'Blur', 'Glare', 'Transform', 'A'],
            ['Apa fungsi denoise?', 'Menghilangkan noise', 'Menambah grain', 'Mengaburkan', 'Memotong gambar', 'A'],
        ]);

        $sub42 = Submodul::create([
            'modul_id'   => $modul4->id,
            'judul'      => 'Export untuk Klien',
            'konten'     => $this->getExportContent(),
            'sort_order' => 2,
        ]);

        // === MODUL 5: Portfolio & Freelance Tips ===
        $modul5 = Modul::create([
            'judul'      => 'Portfolio & Freelance Tips',
            'deskripsi'  => 'Membangun portofolio product rendering dan tips memenangkan klien.',
            'sort_order' => 5,
            'gambar'     => null,
        ]);

        $sub51 = Submodul::create([
            'modul_id'   => $modul5->id,
            'judul'      => 'Membangun Portofolio',
            'konten'     => $this->getPortfolioContent(),
            'sort_order' => 1,
        ]);
        $sub52 = Submodul::create([
            'modul_id'   => $modul5->id,
            'judul'      => 'Menghadapi Klien',
            'konten'     => $this->getClientContent(),
            'sort_order' => 2,
        ]);
        MiniProject::create([
            'submodul_id'      => $sub52->id,
            'judul'            => 'Final Project: Portofolio Produk',
            'deskripsi'        => 'Buat satu render produk profesional dengan material, lighting, dan compositing. Sertakan juga file .blend.',
            'passing_criteria' => 'Kualitas studio, siap dipresentasikan ke klien.',
            'sort_order'       => 1,
        ]);
    }

    // Helper untuk membuat quiz
    private function createQuiz($submodulId, $judul, array $questions)
    {
        $quiz = Quiz::create([
            'submodul_id'   => $submodulId,
            'judul_quiz'    => $judul,
            'deskripsi'     => 'Jawab pertanyaan berikut dengan benar.',
            'passing_score' => 70,
            'sort_order'    => 1,
        ]);

        $poin = floor(100 / count($questions));
        foreach ($questions as $index => $q) {
            [$pertanyaan, $a, $b, $c, $d, $jawaban] = $q;
            Question::create([
                'quiz_id'         => $quiz->id,
                'pertanyaan'      => $pertanyaan,
                'pilihan_jawaban' => ['A' => $a, 'B' => $b, 'C' => $c, 'D' => $d],
                'jawaban_benar'   => $jawaban,
                'poin'            => $poin,
                'urutan'          => $index + 1,
            ]);
        }
    }

    // === KONTEN RICH TEXT UNTUK SETIAP SUBMODUL ===

    private function getIntroContent()
    {
        return <<<HTML
<h2>Selamat Datang di Product Rendering</h2>
<p>Product rendering adalah proses menciptakan gambar fotorealistik dari model 3D produk. Di Blender, kita menggunakan <strong>Cycles</strong> atau <strong>Eevee</strong> sebagai render engine.</p>

<h3>Apa yang akan Anda pelajari?</h3>
<ul>
    <li>Modeling hard-surface untuk produk</li>
    <li>Material realistis (metal, plastik, kaca)</li>
    <li>Pencahayaan studio (three-point lighting)</li>
    <li>Pengaturan kamera dan Depth of Field</li>
    <li>Post-processing dengan Compositor</li>
</ul>

<h3>Perangkat yang Dibutuhkan</h3>
<table style="width:100%; border-collapse:collapse;">
    <thead style="background:#f0f0f0;"><tr><th>Komponen</th><th>Minimum</th><th>Rekomendasi</th></tr></thead>
    <tbody>
        <tr><td>CPU</td><td>Intel i5</td><td>Intel i7 / AMD Ryzen 7</td></tr>
        <tr><td>GPU</td><td>GTX 1060</td><td>RTX 3060+</td></tr>
        <tr><td>RAM</td><td>16GB</td><td>32GB</td></tr>
    </tbody>
</table>

<p>Pastikan Anda sudah menginstal Blender versi terbaru (3.6 atau 4.x).</p>
HTML;
    }

    private function getCameraContent()
    {
        return <<<HTML
<h2>Setup Kamera untuk Product Rendering</h2>
<p>Kamera adalah mata kita ke scene. Pengaturan yang tepat akan menghasilkan komposisi profesional.</p>

<h3>Depth of Field (DOF)</h3>
<p>DOF membuat latar belakang buram, sehingga produk lebih menonjol. Caranya:</p>
<ol>
    <li>Pilih kamera, aktifkan <strong>Depth of Field</strong> di properties.</li>
    <li>Atur <strong>Focus Object</strong> ke produk Anda.</li>
    <li>Atur <strong>Aperture F-stop</strong> (nilai kecil = blur lebih kuat).</li>
</ol>

<h3>Focal Length</h3>
<p>Untuk produk, gunakan focal length antara 50mm hingga 85mm. Hindari wide angle (distorsi) dan tele (kompresi berlebihan).</p>

<h3>Komposisi</h3>
<p>Gunakan panduan <strong>Rule of Thirds</strong> (aktifkan di kamera > Composition Guides). Tempatkan produk di titik perpotongan garis.</p>

<p>Latihan: Buat scene sederhana dengan satu objek (misal kubus atau bola). Atur kamera sehingga produk berada di tengah dengan latar blur. Render untuk melihat hasil.</p>
HTML;
    }

    private function getPrincipledContent()
    {
        return <<<HTML
<h2>Principled BSDF: Material Universal</h2>
<p>Principled BSDF adalah shader paling serbaguna di Blender. Berikut parameter penting:</p>

<ul>
    <li><strong>Base Color</strong>: Warna dasar material.</li>
    <li><strong>Metallic</strong>: 0 = non-logam, 1 = logam.</li>
    <li><strong>Roughness</strong>: 0 = mengkilap, 1 = matte.</li>
    <li><strong>Clearcoat</strong>: Lapisan transparan (untuk cat mobil).</li>
    <li><strong>Transmission</strong>: Untuk kaca (atur ke 1).</li>
    <li><strong>IOR</strong>: Indeks bias (kaca = 1.45).</li>
</ul>

<h3>Contoh Material</h3>
<table style="width:100%; border-collapse:collapse;">
    <thead><tr><th>Material</th><th>Metallic</th><th>Roughness</th><th>Base Color</th></tr></thead>
    <tbody>
        <tr><td>Plastik matte</td><td>0</td><td>0.6</td><td>Sesuai produk</td></tr>
        <tr><td>Metal mengkilap</td><td>1</td><td>0.2</td><td>#C0C0C0 (perak)</td></tr>
        <tr><td>Kaca</td><td>0</td><td>0.1</td><td>Putih (Transmission=1)</td></tr>
    </tbody>
</table>

<p>Latihan: Buat material metal untuk sebuah bola. Atur roughness = 0.2, tambahkan lingkungan (world) dengan warna putih agar refleksi terlihat.</p>
HTML;
    }

    private function getUVContent()
    {
        return <<<HTML
<h2>UV Mapping untuk Tekstur Custom</h2>
<p>UV mapping adalah proses membuka model 3D menjadi bidang 2D agar tekstur bisa ditempel.</p>

<h3>Langkah UV Mapping:</h3>
<ol>
    <li>Pilih objek, masuk ke Edit Mode.</li>
    <li>Pilih edge yang akan menjadi seam (tepi potongan).</li>
    <li>Tekan <strong>U</strong> -> <strong>Unwrap</strong>.</li>
    <li>Atur tata letak UV di UV Editor.</li>
</ol>

<h3>Tekstur Custom</h3>
<p>Setelah UV selesai, buat material baru. Tambahkan <strong>Image Texture</strong> node, load gambar logo atau pola. Hubungkan ke <strong>Base Color</strong>. Atur mapping agar posisi sesuai.</p>

<p>Latihan: Buat model botol sederhana, lakukan UV unwrap, lalu aplikasikan tekstur logo (buat gambar sederhana di luar Blender).</p>
HTML;
    }

    private function getLightingContent()
    {
        return <<<HTML
<h2>Studio Lighting (Three-Point Lighting)</h2>
<p>Pencahayaan tiga titik adalah teknik standar fotografi studio:</p>

<ul>
    <li><strong>Key Light</strong>: Lampu utama, paling terang, sudut 45°.</li>
    <li><strong>Fill Light</strong>: Mengisi bayangan, lebih redup, dari sisi berlawanan.</li>
    <li><strong>Back Light / Rim Light</strong>: Menerangi tepi produk, memisahkan dari latar.</li>
</ul>

<h3>HDRI</h3>
<p>HDRI (High Dynamic Range Image) memberikan pencahayaan lingkungan yang realistis. Di Blender, buka World Properties -> Surface -> Environment Texture, lalu pilih file HDRI (bisa download dari Poly Haven).</p>

<p>Latihan: Buat scene dengan produk, tambahkan HDRI, lalu tambahkan area light sebagai key light dan fill light. Atur intensitas dan warna.</p>
HTML;
    }

    private function getRenderContent()
    {
        return <<<HTML
<h2>Pengaturan Render di Cycles</h2>
<p>Cycles adalah render engine ray-tracing yang menghasilkan kualitas fotorealistik.</p>

<h3>Parameter Penting:</h3>
<ul>
    <li><strong>Sampling</strong>: Render > Sampling > Render. Mulai dengan 512 sample, naikkan jika perlu.</li>
    <li><strong>Denoising</strong>: Aktifkan di Render Layers > Denoising. Pilih OptiX (jika GPU support).</li>
    <li><strong>Light Paths</strong>: Untuk kaca, atur Max Bounces = 12, Transmission = 12.</li>
    <li><strong>Resolution</strong>: Output Properties > Resolution. Untuk preview 1080p, final 4K.</li>
</ul>

<h3>Tips Cepat:</h3>
<p>Gunakan <strong>Render Region</strong> (Ctrl+B) untuk render area kecil saat uji coba. Aktifkan <strong>Viewport Denoising</strong> untuk preview cepat.</p>

<p>Latihan: Render produk Anda dengan 512 sample, denoising aktif. Ekspor ke PNG.</p>
HTML;
    }

    private function getCompositorContent()
    {
        return <<<HTML
<h2>Blender Compositor</h2>
<p>Compositor memungkinkan Anda mengedit gambar pasca-render tanpa software lain.</p>

<h3>Node Dasar:</h3>
<ul>
    <li><strong>Render Layers</strong> (output dari render)</li>
    <li><strong>Color Balance</strong> untuk koreksi warna</li>
    <li><strong>Glare</strong> untuk efek flare</li>
    <li><strong>Denoise</strong> untuk menghilangkan noise (gunakan data denoising dari render)</li>
    <li><strong>Composite</strong> node (output akhir)</li>
</ul>

<h3>Contoh Setup:</h3>
<p>Render Layers -> Denoise -> Color Balance -> Glare -> Composite.</p>
<p>Atur Color Balance agar kontras dan saturasi pas. Glare bisa ditambahkan untuk efek sinar pada area terang.</p>

<p>Latihan: Render satu produk, lalu buka Compositor. Tambahkan denoise dan color balance. Simpan hasilnya.</p>
HTML;
    }

    private function getExportContent()
    {
        return <<<HTML
<h2>Export untuk Klien</h2>
<p>Setelah render, Anda perlu menyajikan hasil dengan format yang tepat.</p>

<h3>Format File:</h3>
<ul>
    <li><strong>PNG</strong>: Untuk gambar dengan latar transparan (alpha).</li>
    <li><strong>JPG</strong>: Ukuran kecil, tanpa transparansi.</li>
    <li><strong>EXR</strong>: Format high dynamic range untuk post-processing lanjutan.</li>
</ul>

<h3>Tips Presentasi:</h3>
<ul>
    <li>Buat beberapa angle produk (depan, samping, close-up).</li>
    <li>Simpan file .blend beserta tekstur dalam satu folder.</li>
    <li>Jika perlu, buat turntable video (360°).</li>
</ul>

<p>Latihan: Render 3 angle produk berbeda, ekspor ke PNG dengan resolusi 1920x1080. Gabungkan dalam satu presentasi.</p>
HTML;
    }

    private function getPortfolioContent()
    {
        return <<<HTML
<h2>Membangun Portofolio Product Rendering</h2>
<p>Portofolio adalah kunci untuk memenangkan klien. Berikut tipsnya:</p>

<ul>
    <li>Pilih 5-10 karya terbaik, bukan puluhan.</li>
    <li>Tampilkan berbagai jenis material (metal, plastik, kaca).</li>
    <li>Sertakan wireframe atau breakdown untuk menunjukkan proses.</li>
    <li>Buat presentasi yang bersih (gunakan ArtStation, Behance, atau website sendiri).</li>
</ul>

<h3>Contoh Struktur Portofolio:</h3>
<ol>
    <li>Halaman depan: Karya unggulan</li>
    <li>Galeri: Render produk (setiap produk 3-4 angle)</li>
    <li>Tentang Saya: Skill, software, pengalaman</li>
    <li>Kontak</li>
</ol>

<p>Latihan: Pilih satu render terbaik Anda, buat halaman sederhana di ArtStation atau Behance.</p>
HTML;
    }

    private function getClientContent()
    {
        return <<<HTML
<h2>Menghadapi Klien Freelance</h2>
<p>Sebagai freelancer, komunikasi dengan klien sangat penting.</p>

<h3>Tips Negosiasi:</h3>
<ul>
    <li>Minta brief yang jelas (referensi produk, angle, gaya).</li>
    <li>Tentukan revisi maksimal (misal 3 kali).</li>
    <li>Berikan estimasi waktu dan harga transparan.</li>
    <li>Gunakan kontrak sederhana (bisa dari template online).</li>
</ul>

<h3>Contoh Harga (IDR):</h3>
<table style="width:100%;">
    <tr><th>Jenis</th><th>Harga</th></tr>
    <tr><td>Render produk sederhana (1 angle)</td><td>200k - 500k</td></tr>
    <tr><td>Render kompleks (multi angle, material custom)</td><td>500k - 2jt</td></tr>
    <tr><td>Turntable video</td><td>1jt - 3jt</td></tr>
</table>

<p>Latihan: Buat satu portofolio produk fiktif, lalu tulis proposal sederhana untuk klien.</p>
HTML;
    }
}
