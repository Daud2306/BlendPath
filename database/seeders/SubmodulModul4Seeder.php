<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmodulModul4Seeder extends Seeder
{
    public function run(): void
    {
        // Hapus hanya submodul milik modul 4
        DB::table('submoduls')->where('modul_id', 4)->delete();

        DB::table('submoduls')->insert([
            [
                'id' => 13,
                'modul_id' => 4,
                'judul' => 'Optimasi Render Engine (Cycles)',
                'konten' => '<h2>Mendapatkan Render Cepat dengan Kualitas Tinggi di Cycles</h2>
<p>Cycles adalah render engine ray-tracing yang realistis tetapi bisa lambat. Berikut optimasi untuk mempercepat render tanpa mengorbankan kualitas secara signifikan.</p>

<h3>1. Sampling (Jumlah Sampel)</h3>
<p>Sampling menentukan jumlah sinar cahaya per pixel. Nilai default sering terlalu tinggi untuk preview.</p>
<ul>
    <li><strong>Preview (Viewport)</strong>: 64–128 sample, aktifkan <strong>Viewport Denoising</strong>.</li>
    <li><strong>Render Final</strong>: Mulai dengan 256–512 sample. Untuk produk dengan kaca/logam, naikkan ke 1024.</li>
    <li>Gunakan <strong>Adaptive Sampling</strong> (aktif di Render Properties > Sampling). Ini menghentikan sampling pada area yang sudah konvergen.</li>
</ul>

<h3>2. Light Paths (Max Bounces)</h3>
<p>Light paths mengontrol berapa kali sinar cahaya memantul. Kurangi untuk scene sederhana.</p>
<ul>
    <li><strong>Total Max Bounces</strong>: 8–12 (default 12). Untuk produk saja, 8 cukup.</li>
    <li><strong>Diffuse Bounces</strong>: 4–6.</li>
    <li><strong>Glossy Bounces</strong>: 4–6 (untuk logam).</li>
    <li><strong>Transmission Bounces</strong>: 8–12 (untuk kaca).</li>
    <li><strong>Volume Bounces</strong>: 0–2 (jika tidak ada asap/kabut).</li>
</ul>

<h3>3. Filter Glossy & Clamp</h3>
<ul>
    <li><strong>Filter Glossy</strong>: 0.5–1.0 (mengurangi noise glossy yang ekstrim).</li>
    <li><strong>Clamp Indirect</strong>: 3–10 (memotong sinar terlalu terang yang menyebabkan noise, hati-hati jangan terlalu rendah karena bisa meredupkan pencahayaan).</li>
</ul>

<h3>4. Hardware dan Tile Size</h3>
<ul>
    <li><strong>GPU Compute</strong>: Pilih CUDA, OptiX, atau HIP untuk akselerasi GPU. Jauh lebih cepat dari CPU.</li>
    <li><strong>Tile Size</strong>: Untuk GPU, ukuran tile 256x256 atau 512x512. Untuk CPU, 32x32 atau 64x64.</li>
    <li>Aktifkan <strong>Persistent Data</strong> jika render beberapa frame (untuk animasi).</li>
</ul>

<h3>5. Denoising Data</h3>
<p>Aktifkan <strong>Denoising Data</strong> di Render Layers > Passes. Data ini membantu denoiser pasca-render tanpa perlu merender ulang.</p>

<p>Dengan optimasi di atas, render produk standar (tanja kaca kompleks) bisa selesai dalam 1-3 menit per frame pada resolusi 1080p dengan GPU mid-range.</p>',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 14,
                'modul_id' => 4,
                'judul' => 'Denoising & Sampling',
                'konten' => '<h2>Menghilangkan Bintik (Noise) pada Hasil Render</h2>
<p>Noise muncul karena jumlah sampel tidak cukup, terutama di area gelap, glossy, atau kaca. Denoising adalah solusi untuk membersihkan noise tanpa perlu merender ulang dengan sampel tinggi.</p>

<h3>Metode Denoising di Blender</h3>

<h4>1. OptiX Denoising (GPU NVIDIA)</h4>
<p>Terbaik dan tercepat. Aktifkan di <strong>Render Properties > Sampling > Denoising</strong>. Pilih <strong>OptiX</strong>. Bekerja real-time di viewport. Untuk render final, hasil sangat bersih bahkan dengan 128 sample.</p>

<h4>2. OpenImageDenoise (CPU)</h4>
<p>Untuk pengguna non-NVIDIA. Kualitas sangat baik, sedikit lebih lambat dari OptiX. Aktifkan di menu yang sama.</p>

<h4>3. Compositor Denoise Node</h4>
<p>Untuk kontrol manual. Di <strong>Compositor</strong>, tambahkan node <strong>Denoise</strong>. Hubungkan output <strong>Noisy Image</strong> dari Render Layers. Tambahkan juga <strong>Denoising Normal</strong> dan <strong>Denoising Albedo</strong> (jika ada di passes) untuk hasil lebih akurat.</p>

<h3>Praktik Sampling + Denoising</h3>
<p>Kombinasi terbaik untuk produktivitas:</p>
<ul>
    <li><strong>Preview cepat</strong>: 64–128 sample + OptiX/OpenImageDenoise (viewport denoising aktif).</li>
    <li><strong>Render final</strong>: 256–512 sample + denoising. Untuk produk kaca, 512–1024 sample + denoising.</li>
    <li>Hindari denoising berlebihan (terlalu sedikit sample) karena bisa menghilangkan detail tekstur halus.</li>
</ul>

<h3>Mengatasi Artifact Denoising</h3>
<p>Kadang denoising menimbulkan artifact seperti area terlalu mulus (plastik) atau "splotchy". Solusi:</p>
<ul>
    <li>Tambah sample (misal dari 128 ke 256).</li>
    <li>Naikkan <strong>Denoising Radius</strong> (di properti denoising) jika tersedia.</li>
    <li>Gunakan <strong>Denoising Passes</strong> di Compositor dengan blending manual (mix denoised dengan noisy image).</li>
</ul>

<p>Dengan denoising yang tepat, render produk bisa bersih seperti render 2000 sample tetapi hanya dengan 256 sample, menghemat waktu hingga 80%.</p>',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 15,
                'modul_id' => 4,
                'judul' => 'Color Management (Kontras & Saturasi)',
                'konten' => '<h2>Mengatur Warna agar Hasil Render Lebih Hidup</h2>
<p>Blender memiliki sistem color management yang mempengaruhi tampilan akhir render. Pengaturan yang tepat membuat warna lebih akurat dan kontras tanpa perlu software eksternal.</p>

<h3>Ruang Warna (Color Space)</h3>
<p>Di <strong>Render Properties > Color Management</strong>, pilih <strong>View Transform</strong>:</p>
<ul>
    <li><strong>Standard</strong>: Tanpa koreksi, cocok untuk workflow linear yang akan dikoreksi di luar.</li>
    <li><strong>Filmic</strong> (default): Memberikan kontras dan saturasi yang natural, mirip film. Paling direkomendasikan untuk product rendering.</li>
    <li><strong>Filmic Log</strong>: Untuk color grading lanjutan.</li>
    <li><strong>AgX</strong> (Blender 4.0+): Lebih modern, warna lebih akurat terutama untuk warna jenuh tinggi.</li>
</ul>

<h3>Look (Kontras Tambahan)</h3>
<p>Di bawah <strong>Look</strong>, pilih preset kontras:</p>
<ul>
    <li><strong>None</strong>: Default.</li>
    <li><strong>Medium High Contrast</strong>: Tambah kontras 0.8.</li>
    <li><strong>High Contrast</strong>: Kontras 1.2 (cocok untuk produk dengan latar putih).</li>
</ul>

<h3>Exposure dan Gamma</h3>
<ul>
    <li><strong>Exposure</strong>: Mencerahkan atau menggelapkan seluruh gambar (nilai -1 sampai 1). Untuk render terlalu gelap, naikkan exposure 0.2–0.5.</li>
    <li><strong>Gamma</strong>: Mengoreksi kecerahan midtone (default 1.0). Jarang diubah.</li>
</ul>

<h3>Sequencer & Compositor Color Tools</h3>
<p>Untuk kontrol lebih presisi, gunakan <strong>Compositor</strong> dengan node:</p>
<ul>
    <li><strong>RGB Curves</strong>: Kontrol kontras dan warna per channel (R,G,B).</li>
    <li><strong>Color Balance</strong>: Atur shadow, midtone, highlight secara terpisah.</li>
    <li><strong>Hue Saturation Value</strong>: Tingkatkan saturasi tanpa mempengaruhi kecerahan.</li>
</ul>

<h3>Tips untuk Product Rendering</h3>
<ul>
    <li>Gunakan <strong>Filmic</strong> dengan Exposure 0.2–0.5 untuk hasil yang cerah namun tidak overexpose.</li>
    <li>Jika produk memiliki warna putih, pastikan tidak kehilangan detail (gunakan <strong>False Color</strong> view di render preview untuk cek overexpose).</li>
    <li>Untuk produk kulit atau tekstil, saturasi sedikit diturunkan (0.9) agar lebih natural.</li>
</ul>

<p>Dengan color management yang tepat, render produk Anda akan terlihat profesional tanpa perlu post-processing di Photoshop.</p>',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 16,
                'modul_id' => 4,
                'judul' => 'Exporting & Format untuk Cetak/Media Sosial',
                'konten' => '<h2>Menyimpan Hasil Render dengan Format yang Tepat</h2>
<p>Setelah render selesai, ekspor gambar dengan format dan resolusi sesuai kebutuhan klien atau platform. Berikut panduan lengkapnya.</p>

<h3>Pengaturan Output di Blender</h3>
<p>Buka <strong>Output Properties</strong> (ikon printer).</p>

<h4>Resolusi (Resolution)</h4>
<ul>
    <li><strong>Media Sosial</strong> (Instagram, Facebook): 1080x1080 (persegi), 1080x1350 (portrait), atau 1920x1080 (landscape).</li>
    <li><strong>Website / E-commerce</strong>: 1920x1920 atau 2048x2048 untuk zoom detail.</li>
    <li><strong>Cetak (Print)</strong>: 300 DPI. Hitung resolusi = lebar (inci) x 300. Contoh A4 (8.3 inci) = 2490px x 3508px.</li>
    <li><strong>Presentasi</strong>: 1920x1080 (Full HD) atau 3840x2160 (4K).</li>
</ul>

<h4>Format File</h4>
<table style="width:100%; border-collapse:collapse; border:1px solid #ddd;">
    <thead style="background:#f0f0f0;"><tr><th>Format</th><th>Kelebihan</th><th>Kekurangan</th><th>Penggunaan</th></tr></thead>
    <tbody>
        <tr><td><strong>PNG</strong></td><td>Lossless, support alpha (transparan)</td><td>Ukuran besar (2-5 MB per gambar)</td><td>E-commerce, logo, produk dengan background transparan</td>
        <tr>
        <tr><td><strong>JPEG (JPG)</strong></td><td>Ukuran kecil (200-500 KB), universal</td>
        <tr><td>Lossy (kualitas turun), tanpa alpha</td><td>Media sosial, email, preview cepat</td>
        </tr>
        <tr><td><strong>TIFF</strong></td>
<td>Lossless, support alpha, 16/32 bit</td><td>Ukuran sangat besar</td><td>Cetak profesional, arsip master</td>
        </tr>
        <tr><td><strong>OpenEXR (EXR)</strong></td>
<td>32 bit float, HDR, data passes</td><td>Tidak bisa langsung dibuka di software biasa</td><td>Post-processing lanjutan (compositing)</td>
        </tr>
    </tbody>
</table>

<h3>Tips Ekspor untuk Berbagai Kebutuhan</h3>

<h4>Untuk Media Sosial</h4>
<ul>
    <li>Gunakan JPEG dengan kualitas 90-95% (tidak perlu PNG karena ukuran besar).</li>
    <li>Resolusi: 1080x1080 (persegi) untuk Instagram feed.</li>
    <li>Aktifkan <strong>Color Management > View Transform = Filmic</strong> agar warna cerah namun natural.</li>
</ul>

<h4>Untuk Cetak (Print)</h4>
<ul>
    <li>Gunakan PNG atau TIFF, 300 DPI, mode warna sRGB atau CMYK (konversi di software lain karena Blender hanya sRGB).</li>
    <li>Render dengan sample tinggi (1024+) dan non-denoising untuk detail maksimal.</li>
    <li>Simpan juga file .blend untuk kemungkinan revisi.</li>
</ul>

<h4>Untuk Klien / Presentasi</h4>
<ul>
    <li>Sediakan multiple angle: depan, samping, close-up, dan 3/4 view.</li>
    <li>Buat turntable video (360°) dengan ekspor ke MP4 (gunakan <strong>Render Animation</strong>).</li>
    <li>Bundel semua file dalam satu folder: gambar final + .blend + tekstur.</li>
</ul>

<h3>Cara Mengekspor dari Blender</h3>
<ol>
    <li>Set resolusi dan format di Output Properties.</li>
    <li>Tentukan folder output (Output Properties > Output).</li>
    <li>Klik <strong>Render > Render Image</strong> (F12).</li>
    <li>Setelah render selesai, klik <strong>Image > Save As</strong> (Alt+S) atau langsung <strong>Render > Save Image</strong>.</li>
    <li>Untuk animasi, gunakan <strong>Render > Render Animation</strong> (Ctrl+F12).</li>
</ol>

<p>Dengan mengikuti panduan ini, hasil render produk Anda siap digunakan untuk berbagai keperluan profesional.</p>',
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
