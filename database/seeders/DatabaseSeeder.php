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

        // ==========================================
        // 4. SEED MODULES FOR BAB 1: Deskripsi Garbarata
        // ==========================================
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

        // Seed Diagram for BAB 1
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


        // ==========================================
        // 5. SEED MODULES FOR BAB 2: Data Teknis
        // ==========================================
        Module::create([
            'chapter_id' => $chapter2->id,
            'title' => '2.1 Spesifikasi Dimensi Fisik',
            'content' => '<p>Data Teknis dimensi fisik jembatan penyeberangan Garbarata:</p><div class="overflow-x-auto my-4"><table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs"><thead><tr class="bg-gray-50 text-slate-600 font-bold"><th>Parameter</th><th class="p-2">Nilai Minimal</th><th class="p-2">Nilai Maksimal</th></tr></thead><tbody class="divide-y divide-gray-100 text-slate-600"><tr><td class="p-2">Panjang Terowongan (Retracted/Extended)</td><td class="p-2">18.5 Meter</td><td class="p-2">39.0 Meter</td></tr><tr class="bg-slate-50/50"><td class="p-2">Tinggi Kabin (Elevasi/Vertikal)</td><td class="p-2">2.1 Meter</td><td class="p-2">5.4 Meter</td></tr><tr><td class="p-2">Kecepatan Rotasi Roda</td><td class="p-2">0 deg/sec</td><td class="p-2">4.2 deg/sec</td></tr></tbody></table></div>',
            'order' => 1,
        ]);

        Module::create([
            'chapter_id' => $chapter2->id,
            'title' => '2.2 Batas Toleransi Beban',
            'content' => '<p>Beban struktural maksimum Garbarata mencakup berat terowongan, hembusan angin, dan berat penumpang berjalan:</p><ul><li><strong>Beban Hidup Terdistribusi:</strong> Maksimum 300 kg/m² pada terowongan.</li><li><strong>Kecepatan Angin Operasional:</strong> Maksimum 60 knot (111 km/jam). Di atas itu, jembatan harus ditarik ke posisi parkir jangkar.</li></ul>',
            'order' => 2,
        ]);


        // ==========================================
        // 6. SEED MODULES FOR BAB 3: Instruksi Pengoperasian
        // ==========================================
        Module::create([
            'chapter_id' => $chapter3->id,
            'title' => '3.1 Prosedur Pre-docking',
            'content' => '<p>Operator wajib memastikan kondisi lingkungan apron aman sebelum pesawat tiba di garis henti:</p><ol><li>Periksa tidak ada benda asing (FOD) di area sapuan roda Garbarata.</li><li>Pastikan canopy karet dalam posisi terlipat penuh ke atas.</li><li>Posisikan Garbarata pada markah parkir aman (Home Position).</li></ol>',
            'order' => 1,
        ]);

        Module::create([
            'chapter_id' => $chapter3->id,
            'title' => '3.2 Prosedur Docking & Undocking',
            'content' => '<p>Langkah-langkah merapatkan jembatan setelah lampu tanda henti menyala dan mesin pesawat dimatikan:</p><ol><li>Gerakkan roda maju secara perlahan menggunakan joystick kontrol kabin.</li><li>Arahkan bumper kabin lurus menghadap pintu utama pesawat.</li><li>Turunkan canopy penutup cuaca secara perlahan hingga menutup celah badan pesawat secara rapat namun tanpa tekanan berlebih.</li><li>Aktifkan sistem sensor auto-leveling.</li></ol>',
            'order' => 2,
        ]);


        // ==========================================
        // 7. SEED MODULES FOR BAB 4: Perawatan, Inspeksi & Penyelesaian Masalah
        // ==========================================
        Module::create([
            'chapter_id' => $chapter4->id,
            'title' => '4.1 Perawatan Garbarata',
            'content' => '<p>Perawatan rutin Garbarata akan mencegah kerusakan dan memperpanjang umur Garbarata. Perawatan tersebut meliputi prosedur-prosedur inspeksi, pembersihan, pengecatan, penataan serta salah satu prosedur yang sangat penting yaitu prosedur pelumasan. Prosedur pelumasan merupakan hal yang sangat penting. Prosedur-prosedur yang disampaikan pada bab ini sangat dianjurkan.</p>' .
                '<p class="mt-3">Perawatan secara keseluruhan harus dilakukan secara rutin untuk memastikan semua bagian Garbarata berfungsi dengan baik. Perawatan rutin juga dapat memprediksi durasi operasi bagian-bagian Garbarata dan juga dapat menentukan perbaikan seperti apa yang dibutuhkan untuk berbagai macam kerusakan.</p>' .
                '<p class="mt-3">Gunakan alat-alat yang sesuai dalam melakukan perbaikan, pengaturan dan service untuk mencegah kerusakan dan lain-lain. Gunakan tempat penampung air yang bersih ketika membersihkan, membilas dan mengisi ulang pelumas untuk gear box. Ikuti instruksi perawatan dari pabrik yang terdapat pada buku manual yang terlampir pada komponen yang dijual oleh Bukaka. Bersihkan tumpahan, kotoran, atau kumpulan kotoran dari aktivitas maintenance. Perawatan harus dilakukan secara rutin tiga bulan sekali (triwulan).</p>' .
                '<div class="my-4 p-3 bg-amber-50 rounded-lg border border-amber-100 text-amber-800"><strong>Pertimbangan Umum:</strong><ul class="list-disc list-inside mt-1"><li>(a) Hanya personel yang terlatih yang mengerjakan/mengoperasikan Garbarata</li><li>(b) Jangan terburu-buru dan sembarangan dalam perawatan Garbarata</li></ul></div>' .
                '<h4 class="font-bold text-slate-800 text-xs mt-4 mb-2">4.1.1 Karpet</h4>' .
                '<p>Untuk menjaga kondisi karpet tetap bersih, jadwal pembersihan harus dilaksanakan seperti berikut:</p>' .
                '<ul class="list-disc list-inside"><li>(a) Bersihkan karpet setiap hari</li><li>(b) Cuci karpet sesering mungkin dengan shampoo yang bebas detergen</li></ul>' .
                '<h4 class="font-bold text-slate-800 text-xs mt-4 mb-2">4.1.2 Jendela</h4>' .
                '<p>Karena Garbarata selalu terpapar jet exhaust, maka akan terjadi pembentukan lapisan kotoran dari jet exhaust pada jendela-jendela Garbarata, oleh karena itu jendela harus dibersihkan setiap hari. Gunakan shampoo bebas detergen yang berkualitas tinggi untuk membersihkan permukaan tersebut.</p>' .
                '<h4 class="font-bold text-slate-800 text-xs mt-4 mb-2">4.1.3 Dinding dan Ceiling Panel</h4>' .
                '<p>Dinding dan langit-langit butuh pembersihan rutin. Gunakan shampoo yang bebas detergen untuk membersihkan kotoran.</p>' .
                '<h4 class="font-bold text-slate-800 text-xs mt-4 mb-2">4.1.4 Panel Dinding Kaca</h4>' .
                '<p>Dinding kaca harus dibersihkan dengan hati-hati. Gunakan shampoo bebas detergen yang ringan untuk menghilangkan kotoran. Saat dibersihkan, kaca bisa bergoncang.</p>' .
                '<h4 class="font-bold text-slate-800 text-xs mt-4 mb-2">4.1.5 Peralatan Penerangan</h4>' .
                '<p>Lensa-lensa dari peralatan penerangan seperti lampu harus dibersihkan sesering mungkin dengan shampoo bebas detergen. Keringkan seluruh perlengkapan dengan hati-hati sebelum dipasang kembali.</p>' .
                '<h4 class="font-bold text-slate-800 text-xs mt-4 mb-2">4.1.6 Inspeksi Permukaan Luar</h4>' .
                '<p>Dianjurkan untuk memeriksa permukaan bagian luar yang bercat sebelum kotoran dan sisa pelumas bereaksi. Pencucian periodik dengan detergen ringan akan membuat awet alat-alat yang bercat dan peralatan lainnya. Bersihkan puing dan korosi material dari atap secara periodik. Beri perhatian lebih pada lubang-lubang saluran pinggiran atap. Setengah tahun sekali gunakan air bersih bebas garam dan deterjen ringan untuk membersihkan endapan minyak hidrokarbon dari Garbarata. Pembersihan ini adalah bagian dari program preventive maintenance yang termasuk juga pengecekan terhadap permukaan yang bercat. Jika cat menunjukkan tanda-tanda pengelupasan atau jika terlihat karat, maka permukaan harus dicat ulang seperti berikut:</p>' .
                '<ul class="list-disc list-inside mt-2"><li>(a) Gunakan pelarut untuk melakukan pembersihan pada daerah yang kotor atau berminyak</li><li>(b) Dengan amplas yang bagus, bersihkan area yang akan dicat ulang dari karat, korosi, dan cat yang mengelupas</li><li>(c) Lapisan pertama harus merupakan cat dasar yang berkualitas tinggi untuk logam</li><li>(d) Akhiri dengan dua lapis polyurethane enamel untuk menyesuaikan warna Garbarata</li></ul>' .
                '<div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold">PERHATIAN: JANGAN CAT BAGIAN-BAGIAN BERGERAK SEPERTI RANTAI, SPROCKET, SHAFT, BEARING, ROLLER ATAU REL/RAIL.</div>',
            'order' => 1,
        ]);

        Module::create([
            'chapter_id' => $chapter4->id,
            'title' => '4.2 Rotunda dan Tekanan Cabin Curtain',
            'content' => '<p>Curtain dapat diperiksa dengan menekan Curtain dari dalam. Ketegangannya harus cukup untuk menahan berat penumpang yang mungkin secara mendadak terperosok atau tersandung pada Curtain dan untuk mengencangkan curtain bersamaan saat cabin/rotunda berotasi. Curtain yang terlalu tegang/kencang akan cekung ke arah luar.</p>' .
                '<p class="mt-3">Jika tegangan tidak sesuai berada pada Curtain dari lilitan pada panel Curtain barrel, lakukan hal berikut ini:</p>' .
                '<ul class="list-decimal list-inside space-y-2 mt-2">' .
                '<li><strong>(a)</strong> Lepaskan tutup/cover curtain barrel rotunda dari atas rotunda yang menuju ke kumparan curtain. Untuk cabin buka tutup/cover curtain barrel yang berengsel agar kumparan dapat terlihat.</li>' .
                '<li><strong>(b)</strong> Posisikan garbarata atau kabin agar Curtain yang akan disesuaikan dapat terbuka penuh.</li>' .
                '<li><strong>(c)</strong> Putar garbarata atau kabin perlahan agar Curtain yang terbuka mulai menggulung. Putar garbarata ke arah yang Curtain akan gagal menggulung tanpa bantuan manual (manual assistance).</li>' .
                '<li><strong>(d)</strong> Tanpa memegang atau menekan Curtain, putar worm gear dengan arah berlawanan jarum jam untuk Curtain sebelah kiri dan searah jarum jam untuk Curtain sebelah kanan, hingga Curtain tertarik kencang pada kumparannya.</li>' .
                '<li><strong>(e)</strong> Lanjutkan prosedur ini hingga Curtain berputar dari posisi terbukanya ke posisi tergulung tanpa masalah apapun.</li>' .
                '<li><strong>(f)</strong> Putar garbarata pada kedua arah untuk memastikan apakah Curtain memiliki tegangan yang cocok.</li>' .
                '</ul>' .
                '<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs"><strong>CATATAN:</strong> Enam belas putaran dari kumparan di-setting di pabrik. Meskipun demikian, pengaturan dilakukan selama instalasi dan jumlah ini mungkin berubah.</div>' .
                '<div class="p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase">PERHATIAN: HATI-HATI TERLUKA BERTEKANAN TINGGI. KARENA KUMPARAN YANG BERTEKANAN TINGGI.</div>',
            'order' => 2,
        ]);

        Module::create([
            'chapter_id' => $chapter4->id,
            'title' => '4.3 Jadwal Checklist Inspeksi Berkala',
            'content' => '<p>Checklist inspeksi teknis rutin jembatan Garbarata:</p>' .
                '<div class="space-y-4 text-xs mt-3">' .
                '<div class="p-3 bg-blue-50/50 rounded-lg border border-blue-100"><strong>Pemeriksaan Harian:</strong><ul><li>Pengecekan kondisi fisik luar unit (visual check)</li><li>Pengecekan lampu indikator keselamatan dan panel kontrol</li><li>Pengecekan sensor auto-leveling arm</li><li>Pengecekan kebisingan tidak normal pada roda penggerak</li></ul></div>' .
                '<div class="p-3 bg-amber-50/50 rounded-lg border border-amber-100"><strong>Pemeriksaan Mingguan:</strong><ul><li>Pelumasan pada rantai penggerak (drive chain) dan bearing</li><li>Pengecekan level oli hidrolik HPU</li><li>Pengujian fungsi tombol emergency stop</li><li>Pembersihan jalur apron dari FOD</li></ul></div>' .
                '<div class="p-3 bg-emerald-50/50 rounded-lg border border-emerald-100"><strong>Pemeriksaan Bulanan & Tahunan:</strong><ul><li>Pengecekan keausan ban roda penggerak</li><li>Kalibrasi sensor auto-leveling dan pengukur beban</li><li>Uji beban (load test) struktural tahunan</li><li>Penggantian oli hidrolik secara menyeluruh (tiap 1 tahun)</li></ul></div>' .
                '</div>',
            'order' => 3,
        ]);

        Module::create([
            'chapter_id' => $chapter4->id,
            'title' => '4.4 Pemeliharaan Hidrolik & Drive Column',
            'content' => '<p><strong>Pemeliharaan Sistem Hidrolik (HPU):</strong></p><ul><li><strong>Pengecekan Oli:</strong> Gunakan oli hidrolik tipe ISO VG 46. Pastikan level oli tidak berada di bawah garis indikator minimal pada tangki.</li><li><strong>Tekanan Kerja Hidrolik:</strong> Tekanan standar operasional adalah 140 bar (2000 psi). Periksa kebocoran di sambungan pipa/fitting jika tekanan menurun.</li></ul>' .
                '<p class="mt-4"><strong>Pemeliharaan Drive Column & Mekanikal:</strong></p><ul><li><strong>Pelumasan Ball Screw:</strong> Ulir elevating system harus dilumasi secara merata dengan grease lithium berkualitas tinggi setiap bulan.</li><li><strong>Penyelarasan Roda:</strong> Periksa alignment roda penggerak untuk mencegah keausan ban sepihak.</li></ul>',
            'order' => 4,
        ]);

        $module4_5 = Module::create([
            'chapter_id' => $chapter4->id,
            'title' => '4.5 Tabel Panduan Troubleshooting',
            'content' => '<p>Panduan cepat untuk mengidentifikasi penyebab gangguan operasional dan tindakan perbaikannya:</p>' .
                '<div class="overflow-x-auto my-4"><table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-100 text-slate-700 font-bold"><th class="p-2">Gejala Gangguan</th><th class="p-2">Kemungkinan Penyebab</th><th class="p-2">Tindakan Perbaikan</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 font-semibold">Unit Garbarata tidak menyala (No Power)</td><td class="p-2">1. Main MCCB di panel terminal OFF.<br>2. Emergency stop di kabin tertekan.<br>3. Koneksi kabel utama longgar.</td><td class="p-2">1. Posisikan main breaker ke ON.<br>2. Putar emergency stop searah jarum jam untuk mereset.<br>3. Kencangkan terminal kabel utama.</td></tr>' .
                '<tr><td class="p-2 font-semibold">Terowongan tidak mau maju/mundur</td><td class="p-2">1. Limit switch ujung depan/belakang aktif.<br>2. Thermal overload relay motor roda trip.<br>3. Joystick kontrol rusak.</td><td class="p-2">1. Periksa dan bersihkan limit switch.<br>2. Tunggu motor dingin, lalu reset thermal relay.<br>3. Ganti joystick kontrol.</td></tr>' .
                '<tr><td class="p-2 font-semibold">Elevasi vertikal tidak bergerak naik/turun</td><td class="p-2">1. Oli hidrolik kurang.<br>2. Katup solenoid (directional valve) macet.<br>3. Pompa hidrolik rusak.</td><td class="p-2">1. Tambah oli hidrolik ISO VG 46.<br>2. Bersihkan/ganti katup solenoid.<br>3. Periksa/ganti motor pompa hidrolik.</td></tr>' .
                '<tr><td class="p-2 font-semibold">Auto-leveling tidak aktif otomatis</td><td class="p-2">1. Selector switch tidak di posisi AUTO.<br>2. Sensor auto-leveling kotor/terhalang.<br>3. Gangguan modul PLC.</td><td class="p-2">1. Putar selector ke AUTO.<br>2. Bersihkan sensor dari objek penghalang.<br>3. Reset PLC dengan mematikan daya 10 detik.</td></tr>' .
                '</tbody></table></div>',
            'order' => 5,
        ]);




        // ==========================================
        // 8. SEED MODULES FOR BAB 5: Daftar Suku Cadang
        // ==========================================
        Module::create([
            'chapter_id' => $chapter5->id,
            'title' => '5.1 Suku Cadang Sistem Elektrik & Sensor',
            'content' => '<p>Daftar suku cadang kelistrikan utama yang direkomendasikan pabrik (PT. BUKAKA TEKNIK UTAMA):</p>' .
                '<div class="overflow-x-auto my-4"><table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2">No</th><th class="p-2">Nama Komponen</th><th class="p-2">Part Number</th><th class="p-2">Produsen</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2">1</td><td class="p-2 font-semibold">Limit Switch Rotasi</td><td class="p-2">WLCA12-2-N</td><td class="p-2">OMRON</td></tr>' .
                '<tr><td class="p-2">2</td><td class="p-2 font-semibold">Sensor Auto-leveling Arm</td><td class="p-2">ALS-24V-03-BK</td><td class="p-2">BUKAKA</td></tr>' .
                '<tr><td class="p-2">3</td><td class="p-2 font-semibold">Relay Kontrol (Auxiliary)</td><td class="p-2">55.34.8.230.0040</td><td class="p-2">FINDER</td></tr>' .
                '<tr><td class="p-2">4</td><td class="p-2 font-semibold">Joystick Pengendali Utama</td><td class="p-2">JS-BUKAKA-V2</td><td class="p-2">BUKAKA</td></tr>' .
                '<tr><td class="p-2">5</td><td class="p-2 font-semibold">Magnetic Contactor 3-Phase</td><td class="p-2">LC1D18M7</td><td class="p-2">SCHNEIDER</td></tr>' .
                '</tbody></table></div>',
            'order' => 1,
        ]);

        Module::create([
            'chapter_id' => $chapter5->id,
            'title' => '5.2 Suku Cadang Mekanikal & Hidrolik',
            'content' => '<p>Daftar suku cadang mekanikal dan hidrolik Garbarata:</p>' .
                '<div class="overflow-x-auto my-4"><table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2">No</th><th class="p-2">Nama Komponen</th><th class="p-2">Part Number</th><th class="p-2">Spesifikasi</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2">1</td><td class="p-2 font-semibold">Motor AC Roda Penggerak</td><td class="p-2">MOT-AC3-01-BK</td><td class="p-2">3-Phase 380V, 3.7 kW (5 HP)</td></tr>' .
                '<tr><td class="p-2">2</td><td class="p-2 font-semibold">Solenoid Directional Valve</td><td class="p-2">4WE6D-6X/EG24N9K4</td><td class="p-2">REXROTH (24V DC)</td></tr>' .
                '<tr><td class="p-2">3</td><td class="p-2 font-semibold">Seal Kit Cylinder Hydraulic</td><td class="p-2">SK-HC-80/45-REX</td><td class="p-2">Bore 80mm, Rod 45mm</td></tr>' .
                '<tr><td class="p-2">4</td><td class="p-2 font-semibold">Ban Karet Padat (Solid Tire)</td><td class="p-2">TIRE-SOL-40-14</td><td class="p-2">40 x 14 Inch (Heavy Duty)</td></tr>' .
                '</tbody></table></div>',
            'order' => 2,
        ]);


        // ==========================================
        // 9. SEED MODULES FOR BAB 6: Katalog Bagian Utama
        // ==========================================
        $module6_1 = Module::create([
            'chapter_id' => $chapter6->id,
            'title' => '6.1 Katalog Drive Column (Kaki Penopang)',
            'content' => '<p>Drive column terdiri dari susunan penggerak roda, motor hidrolik/elektrik, dan sensor limit penyeimbang vertikal.</p>' .
                '<p class="mt-3"><strong>Detail Suku Cadang Terkait:</strong></p><ul>' .
                '<li><strong>(1) Tiang Jack Vertikal (Ball Screw Jack):</strong> Bagian mekanik ulir pengangkat elevasi jembatan.</li>' .
                '<li><strong>(2) Solid Tire (Ban Karet):</strong> Roda ban padat berukuran 40x14 Inch.</li>' .
                '<li><strong>(3) Motor Roda Penggerak:</strong> Motor listrik AC 3.7kW terhubung langsung ke gearbox reduktor roda.</li>' .
                '</ul>',
            'order' => 1,
        ]);

        // Seed Diagram for BAB 6
        $diagram6 = Diagram::create([
            'chapter_id' => $chapter6->id,
            'title' => 'Katalog Komponen Drive Column',
            'image_path' => 'images/exploded_drive_column.png',
        ]);

        // Hotspot for Column
        Hotspot::create([
            'diagram_id' => $diagram6->id,
            'target_module_id' => $module6_1->id,
            'label' => 'Lihat Suku Cadang Drive Column',
            'x_percent' => 50.0,
            'y_percent' => 50.0,
        ]);


        // ==========================================
        // 10. SEED MODULES FOR BAB 7: Lampiran - Gambar Elektrik
        // ==========================================
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

        // Hotspots for BAB 7
        Hotspot::create([
            'diagram_id' => $diagram7->id,
            'target_module_id' => $module7_1->id,
            'label' => 'Main Panel Breaker',
            'x_percent' => 50.0,
            'y_percent' => 50.0,
        ]);
    }
}
