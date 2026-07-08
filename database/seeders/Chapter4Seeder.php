<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Module;
use Illuminate\Database\Seeder;

class Chapter4Seeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 4)->first();

        if (!$chapter) {
            return;
        }

        Module::create([
            'chapter_id' => $chapter->id,
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
            'chapter_id' => $chapter->id,
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
            'chapter_id' => $chapter->id,
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
            'chapter_id' => $chapter->id,
            'title' => '4.4 Pemeliharaan Hidrolik & Drive Column',
            'content' => '<p><strong>Pemeliharaan Sistem Hidrolik (HPU):</strong></p><ul><li><strong>Pengecekan Oli:</strong> Gunakan oli hidrolik tipe ISO VG 46. Pastikan level oli tidak berada di bawah garis indikator minimal pada tangki.</li><li><strong>Tekanan Kerja Hidrolik:</strong> Tekanan standar operasional adalah 140 bar (2000 psi). Periksa kebocoran di sambungan pipa/fitting jika tekanan menurun.</li></ul>' .
                '<p class="mt-4"><strong>Pemeliharaan Drive Column & Mekanikal:</strong></p><ul><li><strong>Pelumasan Ball Screw:</strong> Ulir elevating system harus dilumasi secara merata dengan grease lithium berkualitas tinggi setiap bulan.</li><li><strong>Penyelarasan Roda:</strong> Periksa alignment roda penggerak untuk mencegah keausan ban sepihak.</li></ul>',
            'order' => 4,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
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
    }
}
