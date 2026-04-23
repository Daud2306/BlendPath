<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmodulModul1Seeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('submoduls')->delete();

        DB::table('submoduls')->insert(array(
            0 =>
            array(
                'id' => 1,
                'modul_id' => 1,
                'judul' => 'Pengenalan UI Blender Khusus Produk',
                'konten' => '<h2>Mengenal UI Blender untuk Product Modeling</h2>
<p>Blender memiliki antarmuka yang padat, namun Anda tidak perlu mempelajari semuanya. Untuk product rendering, kita hanya fokus pada area dan tools tertentu.</p>

<h3>Workspace yang Direkomendasikan</h3>
<p>Gunakan workspace <strong>Modeling</strong> (bisa dipilih dari dropdown di header). Area utama:</p>
<ul>
    <li><strong>3D Viewport</strong>: Tempat melihat dan memanipulasi objek.</li>
    <li><strong>Outliner</strong>: Daftar semua objek dalam scene.</li>
    <li><strong>Properties</strong>: Panel pengaturan objek, material, modifier, dll.</li>
</ul>

<h3>Tools Wajib untuk Modeling Produk</h3>
<table style="width:100%; border-collapse:collapse;">
    <thead style="background:#f0f0f0;"><tr><th>Tool</th><th>Shortcut</th><th>Fungsi</th></tr></thead>
    <tbody>
        <tr><td><strong>Move</strong></td><td>G</td><td>Memindahkan objek/vertex/edge/face</td></tr>
        <tr><td><strong>Rotate</strong></td><td>R</td><td>Memutar</td></tr>
        <tr><td><strong>Scale</strong></td><td>S</td><td>Mengubah ukuran</td></tr>
        <tr><td><strong>Extrude</strong></td><td>E</td><td>Menarik bidang baru</td></tr>
        <tr><td><strong>Loop Cut</strong></td><td>Ctrl + R</td><td>Memotong edge loop</td></tr>
        <tr><td><strong>Bevel</strong></td><td>Ctrl + B</td><td>Menghaluskan pinggiran</td></tr>
    </tbody>
</table>

<h3>Pengaturan Transform Orientations</h3>
<p>Untuk presisi, atur orientasi ke <strong>Local</strong> atau <strong>Normal</strong> saat memodel. Gunakan <strong>Snapping</strong> (ikon magnet) untuk memastikan vertex menempel dengan tepat. Aktifkan <strong>Absolute Grid Snap</strong> untuk modeling berdasarkan ukuran nyata.</p>

<p><strong>Tips:</strong> Matikan <strong>Orbit Around Selection</strong> di Preferences > Navigation jika Anda lebih suka kamera berputar dari pusat scene. Simpan layout kustom dengan <strong>File > Defaults > Save Startup File</strong> setelah nyaman.</p>',
                'sort_order' => 1,
                'created_at' => '2026-04-22 13:00:00',
                'updated_at' => '2026-04-22 13:00:00',
            ),
            1 =>
            array(
                'id' => 2,
                'modul_id' => 1,
                'judul' => 'Teknik Sub-D Modeling',
                'konten' => '<h2>Menciptakan Permukaan Melengkung Mulus dengan Subdivision Surface</h2>
<p>Sub-D (Subdivision Surface) adalah teknik membuat model 3D dengan mesh low-poly yang kemudian dihaluskan secara otomatis. Sangat penting untuk produk seperti botol, gadget, atau furnitur dengan bentuk organik.</p>

<h3>Cara Kerja Subdivision Surface Modifier</h3>
<p>Tambahkan modifier <strong>Subdivision Surface</strong> ke objek Anda. Parameter utama:</p>
<ul>
    <li><strong>Levels Viewport</strong>: Tingkat pembagian yang terlihat di viewport (1-2 cukup untuk bekerja).</li>
    <li><strong>Render Levels</strong>: Tingkat untuk render akhir (biasanya 2-3).</li>
    <li><strong>Subdivision Type</strong>: Pilih <strong>Catmull-Clark</strong> untuk permukaan halus.</li>
</ul>

<h3>Mengontrol Bentuk dengan Edge Loops</h3>
<p>Subdivision akan melengkungkan semua edge. Untuk mempertahankan ketajaman pada area tertentu (misalnya pinggiran tutup botol), tambahkan <strong>edge loops</strong> berdekatan. Dua loop yang berdekatan akan membuat edge tetap tajam meskipun disubdiv.</p>

<h3>Crease vs Support Loops</h3>
<p>Anda juga bisa menggunakan <strong>Edge Crease</strong> (Shift + E) untuk menajamkan tanpa menambah loop. Namun support loops lebih direkomendasikan untuk hasil akhir yang bersih karena tidak mengganggu topologi.</p>

<p>Sebagai ilustrasi, pada kubus yang diberi Subdivision Surface, sudut-sudutnya akan menjadi bulat. Dengan menambahkan edge loop di dekat salah satu sisi, ketajaman pada sisi tersebut dapat dipertahankan. Prinsip yang sama berlaku pada silinder untuk membentuk botol.</p>',
                'sort_order' => 2,
                'created_at' => '2026-04-22 13:00:00',
                'updated_at' => '2026-04-22 13:00:00',
            ),
            2 =>
            array(
                'id' => 3,
                'modul_id' => 1,
                'judul' => 'Modifikasi Objek (Modifiers) - Bevel & Subdivision Surface',
                'konten' => '<h2>Membuat Pinggiran Objek Realistis dengan Bevel</h2>
<p>Produk di dunia nyata tidak memiliki sudut yang sempurna tajam. Sedikit pembulatan (bevel) pada pinggiran membuat objek terlihat lebih realistis karena menangkap pantulan cahaya.</p>

<h3>Bevel Modifier</h3>
<p>Bevel modifier lebih fleksibel daripada Bevel tool (Ctrl+B) karena non-destruktif. Anda bisa mengubahnya kapan saja. Pengaturan penting:</p>
<ul>
    <li><strong>Width</strong>: Ketebalan bevel (nilai kecil seperti 0.001 - 0.005 untuk skala meter).</li>
    <li><strong>Segments</strong>: Jumlah pembulatan (2-3 cukup untuk sebagian besar produk).</li>
    <li><strong>Profile</strong>: Bentuk bevel (0.5 = melengkung simetris, 1 = cenderung runcing).</li>
    <li><strong>Limit Method</strong>: Pilih <strong>Angle</strong> untuk membatasi bevel hanya pada sudut tajam (di atas 30°).</li>
</ul>

<h3>Kombinasi Bevel + Subdivision Surface</h3>
<p>Urutan modifier sangat penting. Tempatkan <strong>Bevel di atas Subdivision Surface</strong> jika Anda ingin bevel ikut dihaluskan. Sebaliknya, jika bevel di bawah, bevel akan diterapkan sebelum subdivision, menghasilkan bentuk yang lebih presisi untuk produk hard-surface.</p>

<h3>Contoh Penerapan pada Objek Sederhana</h3>
<p>Pada sebuah kubus yang diskala menjadi pipih, penambahan Bevel modifier (Width 0.02, Segments 2) dan Subdivision Surface (Levels 1) akan menghasilkan bentuk seperti meja dengan pinggiran sedikit bulat dan permukaan halus. Dengan mengubah profil bevel, kesan mebel modern atau klasik dapat dicapai.</p>

<p><strong>Catatan:</strong> Untuk produk dengan detail tajam (seperti sambungan plastik), gunakan Bevel dengan Limit Method = Weight, lalu atur bevel weight di edit mode (Ctrl+E > Edge Bevel Weight).</p>',
                'sort_order' => 3,
                'created_at' => '2026-04-22 13:00:00',
                'updated_at' => '2026-04-22 13:00:00',
            ),
            3 =>
            array(
                'id' => 4,
                'modul_id' => 1,
                'judul' => 'Modeling dari Referensi (Blueprint)',
                'konten' => '<h2>Mengimpor Foto Produk sebagai Panduan Modeling</h2>
<p>Modeling produk yang akurat membutuhkan referensi visual. Anda bisa memasukkan foto produk asli (tampak depan, samping, atas) ke Blender sebagai panduan.</p>

<h3>Cara Menyiapkan Referensi</h3>
<ol>
    <li>Kumpulkan minimal 3 gambar: tampak depan, samping, dan atas (bisa dari foto produk atau blueprint).</li>
    <li>Di Blender, gunakan <strong>Add > Image > Reference</strong> untuk masing-masing gambar.</li>
    <li>Atur posisi setiap gambar: depan di sumbu Y negatif, samping di X negatif, atas di Z positif (atau sesuai kebutuhan).</li>
    <li>Skala gambar agar sesuai dengan ukuran nyata produk. Gunakan alat ukur di Blender (Ruler/Protractor addon) atau bandingkan dengan objek referensi.</li>
</ol>

<h3>Mengatur Ukuran Nyata (Real-world Scale)</h3>
<p>Blender menggunakan unit meter secara default. Untuk produk kecil seperti ponsel (panjang 15 cm), ubah unit ke milimeter di <strong>Scene Properties > Units</strong>. Set <strong>Unit System</strong> ke Metric, <strong>Length</strong> ke Millimeters. Kemudian skala referensi hingga sesuai.</p>

<h3>Tips Modeling dengan Referensi</h3>
<ul>
    <li>Gunakan <strong>Background Image</strong> di viewport (N panel > Background Images) jika Anda tidak ingin objek referensi mengganggu seleksi.</li>
    <li>Aktifkan <strong>X-Ray</strong> (Alt+Z) agar referensi terlihat menembus mesh.</li>
    <li>Mulai modeling dari bentuk dasar (cube atau cylinder) lalu extruding sesuai kontur referensi.</li>
</ul>

<p>Sebagai contoh, pada pembuatan model botol, silinder dasar dapat diskala dan dibentuk mengikuti kontur referensi menggunakan loop cuts dan scaling hingga menghasilkan bentuk botol yang diinginkan.</p>',
                'sort_order' => 4,
                'created_at' => '2026-04-22 13:00:00',
                'updated_at' => '2026-04-22 13:00:00',
            ),
        ));
    }
}
