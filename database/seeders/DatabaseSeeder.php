<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Chapter;
use App\Models\Module;
use App\Models\Diagram;
use App\Models\Hotspot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users (Admin, Instruktur, Peserta)
        $admin = User::create([
            'name' => 'Administrator LMS',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $instruktur = User::create([
            'name' => 'Capt. Hermawan (Instruktur)',
            'email' => 'instruktur@lms.com',
            'password' => Hash::make('password'),
            'role' => 'instruktur',
        ]);

        $peserta = User::create([
            'name' => 'Budi Santoso (Peserta)',
            'email' => 'peserta@lms.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
        ]);

        // 2. Seed Course
        $course = Course::create([
            'title' => 'Pengenalan dan Pengoperasian Garbarata',
            'description' => 'Mata kuliah/training dasar mengenai komponen mekanik, sistem elektrik, keselamatan kerja, dan standar operasional prosedur (SOP) pengoperasian Garbarata (Passenger Boarding Bridge) di bandar udara.',
            'thumbnail' => 'course_garbarata.jpg',
            'is_published' => true,
        ]);

        // 3. Seed Chapters (BAB 1 - BAB 7)
        $chapter1 = Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 1: Deskripsi Garbarata',
            'order' => 1,
        ]);

        $chapter2 = Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 2: Data Teknis',
            'order' => 2,
        ]);

        $chapter3 = Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 3: Instruksi Pengoperasian',
            'order' => 3,
        ]);

        $chapter4 = Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 4: Perawatan, Inspeksi & Penyelesaian Masalah',
            'order' => 4,
        ]);

        $chapter5 = Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 5: Daftar Suku Cadang',
            'order' => 5,
        ]);

        $chapter6 = Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 6: Katalog Bagian Utama',
            'order' => 6,
        ]);

        $chapter7 = Chapter::create([
            'course_id' => $course->id,
            'title' => 'BAB 7: Lampiran - Gambar Elektrik',
            'order' => 7,
        ]);

        // 4. Seed Modules for BAB 1 (Deskripsi Garbarata)
        $module1_1 = Module::create([
            'chapter_id' => $chapter1->id,
            'title' => '1.1 Rotunda (Pangkal Garbarata)',
            'content' => '<p><strong>Rotunda</strong> adalah bagian pangkal atau poros utama Garbarata yang terhubung langsung dengan terminal bandara (departure gate).</p><p>Karakteristik penting Rotunda:</p><ul><li>Memiliki engsel rotasi horizontal yang memungkinkan terowongan Garbarata berputar ke kiri dan kanan hingga sudut tertentu.</li><li>Memiliki sistem penyeimbang beban agar struktur terowongan tetap kokoh ketika memanjang.</li><li>Dilengkapi pintu transisi aman dari gedung terminal menuju area Garbarata.</li></ul>',
            'order' => 1,
        ]);

        $module1_2 = Module::create([
            'chapter_id' => $chapter1->id,
            'title' => '1.2 Telescopic Tunnel (Terowongan)',
            'content' => '<p><strong>Telescopic Tunnel</strong> adalah lorong berjalan berbentuk tabung persegi yang dapat memanjang dan memendek (sistem teleskopik).</p><p>Komponen di dalam Tunnel:</p><ul><li><strong>Inner & Outer Tunnel:</strong> Segmen lorong yang saling berhimpitan dan bergeser maju/mundur.</li><li><strong>Flooring & Lighting:</strong> Karpet anti-slip dan pencahayaan LED darurat untuk kenyamanan penumpang.</li><li><strong>Service Doors:</strong> Pintu darurat/akses tangga luar yang berada di sepanjang lorong.</li></ul>',
            'order' => 2,
        ]);

        $module1_3 = Module::create([
            'chapter_id' => $chapter1->id,
            'title' => '1.3 Cabin & Control Console (Kabin Kemudi)',
            'content' => '<p><strong>Kabin Kontrol</strong> terletak di ujung Garbarata yang langsung menempel ke pintu pesawat (aircraft door).</p><p>Di dalam kabin ini terdapat panel kontrol utama bagi operator:</p><ul><li><strong>Joystick Kontrol:</strong> Mengatur pergerakan maju-mundur terowongan dan menaikkan/menurunkan elevasi kabin.</li><li><strong>Canopy Controller:</strong> Menurunkan penutup karet pelindung cuaca (canopy) ke atas badan pesawat.</li><li><strong>Auto-leveling Arm:</strong> Lengan sensor otomatis yang mendeteksi perubahan tinggi pintu pesawat akibat naik-turunnya beban muatan/penumpang, lalu menyesuaikan tinggi Garbarata secara otomatis.</li></ul>',
            'order' => 3,
        ]);

        $module1_4 = Module::create([
            'chapter_id' => $chapter1->id,
            'title' => '1.4 Drive Column & Wheels (Kolom Penggerak)',
            'content' => '<p><strong>Drive Column (Wheels)</strong> merupakan kaki penopang utama sekaligus sistem penggerak roda mekanis Garbarata.</p><p>Sistem ini meliputi:</p><ul><li><strong>Dua Roda Besar:</strong> Digerakkan oleh motor listrik AC atau sistem hidrolik independen untuk memutar dan menggerakkan maju/mundur.</li><li><strong>Elevating System:</strong> Tiang penyangga vertikal bersumbu ulir (ball screw) atau hidrolik silinder untuk menaikkan/menurunkan seluruh tinggi terowongan.</li><li><strong>Wheel Guard:</strong> Pelindung ban dari benturan objek asing di apron bandara.</li></ul>',
            'order' => 4,
        ]);

        // 5. Seed Diagram for BAB 1 (Deskripsi Garbarata)
        $diagram1 = Diagram::create([
            'chapter_id' => $chapter1->id,
            'title' => 'Diagram Struktur Utama Garbarata (Awal)',
            'image_path' => 'images/garbarata_diagram.png',
        ]);

        // Seed Hotspots for BAB 1
        Hotspot::create([
            'diagram_id' => $diagram1->id,
            'target_module_id' => $module1_1->id,
            'label' => 'Rotunda (Pangkal)',
            'x_percent' => 15.5,
            'y_percent' => 52.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram1->id,
            'target_module_id' => $module1_2->id,
            'label' => 'Telescopic Tunnel',
            'x_percent' => 45.0,
            'y_percent' => 48.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram1->id,
            'target_module_id' => $module1_3->id,
            'label' => 'Cabin & Control Console',
            'x_percent' => 82.0,
            'y_percent' => 38.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram1->id,
            'target_module_id' => $module1_4->id,
            'label' => 'Drive Column & Wheels',
            'x_percent' => 65.0,
            'y_percent' => 76.0,
        ]);

        // 6. Seed Modules for BAB 2 (Data Teknis)
        Module::create([
            'chapter_id' => $chapter2->id,
            'title' => '2.1 Spesifikasi Dimensi Fisik',
            'content' => '<p>Data Teknis dimensi fisik jembatan penyeberangan Garbarata:</p><table class="min-w-full divide-y divide-gray-200 mt-4 text-xs"><thead><tr class="bg-gray-100"><th>Parameter</th><th>Nilai Minimal</th><th>Nilai Maksimal</th></tr></thead><tbody><tr><td>Panjang Terowongan</td><td>18.5 Meter</td><td>39.0 Meter</td></tr><tr><td>Tinggi Kabin (Elevasi)</td><td>2.1 Meter</td><td>5.4 Meter</td></tr><tr><td>Kecepatan Rotasi Roda</td><td>0 deg/sec</td><td>4.2 deg/sec</td></tr></tbody></table>',
            'order' => 1,
        ]);

        Module::create([
            'chapter_id' => $chapter2->id,
            'title' => '2.2 Batas Toleransi Beban',
            'content' => '<p>Beban struktural maksimum Garbarata mencakup berat terowongan, hembusan angin, dan berat penumpang berjalan:</p><ul><li><strong>Beban Hidup Terdistribusi:</strong> Maksimum 300 kg/m² pada terowongan.</li><li><strong>Kecepatan Angin Operasional:</strong> Maksimum 60 knot (111 km/jam). Di atas itu, jembatan harus ditarik ke posisi parkir jangkar.</li></ul>',
            'order' => 2,
        ]);

        // 7. Seed Modules for BAB 3 (Instruksi Pengoperasian)
        Module::create([
            'chapter_id' => $chapter3->id,
            'title' => '3.1 Prosedur Pre-docking (Sebelum Pesawat Masuk)',
            'content' => '<p>Operator wajib memastikan kondisi lingkungan apron aman sebelum pesawat tiba di garis henti:</p><ol><li>Periksa tidak ada benda asing (FOD) di area sapuan roda Garbarata.</li><li>Pastikan canopy karet dalam posisi terlipat penuh ke atas.</li><li>Posisikan Garbarata pada markah parkir aman (Home Position).</li></ol>',
            'order' => 1,
        ]);

        Module::create([
            'chapter_id' => $chapter3->id,
            'title' => '3.2 Prosedur Docking (Merapat ke Pintu Pesawat)',
            'content' => '<p>Langkah-langkah merapatkan jembatan setelah lampu tanda henti menyala dan mesin pesawat dimatikan:</p><ol><li>Gerakkan roda maju secara perlahan menggunakan joystick kontrol kabin.</li><li>Arahkan bumper kabin lurus menghadap pintu utama pesawat.</li><li>Turunkan canopy penutup cuaca secara perlahan hingga menutup celah badan pesawat secara rapat namun tanpa tekanan berlebih.</li><li>Aktifkan sistem sensor auto-leveling.</li></ol>',
            'order' => 2,
        ]);

        // 8. Seed Modules for BAB 7 (Gambar Elektrik)
        $module7_1 = Module::create([
            'chapter_id' => $chapter7->id,
            'title' => '7.1 Sirkuit Tenaga (Power Circuit)',
            'content' => '<p>Sistem suplai daya utama Garbarata menggunakan tegangan AC 3-Phase 380V/50Hz dari generator gedung terminal.</p><p>Komponen kelistrikan utama:</p><ul><li><strong>Main Breaker (MCCB):</strong> Pemutus sirkuit utama di panel panel distribusi.</li><li><strong>Inverter Motor Roda:</strong> Mengatur frekuensi motor listrik penggerak roda agar pergerakan halus.</li><li><strong>Inverter Elevasi:</strong> Mengontrol motor pengangkat terowongan.</li></ul>',
            'order' => 1,
        ]);

        // Seed Diagram for BAB 7
        $diagram7 = Diagram::create([
            'chapter_id' => $chapter7->id,
            'title' => 'Diagram Sirkuit Kelistrikan Utama',
            'image_path' => 'images/electrical_diagram.png',
        ]);

        // Hotspots for BAB 7 (pointing to kelistrikan)
        Hotspot::create([
            'diagram_id' => $diagram7->id,
            'target_module_id' => $module7_1->id,
            'label' => 'Main Panel Breaker',
            'x_percent' => 50.0,
            'y_percent' => 50.0,
        ]);
    }
}
