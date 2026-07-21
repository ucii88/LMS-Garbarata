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

        Module::where('chapter_id', $chapter->id)->delete();

        $order = 1;

        // --- 4.1 Perawatan Garbarata ---
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.1 Perawatan Garbarata',
            'content' => '<p>Perawatan rutin Garbarata akan mencegah kerusakan dan memperpanjang umur Garbarata. Perawatan tersebut meliputi prosedur-prosedur inspeksi, pembersihan, pengecatan, penataan serta salah satu prosedur yang sangat penting yaitu prosedur pelumasan. Prosedur pelumasan merupakan hal yang sangat penting. Prosedur-prosedur yang disampaikan pada bab ini sangat dianjurkan.</p>' .
                '<p class="mt-3">Perawatan secara keseluruhan harus dilakukan secara rutin untuk memastikan semua bagian Garbarata berfungsi dengan baik. Perawatan rutin juga dapat memprediksi durasi operasi bagian-bagian Garbarata dan juga dapat menentukan perbaikan seperti apa yang dibutuhkan untuk berbagai macam kerusakan.</p>' .
                '<p class="mt-3">Gunakan alat-alat yang sesuai dalam melakukan perbaikan, pengaturan dan service untuk mencegah kerusakan dan lain-lain. Gunakan tempat penampung air yang bersih ketika membersihkan, membilas dan mengisi ulang pelumas untuk gear box. Ikuti instruksi perawatan dari pabrik yang terdapat pada buku manual yang terlampir pada komponen yang dijual oleh Bukaka. Bersihkan tumpahan, kotoran, atau kumpulan kotoran dari aktivitas maintenance. Perawatan harus dilakukan secara rutin tiga bulan sekali (triwulan).</p>' .
                '<div class="my-4 p-3 bg-amber-50 rounded-lg border border-amber-100 text-amber-800"><strong>Pertimbangan Umum:</strong><ul class="list-disc list-inside mt-1"><li>(a) Hanya personel yang terlatih yang mengerjakan/mengoperasikan Garbarata</li><li>(b) Jangan terburu-buru dan sembarangan dalam perawatan Garbarata</li></ul></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.1.1 Karpet',
            'content' => '<p>Untuk menjaga kondisi karpet tetap bersih, jadwal pembersihan harus dilaksanakan seperti berikut:</p>' .
                '<ul class="list-disc list-inside mt-2">' .
                '<li>(a) Bersihkan karpet setiap hari</li>' .
                '<li>(b) Cuci karpet sesering mungkin dengan shampoo yang bebas detergen</li>' .
                '</ul>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.1.2 Jendela',
            'content' => '<p>Karena Garbarata selalu terpapar jet exhaust, maka akan terjadi pembentukan lapisan kotoran dari jet exhaust pada jendela-jendela Garbarata, oleh karena itu jendela harus dibersihkan setiap hari. Gunakan shampoo bebas detergen yang berkualitas tinggi untuk membersihkan permukaan tersebut.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.1.3 Dinding dan Ceiling Panel',
            'content' => '<p>Dinding dan langit-langit butuh pembersihan rutin. Gunakan shampoo yang bebas detergen untuk membersihkan kotoran.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.1.4 Panel Dinding Kaca',
            'content' => '<p>Dinding kaca harus dibersihkan dengan hati-hati. Gunakan shampoo bebas detergen yang ringan untuk menghilangkan kotoran. Saat dibersihkan, kaca bisa bergoncang.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.1.5 Peralatan Penerangan',
            'content' => '<p>Lensa-lensa dari peralatan penerangan seperti lampu harus dibersihkan sesering mungkin dengan shampoo bebas detergen. Keringkan seluruh perlengkapan dengan hati-hati sebelum dipasang kembali.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.1.6 Inspeksi Permukaan Luar',
            'content' => '<p>Dianjurkan untuk memeriksa permukaan bagian luar yang bercat sebelum kotoran dan sisa pelumas bereaksi. Pencucian periodik dengan detergen ringan akan membuat awet alat-alat yang bercat dan peralatan lainnya. Bersihkan puing dan korosi material dari atap secara periodik. Beri perhatian lebih pada lubang-lubang saluran pinggiran atap. Setengah tahun sekali gunakan air bersih bebas garam dan deterjen ringan untuk membersihkan endapan minyak hidrokarbon dari Garbarata. Pembersihan ini adalah bagian dari program preventive maintenance yang termasuk juga pengecekan terhadap permukaan yang bercat. Jika cat menunjukkan tanda-tanda pengelupasan atau jika terlihat karat, maka permukaan harus dicat ulang seperti berikut:</p>' .
                '<ul class="list-disc list-inside mt-2">' .
                '<li>(a) Gunakan pelarut untuk melakukan pembersihan pada daerah yang kotor atau berminyak</li>' .
                '<li>(b) Dengan amplas yang bagus, bersihkan area yang akan dicat ulang dari karat, korosi, dan cat yang mengelupas</li>' .
                '<li>(c) Lapisan pertama harus merupakan cat dasar yang berkualitas tinggi untuk logam</li>' .
                '<li>(d) Akhiri dengan dua lapis polyurethane enamel untuk menyesuaikan warna Garbarata</li>' .
                '</ul>' .
                '<div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold">PERHATIAN: JANGAN CAT BAGIAN-BAGIAN BERGERAK SEPERTI RANTAI, SPROCKET, SHAFT, BEARING, ROLLER ATAU REL/RAIL.</div>',
            'order' => $order++,
        ]);

        // --- 4.2 Rotunda dan Tekanan Cabin Curtain ---
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.2 Rotunda dan Tekanan Cabin Curtain',
            'content' => '<p>Curtain dapat diperiksa dengan menekan Curtain dari dalam. Ketegangannya harus cukup untuk menahan berat penumpang yang mungkin secara mendadak terperosok atau tersandung pada Curtain dan untuk mengencangkan curtain bersamaan saat cabin/rotunda berotasi. Curtain yang terlalu tegang/kencang akan cekung ke arah luar.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.2.1 Penyetelan Tekanan Curtain',
            'content' => '<p>Jika tegangan tidak sesuai berada pada Curtain dari lilitan pada panel Curtain barrel, lakukan hal berikut ini:</p>' .
                '<ul class="list-none space-y-2 mt-2">' .
                '<li><strong>(a)</strong> Lepaskan tutup/cover curtain barrel rotunda dari atas rotunda yang menuju ke kumparan curtain. Untuk cabin buka tutup/cover curtain barrel yang berengsel agar kumparan dapat terlihat.</li>' .
                '<li><strong>(b)</strong> Posisikan garbarata atau kabin agar Curtain yang akan disesuaikan dapat terbuka penuh.</li>' .
                '<li><strong>(c)</strong> Putar garbarata atau kabin perlahan agar Curtain yang terbuka mulai menggulung. Putar garbarata ke arah yang Curtain akan gagal menggulung tanpa bantuan manual (manual assistance).</li>' .
                '<li><strong>(d)</strong> Tanpa memegang atau menekan Curtain, putar worm gear dengan arah berlawanan jarum jam untuk Curtain sebelah kiri dan searah jarum jam untuk Curtain sebelah kanan, hingga Curtain tertarik kencang pada kumparannya.</li>' .
                '<li><strong>(e)</strong> Lanjutkan prosedur ini hingga Curtain berputar dari posisi terbukanya ke posisi tergulung tanpa masalah apapun.</li>' .
                '<li><strong>(f)</strong> Putar garbarata pada kedua arah untuk memastikan apakah Curtain memiliki tegangan yang cocok.</li>' .
                '</ul>' .
                '<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs"><strong>CATATAN:</strong> Enam belas putaran dari kumparan di-setting di pabrik. Meskipun demikian, pengaturan dilakukan selama instalasi dan jumlah ini mungkin berubah.</div>' .
                '<div class="p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase">PERHATIAN: HATI-HATI TERLUKA BERTEKANAN TINGGI. KARENA KUMPARAN YANG BERTEKANAN TINGGI.</div>',
            'order' => $order++,
        ]);

        // --- 4.3 Drive Column dan Wheel Boogie ---
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.3 Drive Column dan Wheel Boogie',
            'content' => '<p>Pemeliharaan drive column dan kaki penopang (wheel boogie) sangat krusial untuk kestabilan serta keamanan pergerakan naik-turun maupun maju-mundur Garbarata.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.3.1 Inspeksi Vertikal Limit Switch',
            'content' => '<p>Personel maintenance garbarata harus mengecek secara fisik kinerja upper dan lower limit switch vertical pada kedua drive column setiap bulan. Hal ini dapat dilaksanakan dengan menggerakkan garbarata ke atas dan ke bawah, seorang asisten dibutuhkan untuk mengontrol limit switch. Periksalah satu limit switch pada satu waktu. Pada umumnya, garbarata akan berhenti dengan melakukan hal tersebut. Jika salah satu dari limit switch tidak berhenti pada gerakan vertical, personnel maintenance harus segera menggantinya.</p>' .
                '<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs"><strong>CATATAN:</strong> Jika limit column initial limit switch yang full up atau full down bergerak (aktif) dan saat itu garbarata mengalami gagal power (power putus/mati) seluruh gerakan ke atas akan berhenti setelah power putus. Untuk memperoleh kembali control gerakan vertical, tekan tombol reset bersamaan dengan menggerakkan garbarata pada posisi berlawanan arah dari posisi semula hingga limit switch tidak aktif, sekarang gerakan vertical garbarata akan normal seperti semula.</div>' .
                '<div class="p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase mb-4">PERHATIAN: SEBUAH LIMIT SWITCH YANG RUSAK DAPAT BERAKIBAT RUSAKNYA DRIVE COLUMN DAN BANTALAN LIFT COLUMN.</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.3.2 Bantalan Lift Column',
            'content' => '<p>Bantalan <em>oil-impregnated nylon-molybdenum</em> berfungsi sebagai column guides dan mencegah logam dan logam bersentuhan. Setiap lift column memiliki 8 bantalan, 4 di atas dan 4 lainnya di bawah. Seseorang harus memeriksa daya tahan bantalan tersebut setahun sekali.</p>' .
                '<div class="overflow-x-auto my-4"><table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-center">KETEBALAN BANTALAN</th><th class="p-2 border border-gray-200 text-left">INDIKASI</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 text-center font-semibold">25 mm</td><td class="p-2 border border-gray-200 text-left">Ketebalan Awal</td></tr>' .
                '<tr class="bg-slate-50/50"><td class="p-2 border border-gray-200 text-center font-semibold">23.5 mm</td><td class="p-2 border border-gray-200 text-left">Sesuaikan shim pada pads sehingga mencapai ketebalan aslinya.</td></tr>' .
                '<tr><td class="p-2 border border-gray-200 text-center font-semibold">22 mm</td><td class="p-2 border border-gray-200 text-left">Ganti pad</td></tr>' .
                '</tbody></table></div>' .
                '<p class="mt-3">Bantalan-bantalan ini biasanya tidak selalu rata, untuk mengatasi masalah ini, bantalan-bantalan tersebut bisa diputar setelah habis terpakai 1,5 mm. Periksa alas bantalan terlebih dahulu, jika alas yang lebih rendah karena terpakai bantalan atasnya juga harus dicek.</p>' .
                '<div class="mt-4 p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase mb-4">PERHATIAN: JANGAN MENGENCANGKAN BAUT PADA PLATE BANTALAN TERLALU RAPAT. SISAKAN RUANG UNTUK CONE SPRINGS UNTUK MENGANTISIPASI PERGESERAN LIFT COLUMN.</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.3.3 Inspeksi Ball Screw',
            'content' => '<p>Lift column ball-screw harus dilumasi and diperiksa setelah 5 tahun sejak diservis dari korosi yang berlebihan, keretakan, lubang, cekung/lekuk, atau pemakaian yang tidak biasa dari ball grooves. Setelah pemeriksaan yang pertama ball screw harus diperiksa setiap 5 tahun.</p>' .
                '<p class="mt-2">Pelumasan dan pembersihan ball screw dapat dilakukan dengan menaikkan dan menurunkan garbarata dari posisi tertinggi ke posisi terendah dalam waktu yang bersamaan sementara itu pelumas dimasukkan melalui corong kecil yang terletak di bawah lower column. Pihak maintenance dapat membersihkan lift column 3 bulan sekali.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.3.4 Kekencangan Lift Column',
            'content' => '<p>Periksalah baut-baut yang terpasang pada lift column and wheel boogie setelah setahun beroperasi and kencangkan baut-baut tersebut pada kekencangan yang dianjurkan seperti yang disebutkan pada diagram Fastener Torque.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.3.5 Rantai Boogie Drive',
            'content' => '<p>Rantai-rantai ini meskipun dirakit dengan benar dari pabrik, tetap harus diperiksa kembali secara teratur. Ganti bagian rantai yang renggang, retak atau kejanggalan yang lain.</p>' .
                '<p class="mt-2">Buanglah konektor yang jelek, ganti dan hubungkan dengan master link. Jangan ada take-up device ataupun gigi yang tidak berfungsi tetap terpasang pada rantai. Ketika melakukan setting, ikutilah aturan petunjuk untuk tegangan rantai, jumlah pembengkokan/kecondongan rantai minimal harus sama dengan pitch rantai itu sendiri, pada saat pembengkokan maksimum pada rantai 3% dari panjang total.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.3.6 Rem Cyclo Drive Motor',
            'content' => '<p>Rem pada horizontal dan vertical cycle drive bekerja secara elektro mekanik dan pemeriksaan yang teratur dan service akan memastikan performa yang baik. Rem harus diperiksa setelah beroperasi satu tahun. Untuk memeriksa baik rem vertical atau horizontal drive, kru maintenance memerlukan dongkrak.</p>' .
                '<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs mb-4"><strong>CATATAN:</strong> Pada setiap pemeriksaan, ikutilah langkah-langkah yang dijelaskan pada buku manual/buku pedoman yang terlampir pada bab 6.</div>' .
                '<div id="torque-diagram" class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-6 max-w-md mx-auto flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">RECOMMENDED FASTENER TORQUE</p>' .
                '<img src="/images/modules/enhanced_diagram.png" class="w-full max-h-72 object-contain rounded-lg select-none" alt="Recommended Fastener Torque">' .
                '</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.3.7 Ban',
            'content' => '<p class="font-bold text-slate-700 text-xs mb-2">CARA MELEPASKAN BAN</p>' .
                '<ul class="list-none space-y-1.5 text-xs text-slate-600">' .
                '<li><strong>a)</strong> Angkat garbarata di atas dongkrak/Jacking Stand.</li>' .
                '<li><strong>b)</strong> Tahan tombol down hingga roda menyentuh tanah.</li>' .
                '<li><strong>c)</strong> Bongkar pelindung rantai dan putus rantai dengan melepas penghubung rantai.</li>' .
                '<li><strong>d)</strong> Lepaskan bearing tapper yang terpasang pada lockwasher, buat pengaturan bearing, dan pengatur jarak.</li>' .
                '<li><strong>e)</strong> Lepas assembly dan sprocket assembly dengan hati-hati menggunakan palu dari belakang.</li>' .
                '<li><strong>f)</strong> Buka 12 sekrup dan bautnya untuk membongkar poros roda, lepaskan butiran-butiran ban dan bagian yang sebelah luar roda dan bongkar bagian tersebut.</li>' .
                '<li><strong>g)</strong> Ingat, wheel bearings pada saat ini terbuka. Bagian-bagiannya harus dibersihkan.</li>' .
                '<li><strong>h)</strong> Rakit kembali roda yang terpasang dengan membalikkan urutan prosedur-prosedur di atas.</li>' .
                '</ul>' .
                '<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs"><strong>CATATAN:</strong> Kencangkan 12 mur dan baut yang terpasang pada roda sesuai tabel tenaga putaran.</div>' .
                '<div class="space-y-6 mt-6 max-w-2xl mx-auto">' .
                '<div class="bg-gray-50 border border-gray-200 rounded-xl p-3 shadow-sm flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">WHEEL ASSEMBLY</p>' .
                '<img src="/images/modules/enhanced_wheel_assembly.png" class="w-full max-h-64 object-contain rounded-lg select-none" alt="Wheel Assembly">' .
                '</div>' .
                '<div class="bg-gray-50 border border-gray-200 rounded-xl p-3 shadow-sm flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">TIRE ASSEMBLY</p>' .
                '<img src="/images/modules/enhanced_tire_assembly.png" class="w-full max-h-64 object-contain rounded-lg select-none" alt="Tire Assembly">' .
                '</div>' .
                '</div>',
            'order' => $order++,
        ]);

        // --- 4.4 Roller Tunnel ---
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.4 Roller Tunnel',
            'content' => '<p>Pelajari seluruh penjabaran dibawah ini sebelum mencoba menyesuaikan Roller. Hal ini dapat membuat Roller tahan lama dan mencegah kerusakan yang fatal.</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.4.1 Distribusi Bobot pada Roller',
            'content' => '<p>Hampir pada setiap level position, sepenuhnya memendek dan memanjang, Roller LF (depan bawah) dan UR (Upper Rear) akan menahan lebih banyak bobot. Dan ketika garbarata sepenuhnya memanjang dalam posisi rata/lurus, bagian dari berat garbarata dibebankan pada roller UF (Upper Front) dan LR (Lower Rear). Ketika mengatur roller, penting sekali untuk mencoba menurunkan bobot pada LF dan UR sebanyak mungkin.</p>' .
                '<div class="overflow-x-auto my-4"><table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left">DESCRIPTION</th><th class="p-2 border border-gray-200 text-left">POSITION</th><th class="p-2 border border-gray-200 text-center">ABBR.</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 text-left">Kombinasi Camroll dan vertikal thrust roller.</td><td class="p-2 border border-gray-200 text-left">Atas belakang (kanan/kiri)</td><td class="p-2 border border-gray-200 text-center font-semibold">UR / UR</td></tr>' .
                '<tr class="bg-slate-50/50"><td class="p-2 border border-gray-200 text-left">Kombinasi Camroll dan vertikal thrust roller.</td><td class="p-2 border border-gray-200 text-left">Bawah belakang (kanan/kiri)</td><td class="p-2 border border-gray-200 text-center font-semibold">LR / LR</td></tr>' .
                '<tr><td class="p-2 border border-gray-200 text-left">Kombinasi Camroll dan Roller vertikal kanan</td><td class="p-2 border border-gray-200 text-left">Atas depan (kanan/kiri)</td><td class="p-2 border border-gray-200 text-center font-semibold">UF / UF</td></tr>' .
                '<tr class="bg-slate-50/50"><td class="p-2 border border-gray-200 text-left">Thrust roller tandem yang tidak perlu disesuaikan.</td><td class="p-2 border border-gray-200 text-left">Bawah depan (kanan/kiri)</td><td class="p-2 border border-gray-200 text-center font-semibold">LF / LF</td></tr>' .
                '<tr><td class="p-2 border border-gray-200 text-left">Roller lateral</td><td class="p-2 border border-gray-200 text-left">Bawah depan (kanan/kiri)</td><td class="p-2 border border-gray-200 text-center font-semibold">LT / LT</td></tr>' .
                '<tr class="bg-slate-50/50"><td class="p-2 border border-gray-200 text-left">Roller Stopper</td><td class="p-2 border border-gray-200 text-left">Bawah (kanan/kiri).</td><td class="p-2 border border-gray-200 text-center font-semibold">SL / SL</td></tr>' .
                '</tbody></table></div>' .
                '<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-6 max-w-md mx-auto flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">ROLLER WEIGHT DISTRIBUTION</p>' .
                '<img src="/images/modules/enhanced_weight_distribution.png" class="w-full max-h-72 object-contain rounded-lg select-none" alt="Roller Weight Distribution">' .
                '</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.4.2 Pengaturan Vertikal Roller',
            'content' => '<p>Perpanjangan dan lurusnya posisi garbarata untuk melepas bobot pada roller LF karena LF adalah vertical, tidak perlu diatur, thrust roller, ini menjadi awal yang baik untuk memulai.</p>' .
                '<div class="space-y-3 mt-2 text-xs text-slate-600">' .
                '<div>' .
                '<p class="font-bold text-slate-700 text-xs mt-2 mb-1">(a) Mengukur roller LR dan LF:</p>' .
                '<ul class="list-disc list-inside ml-4 mt-1 space-y-1">' .
                '<li>(i) Buang access covers dan weathering dari roller-roller ini.</li>' .
                '<li>(ii) Tentukan bagaimana roller UR dan LR harus sesuai untuk memperoleh jarak yang sama antara A & B, dan jarak yang sama antara C dan D seperti ditunjukkan pada figure Tunnel Cross Section.</li>' .
                '</ul>' .
                '<p class="ml-4 mt-1.5 font-semibold text-slate-700">Pendekkan garbarata untuk menghilangkan beban dari roller UR:</p>' .
                '<ul class="list-decimal list-inside ml-8 mt-1 space-y-0.5">' .
                '<li>Tarik cover dari roller ini.</li>' .
                '<li>Lepaskan jam nuts/mur yang macet pada roller UR untuk membersihkan LR.</li>' .
                '<li>Kencangkan baut.</li>' .
                '<li>Mundurkan satu putaran penuh pada bolt UR di sisi kiri, kencangkan jam nut.</li>' .
                '</ul>' .
                '</div>' .
                '<div>' .
                '<p class="font-bold text-slate-700 text-xs mt-3 mb-1">(b) Panjangkan garbarata perlahan untuk mengalihkan beban/bobot ke roller UR:</p>' .
                '<ul class="list-disc list-inside ml-4 mt-1 space-y-1">' .
                '<li>(i) Hilangkan access cover dari roller LR.</li>' .
                '<li>(ii) Lepaskan jam nuts pada bolt pengaturan vertikal pada roller LR.</li>' .
                '<li>(iii) Sesuaikan roller sehingga jarak antara A dan B sama dengan jarak antara C dan D. Lihat panduan Tunnel Cross Section.</li>' .
                '</ul>' .
                '</div>' .
                '<div>' .
                '<p class="font-bold text-slate-700 text-xs mt-3 mb-1">(c) Pendekkan garbarata perlahan untuk memindahkan bobot belakang pada roller LR:</p>' .
                '<ul class="list-disc list-inside ml-4 mt-1 space-y-1">' .
                '<li>(i) Lepaskan jam nuts pada bolt pengaturan vertikal pada roller UR.</li>' .
                '<li>(ii) Kencangkan bolt-bolt ini hingga roller merapat pada rel.</li>' .
                '<li>(iii) Mundurkan bolt satu putaran penuh.</li>' .
                '<li>(iv) Kencangkan jam nut.</li>' .
                '</ul>' .
                '</div>' .
                '<div>' .
                '<p class="font-bold text-slate-700 text-xs mt-3 mb-1">(d) Panjangkan garbarata untuk memindahkan bobot pada roller UR dan LF:</p>' .
                '<ul class="list-disc list-inside ml-4 mt-1 space-y-1">' .
                '<li>(i) Tarik access cover dari roller UF.</li>' .
                '<li>(ii) Lepaskan jam nuts yang macet dan putar bolt pengaturan vertical pada roller UF hingga roller bersandar betul pada rel.</li>' .
                '<li>(iii) Mundurkan baut satu putaran.</li>' .
                '<li>(iv) Kencangkan mur.</li>' .
                '</ul>' .
                '</div>' .
                '<p class="mt-3"><strong>(e)</strong> Jalankan garbarata mundur maju beberapa kali dan cek kembali jarak antara A dan B, C dan D. Jika setelah berturut-turut jaraknya tidak sama antara satu dengan yang lain, ulangi prosedur pengaturan pada langkah di atas.</p>' .
                '</div>' .
                '<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-6 max-w-2xl mx-auto flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">TUNNEL ROLLERS ADJUSTMENT</p>' .
                '<img src="/images/modules/b2_tunnel_rollers_adjustment_hd.png" class="w-full max-h-64 object-contain rounded-lg select-none" alt="Tunnel Rollers Adjustment">' .
                '</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.4.3 Pengaturan Horizontal Roller',
            'content' => '<div class="space-y-3 mt-2 text-xs text-slate-600">' .
                '<div>' .
                '<p class="font-bold text-slate-700 text-xs mt-2 mb-1">(a) Panjangkan dan luruskan garbarata serta hilangkan semua access cover:</p>' .
                '<ul class="list-disc list-inside ml-4 mt-1 space-y-1">' .
                '<li>(i) Mengukur dari dalam tunnel B, tentukan bagaimana roller LR and LF menyesuaikan untuk memperoleh jarak yang sama diantara E dan F.</li>' .
                '<li>(ii) Mengukur dari luar tunnel B, tentukan bagaimana roller-roller ini menyesuaikan untuk memperoleh jarak yang sama diantara G dan H.</li>' .
                '</ul>' .
                '</div>' .
                '<p><strong>(b)</strong> Lepaskan jam nuts pada baut horizontal adjustment dengan memundurkan roller UF yang cukup untuk memperjelas pengaturan roller LT. Dimensi E dan F harus sama.</p>' .
                '<p><strong>(c)</strong> Pendekkan garbarata perlahan untuk mengalihkan beban pada roller LR and UF. Lepas jam nuts dan mundurkan roller UR yang cukup untuk melakukan pengaturan roller LR. Dimensi G dan H harus sama.</p>' .
                '</div>' .
                '<div class="my-4 p-3 bg-red-50 rounded-lg border border-red-100 text-red-800 font-semibold text-xs uppercase my-4">PERHATIAN: KETIKA MELEPAS ROLLER UR DAN UF, JANGAN MEMUNDURKANNYA MELEBIHI KEBUTUHAN UNTUK MENGATUR LR DAN LT. MELEPASKAN ROLLER INI TERLALU BANYAK DAPAT MERUSAK TUNNEL.</div>' .
                '<div class="space-y-3 text-xs text-slate-600">' .
                '<div>' .
                '<p class="font-bold text-slate-700 text-xs mt-3 mb-1">(d) Panjangkan perlahan garbarata untuk memindahkan bobot roller UR and LF:</p>' .
                '<ul class="list-disc list-inside ml-4 mt-1 space-y-1">' .
                '<li>(i) Lepaskan jam nuts pada roller LR and LT.</li>' .
                '<li>(ii) Putarlah bolt pengaturan pada roller LR and LT pada arah tunnel yang bergerak untuk membuat jarak G ke H, dan E ke F sama. Lihat bagian A-A and C-C pada figure tunnel cross section.</li>' .
                '<li>(iii) Kencangkan side bolt yang berlawanan pada roller LR and LT untuk mengatasi celah dari penyetelan di item atas.</li>' .
                '<li>(iv) Dengan jarak G ke H, dan A ke F sama, kencangkan setiap baut hingga roller bertumpu pada rel dengan baik, kemudian mundurkan masing-masing bolt satu persatu.</li>' .
                '<li>(v) Kencangkan jam nuts.</li>' .
                '</ul>' .
                '</div>' .
                '<div>' .
                '<p class="font-bold text-slate-700 text-xs mt-3 mb-1">(e) Roller UF:</p>' .
                '<ul class="list-disc list-inside ml-4 mt-1 space-y-1">' .
                '<li>(i) Kencangkan roller UF-R hingga bertumpu pada rel dengan baik, kemudian kencangkan jam nut. Lihat bagian B-B pada figure tunnel cross section.</li>' .
                '<li>(ii) Pada sisi yang berlawanan, kencangkan roller UF-L hingga bertumpu pada rel dengan baik kemudian mundurkan satu putaran, kencangkan jam nut. Lihat bagian B-B pada Tunnel Cross Section figure.</li>' .
                '</ul>' .
                '</div>' .
                '<div>' .
                '<p class="font-bold text-slate-700 text-xs mt-3 mb-1">(f) Roller UR:</p>' .
                '<ul class="list-disc list-inside ml-4 mt-1 space-y-1">' .
                '<li>(i) Pendekkan garbarata untuk mengalihkan bobot pada roller UR and UF.</li>' .
                '<li>(ii) Kencangkan roller UR-R hingga bertumpu pada rel dengan baik dan kencangkan jam nut. Lihat sesi A-A pada TCS.</li>' .
                '<li>(iii) Pada sisi sebaliknya, kencangkan roller UR-L hingga bertumpu pada rel dengan baik dan mengencangkan jam nut.</li>' .
                '</ul>' .
                '</div>' .
                '<p><strong>(g)</strong> Gerakkan garbarata maju mundur beberapa kali untuk mengecek E ke F, G ke G tetap sama. Toleransi 3mm pada tiap arah tidak masalah.</p>' .
                '<p><strong>(h)</strong> Ganti access cover setelah selesai mengecek pengaturan.</p>' .
                '</div>' .
                '<p class="mt-4">Setelah pengaturan ini, gerakkan garbarata maju dan mundur beberapa kali sambil dengarkan jika ada decitan, suara tak normal atau letusan. Jika tunnel berisik, lepaskan bolt dari pengaturan pada roller yang berisik &frac14; putaran, dan lihat jika hal tersebut bisa memperbaiki masalahnya. Lanjutkan dengan melepas perlahan roller yang berisik hingga suara tersebut hilang. Jika anda tidak bisa mengatasi roller kanan, kerjakan prosedur kebalikannya pengaturan ini, lepas pada masing-masing putaran.</p>',
            'order' => $order++,
        ]);

        // --- 4.5 Canopy Closure ---
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.5 Canopy Closure',
            'content' => '<p>Ada dua macam perbedaan pada bahan Frayed Closure:</p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.5.1 Perbaikan Canopy Fabric',
            'content' => '<p class="font-bold text-slate-700 text-xs mb-2">LUBANG BERDIAMETER KURANG DARI ATAU SAMA DENGAN 3 MM</p>' .
                '<ul class="list-none space-y-1.5 text-xs text-slate-600">' .
                '<li><strong>(i)</strong> Bersihkan area sekitar lubang, kedua sisi Fabric, dengan pembersih dasar alkohol. Biarkan benar-benar kering.</li>' .
                '<li><strong>(ii)</strong> Gunakan silikon aluminium berwarna untuk lubang/berjumbai dan sekitarnya.</li>' .
                '<li><strong>(iii)</strong> Biarkan silikon kering sekurangnya 60 menit. Waktu kerja silikon kurang dari 10 menit. Perawatan penuh normalnya 24 jam tergantung pada cuaca dan temperatur.</li>' .
                '</ul>' .
                '<p class="font-bold text-slate-700 text-xs mt-4 mb-2">LUBANG BERDIAMETER LEBIH DARI 3 MM</p>' .
                '<p class="text-xs text-slate-600">Harus dikuatkan dengan tambalan dari bahan dasarnya yang berukuran 25 mm lebih lebar dari lubang yang dimaksud. Prosedur umumnya adalah sebagai berikut:</p>' .
                '<ul class="list-none space-y-1.5 text-xs text-slate-600 mt-2">' .
                '<li><strong>(i)</strong> Bersihkan area sekitar lubang, kedua sisi susunan, dengan pembersih dasar alkohol. Biarkan benar-benar kering.</li>' .
                '<li><strong>(ii)</strong> Gunakan silikon aluminium berwarna untuk permukaan bagian dalam. Area yang dilindungi harus lebih lebar 12 mm dari lubangnya/tambalan.</li>' .
                '<li><strong>(iii)</strong> Tutupi area dengan lembaran film polyethylene (PE) yang lebih lebar dari area yang diperbaiki. Rapatkan film ke semua <em>entrapped air</em> (udara yang terperangkap). Udara bebas silikon harus menahan polyethylene di tempat selama pengerjaan kanopi bagian luar.</li>' .
                '<li><strong>(iv)</strong> Gunakan jumlah silikon yang sama untuk permukaan luar sementara gunakan film polyethylene sebagai penyangga pada sisi yang berlawanan. Tutupi lapisan luar silikon dengan lembaran film PE lainnya. Biarkan film selama 60 menit agar mengering. Waktu pengerjaan untuk silikon ini kurang dari 10 menit.</li>' .
                '<li><strong>(v)</strong> Film dapat diangkat dan garbarata dapat dioperasikan setelah silikon benar-benar mengering. Pengeringan penuh normalnya 24 jam tergantung pada cuaca dan temperatur.</li>' .
                '<li><strong>(vi)</strong> Untuk Lubang yang lebih besar, khususnya pada lipatan bagian bawah mungkin akan membutuhkan peralatan penjepit (clamp) untuk memastikan penambalan yang baik. Jika alat penjepit digunakan harus diperhatikan agar silikon jangan diolesi melebihi dari permukaan PE Film karena silikon akan merekatkan kedua permukaan yang sedang di-press. Silikon tidak akan menempel pada PE film.</li>' .
                '</ul>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.5.2 Closure Limit Switches',
            'content' => '<p class="text-xs text-slate-600 mb-2">Untuk mengatur limit switch, ikuti langkah-langkah berikut:</p>' .
                '<ul class="list-none space-y-1.5 text-xs text-slate-600">' .
                '<li><strong>(a)</strong> Naikkan sepenuhnya closure.</li>' .
                '<li><strong>(b)</strong> Lepaskan baut-baut pada <em>lower tie-bar arm</em>.</li>' .
                '<li><strong>(c)</strong> Susun baut-baut ke atas atau ke bawah sehingga wheel pada limit switch arm berada di tengah-tengah bantalan.</li>' .
                '<li><strong>(d)</strong> Lepaskan Allen screw pada limit switch arm dan set arm wheel dengan celah antara wheel dan bantalan adalah 3 sampai 6 mm.</li>' .
                '</ul>' .
                '<div class="my-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-blue-800 text-xs">' .
                '<strong>NOTE:</strong>' .
                '<ul class="list-none space-y-1 mt-1">' .
                '<li><strong>(i)</strong> Hal ini akan melengkapi penyesuaian pada stop limit.</li>' .
                '<li><strong>(ii)</strong> Versi yang terbaru dari Garbarata disediakan dengan apa yang disebut <em>pressure relief limit switch</em>, menempel langsung di bawah stop limit switch.</li>' .
                '<li><strong>(iii)</strong> Jika limit switch tersebut dipasang, sesuaikan pressure relief limit switch, yaitu arm wheelnya bersandar pada stop limit switch.</li>' .
                '</ul>' .
                '</div>' .
                '<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm my-6 max-w-md mx-auto flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">CANOPY ARM ADJUSTMENT</p>' .
                '<img src="/images/modules/canopy_arm_adjustment.png" class="w-full max-h-72 object-contain rounded-lg select-none" alt="Canopy Arm Adjustment">' .
                '</div>',
            'order' => $order++,
        ]);

Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.1 Pemeriksaan Harian untuk Operator',
            'content' => '<p>Pelajari panduan pemeriksaan harian di bawah ini untuk menjaga kondisi operasional jembatan Garbarata.</p>' .
                '<h4 class="font-bold text-slate-800 text-xs mt-6 mb-2">4.6.1 Pemeriksaan Harian untuk Operator</h4>' .
                '<ul class="list-none space-y-3 text-xs text-slate-600">' .
                '<li>' .
                '<strong>(a)</strong> Operator harus memeriksa <em>auto level</em> setiap pagi. Gerakkan wheel dengan tangan, ke atas dan ke bawah, drive column akan bergerak menyesuaikan. Perhatikan gerakan dapat berputar bebas dan pegas-pegas kembali ke posisi netralnya. Periksa kekencangan sekrup-sekrup yang menahan shaft dan periksa juga apakah switch benar-benar menempel. Kerusakan wheel switch dapat merusak pesawat.' .
                '</li>' .
                '<li>' .
                '<strong>(b)</strong> Operator juga harus memeriksa pengoperasian garbarata, khususnya system kerja autolevel dan pengatur jarak limit switch. Laporan beberapa malfunction ke departemen maintenance.' .
                '</li>' .
                '<li>' .
                '<strong>(c)</strong> Operator harus mengecek garbarata secara langsung, khususnya untuk hardware yang hilang atau habis terpakai, cat terkelupas, debu dan korosi, minyak bocor, susunan komponen yang rusak atau jelek. Masalah area harus dilaporkan ke departemen maintenance.' .
                '</li>' .
                '</ul>' .
                '<div class="my-4 p-3 bg-amber-50 rounded-lg border border-amber-100 text-amber-900 text-xs">' .
                '<strong>Tindakan Pencegahan Kerusakan Leveler:</strong>' .
                '<ul class="list-none space-y-1 mt-1">' .
                '<li><strong>(i)</strong> Hindari perawatan kasar pada leveler.</li>' .
                '<li><strong>(ii)</strong> Jangan mencoba memutar wheel pada shaftnya.</li>' .
                '<li><strong>(iii)</strong> Jangan menggunakan wheel sebagai footrest.</li>' .
                '<li><strong>(iv)</strong> Jangan pernah memaksa menghentikan mechanical stop.</li>' .
                '<li><strong>(v)</strong> Beberapa shims yang dilepaskan atau yang mungkin jatuh selama proses maintenance harus diganti sebelum re-securing limit switch.</li>' .
                '</ul>' .
                '</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.2 Pelumasan',
            'content' => '<h4 class="font-bold text-slate-800 text-xs mt-6 mb-2">4.6.2 Pelumasan</h4>' .
                '<ul class="list-none space-y-3 text-xs text-slate-600">' .
                '<li>' .
                '<strong>(a)</strong> Pelumasan adalah bagian paling penting pada program preventive maintenance dan pada bagian ini harus dilakukan dengan menggunakan checklist. Penghitungan pada point bagian ini untuk beberapa point yang membutuhkan pelumasan. Spesifikasi tabel pelumasan menjelaskan minyak pelumas dan penggunaannya.' .
                '</li>' .
                '<li>' .
                '<strong>(b)</strong> Hanya teknisi yang memenuhi syarat yang boleh melumasi garbarata. Mereka harus mengerti syarat \'pelumasan yang cukup\' yaitu tidak melumas berlebihan.' .
                '</li>' .
                '</ul>' .
                '<div class="overflow-x-auto my-4">' .
                '<p class="text-[10px] font-bold text-slate-500 mb-1.5 uppercase">Tabel 5-1: Lubricants Specification</p>' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead>' .
                '<tr class="bg-gray-50 text-slate-700 font-bold">' .
                '<th class="p-2 border border-gray-200 text-center">No.</th>' .
                '<th class="p-2 border border-gray-200 text-left">SPECIFICATION</th>' .
                '<th class="p-2 border border-gray-200 text-left">PRODUCER</th>' .
                '</tr>' .
                '</thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr>' .
                '<td class="p-2 border border-gray-200 text-center font-semibold"># 1</td>' .
                '<td class="p-2 border border-gray-200 text-left">UG-857 HEAVY DUTY PELUMAS BEARING atau sejenisnya, seperti BEACON 2 atau LOTUS 777 AR.</td>' .
                '<td rowspan="3" class="p-2 border border-gray-200 text-center align-middle bg-slate-50/50">' .
                'Pertamina, Shell, Mobil, Exxon, Lotus, Castrol atau sejenisnya.' .
                '</td>' .
                '</tr>' .
                '<tr>' .
                '<td class="p-2 border border-gray-200 text-center font-semibold"># 2</td>' .
                '<td class="p-2 border border-gray-200 text-left">EP PELUMAS RANTAI EXTREME PRESSURE atau sejenisnya, seperti ALMAS COAT 2C atau ROCOL.' .
                '</td>' .
                '</tr>' .
                '<tr>' .
                '<td class="p-2 border border-gray-200 text-center font-semibold"># 3</td>' .
                '<td class="p-2 border border-gray-200 text-left">PELUMAS RODA GIGI TERBUKA EXTREME PRESSURE TAHAN AIR atau sejenisnya, seperti MOBILTAC YY atau ROCOL M27.' .
                '</td>' .
                '</tr>' .
                '<tr>' .
                '<td class="p-2 border border-gray-200 text-center font-semibold"># 4</td>' .
                '<td class="p-2 border border-gray-200 text-left">PELUMAS MOTOR UMUM atau sejenisnya, seperti SAE 10W-30 atau ROTELLA.</td>' .
                '<td class="p-2 border border-gray-200 text-center bg-slate-50/50">Pertamina atau sejenisnya.</td>' .
                '</tr>' .
                '</tbody>' .
                '</table>' .
                '</div>' .
                '<div class="grid grid-cols-1 gap-6 my-6">' .
                '<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">CANOPY ARM ADJUSTMENT</p>' .
                '<img src="/images/modules/canopy_arm_adjustment.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="Canopy Arm Adjustment">' .
                '</div>' .
                '<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">WHEEL BOOGIE ASSEMBLY</p>' .
                '<img src="/images/modules/enhanced_wheel_boogie_assembly.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="Wheel Boogie Assembly">' .
                '</div>' .
                '<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">CABIN ROTATION SYSTEM</p>' .
                '<img src="/images/modules/enhanced_cabin_rotation.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="Cabin Rotation System">' .
                '</div>' .
                '<div class="rounded-xl border border-gray-200 bg-gray-50 p-3 shadow-sm flex flex-col items-center">' .
                '<p class="text-[10px] font-bold text-slate-500 text-center mb-2">ROTUNDA ASSEMBLY</p>' .
                '<img src="/images/modules/rotunda_hd.png" class="w-full max-h-96 object-contain rounded-lg select-none" alt="Rotunda Assembly">' .
                '</div>' .
                '</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.3.1 AUTO LEVEL',
            'content' => '<p class="text-xs text-slate-600 leading-relaxed mb-4">Untuk memastikan operasi GARBARATA aman, Tim dari Maintenance Department harus memeriksa Passenger Boarding Bridge secara rutin dengan mengoperasikan semua fungsi dan sistem yang ada, dalam skala perbulan merujuk pada Tabel lnspeksi Bulanan dibawah ini. Kondisi lokal pun berperan menentukan perincian yang tepat mengenai program Maintenance yang paling efisien dan efektif.</p>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI BULANAN</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Periksa semua sekrup yang menahan roda ke Limit Switch. Keduanya harus selalu kencang.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Putar roda dengan tangan pada kedua arah untuk memastikan bebasnya pergerakan ketika difungsikan dan pastikan kembalinya roda ke posisi netral. Hal ini akan bersesuaian dengan Limit Switch.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>3.</strong> Periksa Arm, Arm ini harus bergerak bebas pada kedua arah.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>4.</strong> Putar ketiga posisi Switch ke Auto dan periksa jalannya Autolevel Limits terhadap perpanjangan Arm. Setelah kira-kira 3 detik akan muncul Pesan Kesalahan, Buzzer dan Alarm menunjukkan roda Autolevel tidak bersentuhan dengan pesawat. Untuk menstimulasi operasi normal, hentikan Arm diposisi sebelum PX6 dan PX7 aktif.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>5.</strong> Putar dan tahan roda dengan tangan untuk menstimulasi naiknya pesawat. Kira-kira setelah 6 detik, lampu peringatan Autolevel menyala dan alarm bersuara.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>6.</strong> Reset sistem Autolevel dan periksa down travel dengan memutar dan menahan Wheel Counter searah jarum jam. Kira-kira 6 detik, lampu peringatan menyala dan alarm bersuara.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>7.</strong> Letakkan pemilih switch autolevel ke posisi OFF dan periksa alarm serta buzzer harus segera berhenti bersuara.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.3.2 LIMIT SWITCH DAN OPERASI DETEKTOR',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI BULANAN</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Jalankan perlahan jembatan boarding penumpang Garbarata, operasikan limit switch dengan menggunakan tangan dan verifikasi system berikut bekerja dengan benar:<br><span class="pl-4 inline-block">a. Peringatan limit rotasi kabin (Kanan/Kiri)</span><br><span class="pl-4 inline-block">b. Peringatan limit rotasi kabin ekstrim (Kanan/Kiri)</span><br><span class="pl-4 inline-block">c. Limit switch slowdown maju dan mundur</span><br><span class="pl-4 inline-block">d. Limit switch stop maju dan mundur</span><br><span class="pl-4 inline-block">e. Limit switch slowdown atas dan bawah</span><br><span class="pl-4 inline-block">f. Limit switch stop atas dan bawah</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Limit Switch slow down; arah maju dan mundur.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>3.</strong> Scanner Infra Merah jalankan perlahan; maju dan mundur.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>4.</strong> Spacer Limit pesawat; maju saja.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>5.</strong> Steering maksimum Boogie; kanan dan kiri.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>6.</strong> Kanopi atas dan bawah; kanan dan kiri.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>7.</strong> Limit Switch arah vertical; naik dan turun.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>8.</strong> Slope Limit; turun (naik - pilihan).</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>9.</strong> Rotasi kabin maksimum; kanan dan kiri.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>10.</strong> Leveling lantai kabin; naik dan turun.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>11.</strong> Gerakan maksimum rotunda; kanan dan kiri.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>' .
                '<div class="mt-3 p-3 bg-blue-50/50 text-blue-800 text-[11px] border border-gray-100 rounded-lg"><strong>CATATAN:</strong><br>a. Periksa hanya satu Limit Switch dalam satu waktu.<br>b. Semua gerakan harus dilakukan perlahan jika pengoperasian terasa kasar and berisik, periksa gangguan di atas Roller Tracks.</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.3.3 PERIKSA BAN',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI BULANAN</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Periksa kondisi umum ban.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Periksa kekencangan baut pada velg, apabila kendur, kencangkan menggunakan torque wrench.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.3.4 DETAIL KESELURUHAN',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI BULANAN</th><th class="p-2 border border-gray-200 text-center w-1/4">COMMENTS</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Periksa pengait kable Equalizing pada tiga Tunnel di Garbarata dan kondisi Steel Cable.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Semua exterior permukaannya dicat dan harus selalu bersih dari kotoran dan oli, khususnya pada engsel, Limit Switches, dll.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>3.</strong> Periksa cat dari serpihan yang mengelupas, retakan, dan karat. Touch-up jika diperlukan.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.1 ROTUNDA',
            'content' => '<p class="text-xs text-slate-600 leading-relaxed mb-2">Bagian ini berhubungan dengan program inspeksi untuk operasi dan pemberian minyak Garbarata agar dapat dipenuhi setiap tiga bulan sekali. Pekerjaan tersebut harus dijadwalkan dari awal sampai selesai tanpa gangguan. Hal ini akan menjamin tidak ada tahapan yang terabaikan disebabkan karena kurang hati-hati.</p>' .
                '<p class="text-xs text-slate-600 leading-relaxed mb-4">Grafik berikut hanya untuk referensi, kondisi lokal akan menentukan detail yang sesuai untuk program Maintenance yang efektif dan efisien.</p>' .
                '<p class="text-[11px] font-bold text-slate-700 uppercase tracking-wide mb-2 mt-4">Bagian 1: Operasional & Fungsi</p>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Manipulasi Limit Switch berikut dengan menggunakan tangan, pastikan Limit Switch berfungsi dengan baik:<br><span class="pl-4 inline-block">a. Rotasi Rotunda</span><br><span class="pl-4 inline-block">b. Batas Slope</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Periksa kekencangan Side Curtains Rotunda, sesuaikan jika perlu.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.2 KABIN',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Periksa rotasi kabin, rotasikan penuh kabin ke arah kanan dan kiri. Pengoperasian harus perlahan.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Periksa fungsi Closure:<br><span class="pl-4 inline-block">a. Turunkan kedua Canopy canopy kanan dan kiri pada saat yang sama, buka perpanjangan closure seluruhnya sampai terdengar bunyi klik. Canopy bergerak turun dan garbarata tidak akan maju kedepan.</span><br><span class="pl-4 inline-block">b. Naikkan kedua Canopy kanan dan kiri. Motor akan berhenti bekerja pada saat Closure naik seluruhnya.</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>3.</strong> Periksa kekencangan Curtain di sisi kabin dan sesuaikan jika diperlukan.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>4.</strong> Periksa Sisi kabin termasuk kabel listrik terhadap kerusakan dan kondisi umumnya.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>5.</strong> Kesalahan Vertikal Lift Column pada Limit Switches (Periksa hanya satu limit switch pada satu waktu):<br><span class="pl-4 inline-block">a. Secara manual jalankan limit switch sementara seorang lainnya bekerja menaikkan dan menurunkan Garbarata. Jika Garbarata berlanjut naik atau turun, limit switch rusak dan harus digantikan.</span><br><span class="pl-4 inline-block">b. Ulangi prosedur ini pada Limit Switch yang lain.</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>' .
                '<div class="mt-3 p-3 bg-blue-50/50 text-blue-800 text-[11px] border border-gray-100 rounded-lg"><strong>CATATAN:</strong> Semua shim/ganjalan Limit Switch yang bergetar atau dilepaskan atau yang jatuh selama proses apapun harus digantikan sebelum mengencangkan semua limit switch tersebut.</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.3 SAMBUNGAN LISTRIK',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td colspan="2" class="p-2 text-slate-500 font-semibold italic border border-gray-200 bg-slate-50/30">Periksa Control Console operator, Power Panel and Main Panel listrik:</td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Semua PCB, Jaringan Kabel dan Susunan Listrik dari sambungan yang kemungkinan longgar.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Bersihkan area yang sering terjadi kontak dengan pembersih kontak.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>3.</strong> Periksa kelembaban, karat dan serpihan-serpihan.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>4.</strong> Periksa semua tanda lengkungan atau sambungan yang longgar.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.4 AUTOLEVEL',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Periksa semua sekrup yang menahan roda ke limit Switch. Keduanya harus selalu kencang.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Putar roda dengan tangan pada kedua arah untuk memastikan bebasnya pergerakan ketika difungsikan dan pastikan kembalinya roda ke posisi netral. Hal ini akan bersesuaian dengan Limit Switch.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>3.</strong> Periksa Arm, Arm ini harus bergerak bebas pada kedua arah.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>4.</strong> Putar ketiga posisi Switch ke Auto dan periksa jalannya Autolevel limits terhadap perpanjangan Arm. Setelah kira-kira 3 detik akan muncul Pesan Kesalahan, Buzzer dan Alarm menunjukkan roda Autolevel tidak bersentuhan dengan pesawat. Untuk menstimulasi operasi normal, hentikan Arm diposisi sebelum PX6 dan PX7 aktif.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>5.</strong> Putar dan tahan roda dengan tangan untuk menstimulasi naiknya pesawat. Kira-kira setelah 6 detik, lampu peringatan Autolevel menyala dan alarm bersuara.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>6.</strong> Reset sistem Autolevel dan periksa down travel dengan memutar dan menahan Wheel Counter searah jarum jam. Kira-kira 6 detik, lampu peringatan menyala dan alarm bersuara.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>' .
                '<div class="mt-3 p-3 bg-blue-50/50 text-blue-800 text-[11px] border border-gray-100 rounded-lg"><strong>CATATAN:</strong> Timer Auto Level diatur oleh Internal Counter Program melalui Programmable Logic Controller. Tekan tombol Emergency saat Auto mode periksa apakah alarm dapat terdengar baik.</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.5 PEMERIKSAAN BAN-BAN',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Periksa kondisi keseluruhan ban.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Periksa kekencangan baut pada velg, apabila kendur, kencangkan menggunakan torque wrench.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.6 KONDISI UMUM DARI EXTERIOR DAN PELAPIS CUACA',
            'content' => '<p class="text-[11px] font-bold text-slate-700 uppercase tracking-wide mb-2 mt-6">Bagian 2: Struktur, Pelapis Cuaca & Pelumasan Berkala</p>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>1.</strong> Kabel Equalizing (hanya untuk jembatan tiga Tunnel saja):<br><span class="pl-4 inline-block">a. Periksa Wire Rope Equalizing kabel di tunnel, dan sesuaikan jika diperlukan.</span><br><span class="pl-4 inline-block">b. Periksa kekencangan Turnbuckles dari Equalizing Kabel dan kondisi dari Steel Cable.</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>2.</strong> Tempat pembawa atau penahan kabel / Cable Scissor:<br><span class="pl-4 inline-block">a. Periksa kekencangan dan kondisi kabel dasar/bawah, kabel Penahan dan rel kabel dasar/bawah.</span><br><span class="pl-4 inline-block">b. Periksa semua kabel terhadap kerusakan.</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>3.</strong> Periksa kekencangan dan kondisi semua terminal dalam Junction Box dibawah tunnel.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>4.</strong> Periksa kondisi semua pelapis cuaca, perbaiki atau ganti jika diperlukan.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>5.</strong> Periksa semua tunnel rollers dan bearing-bearing, semua gerakan naik-turun harus linear dan halus.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>6.</strong> Periksa cat dari serpihan yang mengelupas, retakan, dan karat. Touch-up jika diperlukan.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>7.</strong> Periksa dinding kaca dari kelupasan dan retakan.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>8.</strong> Periksa baut-baut yang ada di motor horizontal dan Lift Column, pastikan semua dalam keadaan kencang.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.7 ROTUNDA (LUMAS!)',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>a.</strong> Rotunda Column Flange dan Bearings Sleeve dengan pelumas No. 1.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>b.</strong> Curtain Pillow Blocks dan Worm Gears di kedua sisi Rotunda dengan pelumas No. 2.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>c.</strong> Rotunda Hinge dengan pelumas No. 3.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.8 TUNNELS',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>a.</strong> Bagian-bagian system untuk 3 Tunnel Equalize Cable dengan pelumas No. 2:<br><span class="pl-4 inline-block">(i) Sheave Rods</span><br><span class="pl-4 inline-block">(ii) Kabel Tension Rod (Tegangan)</span><br><span class="pl-4 inline-block">(iii) Kabel Guide Rollers (Penuntun)</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>b.</strong> Periksa kekencangan dari Turnbuckles dari tiga tunnel Garbarata dan kondisi dari Kabel Steel.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>c.</strong> Semua unit Roller dengan pelumas No. 4.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.9 VERTICAL COLUMN',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>a.</strong> Naikkan Garbarata sampai maksimal untuk melumasi dan membersihkan Ball Screw dengan pelumas No. 1 jika diperlukan.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>b.</strong> Bearing di Vertical Lift Column pada setiap sambungan diatas setiap Column dengan menggunakan pelumas No. 1.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>c.</strong> Vertical Motor dengan pelumas No. 4.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.10 WHEEL BOOGIE',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>a.</strong> Thrust Bearing dengan pelumas No. 1.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>b.</strong> Bushing dan Trunnion Pin dengan pelumas No. 1.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>c.</strong> Rantai-rantai penggerak pada Wheel Boogie dengan pelumas No. 2.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>d.</strong> Horizontal Motor dengan pelumas No. 4.</td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>' .
                '<div class="mt-3 p-3 bg-blue-50/50 text-blue-800 text-[11px] border border-gray-100 rounded-lg"><strong>CATATAN:</strong> Bearings pada roda harus dilumasi juga ketika komponen roda dilepaskan dengan pelumas No. 1.</div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.6.4.11 KABIN (LUMAS!)',
            'content' => '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-3/4">POINT-POINT INSPEKSI QUARTAL</th><th class="p-2 border border-gray-200 text-center w-1/4">KETERANGAN</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200"><strong>a.</strong> Komponen Mekanikal di Closure Kabin dengan pelumas No. 3:<br><span class="pl-4 inline-block">(i) Actuator pivot point.</span><br><span class="pl-4 inline-block">(ii) Actuator arm bushings.</span><br><span class="pl-4 inline-block">(iii) Pivot block.</span><br><span class="pl-4 inline-block">(iv) Support Hinge.</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '<tr><td class="p-2 border border-gray-200"><strong>b.</strong> Bagian-bagian yang berputar di Kabin:<br><span class="pl-4 inline-block">(i) Rantai-rantai penggerak, pelumas No. 3</span><br><span class="pl-4 inline-block">(ii) Sprocket Shafts, pelumas No. 3</span><br><span class="pl-4 inline-block">(iii) Cabin Curtain pillow block dan worm gears pada kedua sisi dari kabin dengan pelumas No. 2.</span></td><td class="p-2 border border-gray-200"></td></tr>' .
                '</tbody></table></div>',
            'order' => $order++,
        ]);

                Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7 Panduan Troubleshooting',
            'content' => '<p class="text-xs text-slate-600 leading-relaxed mb-4">Manual troubleshooting dibuat sebagai acuan untuk pemeliharaan dan perbaikan yang memadai. Tabel-tabelnya berisi masalah-masalah umum, kemungkinan kasus-kasus yang terjadi dan semua tindakan-tindakan dalam upaya perbaikan yang benar. Manual ini dibuat bagi teknis-teknisi yang memenuhi syarat dalam mengatasi masalah-masalah yang mungkin muncul.</p>' .
                '<p class="text-xs text-slate-600 leading-relaxed">Petunjuk ini bisa menjadi pegangan dan gambaran terbaik maintenance di lapangan disamping juga mempertahankan perawatan yang baik. Manual ini meliputi, perbaikan-perbaikan kecil, penyesuaian, lokasi-lokasi masalah dan penggantian komponen-komponen rusak. Penggantian, pemasangan, overhead dan perbaikan masing-masing komponen akan dijelaskan pada sub bagian dari manual ini.</p>' .
                '<p class="text-xs font-semibold text-blue-600 mt-4"><em>*Klik pada masing-masing judul TROUBLE di bawah ini untuk melihat detail tabel penyebab dan tindakan perbaikan.</em></p>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.1 TROUBLE 1',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 1</h5>' .
                '<p class="text-xs mt-1">Keyswitch dalam posisi OFF dan tombol power dalam posisi ON, tetapi tidak ada tenaga pada sirkuit utama dan sirkuit control.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">KEMUNGKINAN PENYEBAB</th><th class="p-2 border border-gray-200 text-left w-1/2">TINDAKAN YANG BENAR</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Tidak ada power dari Terminal</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa pusat tenaga, jika OFF, cek listrik dengan multitester.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa MCCB1, MCCB2, ELCB1 dan MCB1. Jika Tripped, nyalakan.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa tegangan listrik pada saluran 380VAC dan 220VAC dengan multi tester.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">ELCB1 terbuka</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Posisikan ELCB1 ke \'ON\'. Jika Tripped, periksa peringatan kesalahan untuk sambungan longgar atau kemungkinan-kemungkinan yang lain. Perbaiki.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Tombol Emergency tertekan atau tidak berfungsi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Reset kembali Tombol Emergency.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Listrik mungkin mengalir pada saluran masuk tombol darurat, tapi tidak pada saluran keluar. Tombol rusak. Ganti Tombol.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Tombol POWER-ON tidak bekerja</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Listrik mungkin mengalir pada saluran masuk tombol, tapi tidak pada saluran keluar. Tombol rusak. Ganti Tombol.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Komponen Penghantar Listrik RL2 tidak bekerja</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Coil (gulungan) dan penghubung-penghubung. Ganti bila perlu/rusak.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">7</span><span class="flex-1">MCB2 dalam control console unit untuk sirkuit kontrol terbuka</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Nyalakan MCB2. Jika Tripped lagi, periksa kabel, sambungan yang longgar/lepas, atau masalah-masalah lainnya, perbaiki masalah.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">8</span><span class="flex-1">Keyswitch tidak bekerja</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa keyswitch, jika tidak bekerja, ganti.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">9</span><span class="flex-1">Switch power supply tidak dapat beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa tegangan output DC dari modul switching power supply. Periksa juga fuse nya. Jika rusak, ganti.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.2 TROUBLE 2',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 2</h5>' .
                '<p class="text-xs mt-1">Garbarata tidak merespon terhadap perintah gerakan Vertikal pada saat Manual Mode.</p>' .
                '</div>' .
                '<div class="bg-blue-50 text-blue-900 p-3 rounded-lg border border-blue-100 text-xs mb-4">' .
                '<strong>CATATAN (NOTE) - Pada kondisi ini pastikan bahwa:</strong>' .
                '<ul class="list-decimal pl-4 mt-1.5 space-y-1">' .
                '<li>Lampu tombol Power-ON yang memastikan bahwa tenaga/listrik mengalir pada unit.</li>' .
                '<li>Canopy dalam posisi Retract penuh and indicator tombol Canopy DOWN tidak menyala.</li>' .
                '<li>Tombol Keyswitch dalam kondisi MANUAL.</li>' .
                '<li>Garbarata tidak total retract atau extend, ini berarti kondisi Limit Switch Tunnel tidak aktif.</li>' .
                '<li>Posisi Garbarata tidak dalam keadaan paling tinggi atau paling rendah, ini berarti kondisi Limit Switch pada Drive Column tidak aktif.</li>' .
                '<li>Panel tenaga MCCB4 pada Box Panel motor dalam keadaan ON.</li>' .
                '<li>Kedua Drive Columns (kiri dan kanan) dalam keadaan seimbang/sejajar, dalam keadaan ini Fault Limits/ Column fault tidak aktif.</li>' .
                '</ul>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Kontrol sirkuit tidak aktif</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa MCCB4. Jika turun, nyalakan sekali lagi.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa kelebihan panas OL1 dan OL2. Jika Tripped, reset.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa tombol untuk gerakan Vertikal Atas/Bawah pada meja Control Console. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa Limit Switches LS9, LS10, LS11, LS12 dan kabelnya. Jika tidak berfungsi, perbaiki atau ganti bila perlu.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa kontak magnetic C4 dan C5, jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Periksa sistem interlock PX1, LS3A, LS3B, LS4A dan LS4B. Jika tidak berfungsi perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">7</span><span class="flex-1">Periksa kabel-kabel, jika rusak ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">8</span><span class="flex-1">Periksa Power Supply, bila tidak berfungsi perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">9</span><span class="flex-1">Periksa Keyswitch. Jika tidak berfungsi perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">10</span><span class="flex-1">Periksa lampu pilot, jika lampu peringatan service berkedip-kedip periksa kode error didalam Console Desk dan perbaiki masalah lalu reset.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Vertikal motor kanan atau kiri tidak aktif</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa tegangan listrik yang masuk. Jika memungkinkan periksa motor. Perbaiki atau ganti motor.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Program tidak berfungsi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Mohon hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk gantikan yang lama.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Ball Screw tidak berfungsi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa toleransi putaran, perbaiki bila diperlukan.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Rem Mekanik tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Rem Mekanik.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Perbaiki atau ganti gulungan magnet untuk motor rem.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Lihat instruksi manual untuk motor.</span></div></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.3 TROUBLE 2.1',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 2.1</h5>' .
                '<p class="text-xs mt-1">Vertical Drive kelebihan Trip sebelum sampai batas ketinggian yang tepat.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Penuh, ketiga fase tidak mensuplai tenaga ke motor.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa urutan kontak utama dari C1 ke MCCB4.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Dalam motor power panel, periksa overload heater OL1 and OL2 pada kontak Vertical Drive.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa vertical Drive kontaktor C4 dan C5.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Ball Screw berhenti atau terjepit</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa toleransi putaran, perbaiki bila diperlukan.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Rem Mekanik tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Rem Mekanik.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Perbaiki atau ganti gulungan magnet untuk motor rem.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Lihat instruksi manual untuk motor.</span></div></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.4 TROUBLE 2.2',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 2.2</h5>' .
                '<p class="text-xs mt-1">Garbarata tidak dapat turun walaupun sistem-sistem yang lainnya bekerja, sementara posisi pada manual mode.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit Kontrol tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Tombol Vertikal \'Turun\' pada meja Console. Jika tidak aktif perbaiki atau ganti dan periksa urutan input PLC unit.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa gulungan dan sambungan-sambungan dari penghubung magnetic CS (C5). Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa Limit Switch untuk Vertikal Turun, LS9, 10, 11, 12. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa Limit Switch untuk Interlock System, LS3B, LS4B dan PX1.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa output Tegangan dari Switching Power Supply, hasilnya harus 24VDC. Jika tidak perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Periksa semua kabel-kabel, jika rusak ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">7</span><span class="flex-1">Periksa Link Terminal (TX2). Input pada Junction Box C2.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Program ladder tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BTU agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.5 TROUBLE 2.3',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 2.3</h5>' .
                '<p class="text-xs mt-1">Rem untuk motor penggerak vertikal tidak berfungsi</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Kesalahan jaringan kabel</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa rangkaian pengereman.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa semua kabel-kabel, ganti jika rusak.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa semua varistor untuk pengereman yang cepat. Jika tidak berfungsi, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Rem Mekanik tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Rem Mekanik.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Perbaiki atau ganti gulungan magnet untuk motor rem.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Lihat instruksi manual untuk motor.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Rem-rem tidak terpasang dengan benar</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Lihat instruksi manual untuk memasang rem-rem.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Pelumas atau minyak ada pada piringan rem</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Bersihkan dengan pembersih.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Varistor (Vanistor) untuk rem cepat yang tidak baik.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa varistor. Jika kurang baik, ganti (berada didalam Motor Power Panel).</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.6 TROUBLE 2.4',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 2.4</h5>' .
                '<p class="text-xs mt-1">Garbarata tidak bisa naik atau terangkat padahal sistem lain bekerja.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit Kontrol tidak beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Tombol Vertikal \'Naik\' pada meja Console. Jika tidak aktif perbaiki atau ganti dan periksa urutan input PLC unit.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa gulungan dan sambungan-sambungan dari penghubung magnetic C4.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa Limit Switch untuk gerakkan Vertikal Naik, LS9, LS10, LS11, LS12.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa Limit Switch untuk Interlock System, LS3A dan LS4A.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa output Tegangan dari Switching Power Supply, hasilnya harus 24VDC. Jika tidak perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Periksa semua kabel-kabel, jika rusak, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Program ladder tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.7 TROUBLE 3',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 3</h5>' .
                '<p class="text-xs mt-1">Kabin tidak dapat berotasi</p>' .
                '</div>' .
                '<div class="bg-blue-50 text-blue-900 p-3 rounded-lg border border-blue-100 text-xs mb-4">' .
                '<strong>CATATAN :</strong> Berdasarkan pengalaman kami, masalah pada motor, sistem rem, gigi dan sistem rantai sangat jarang terjadi kerusakan. Sistem ini dirancang dengan ketahanan tinggi dan tidak akan menimbulkan masalah-masalah' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Kontrol Sirkuit tidak berfungsi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa MCCB5. Jika Tripped, nyalakan \'ON\' sekali lagi.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa Thermal Overload relay OL3. Jika Tripped, reset.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa tombol Cabin Rotation pada meja Console, jika tidak berfungsi, perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa Contactor untuk Cabin Rotation C6 dan C7. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa Limit Switches LS17B, LS17A, LS18A, LS18B. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Periksa Limit Switches untuk interlock sistem LS19, LS20, LS23, LS24 dan LS-25. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">7</span><span class="flex-1">Periksa kabel-kabel dalam Sirkuit untuk Cab Drive Motor. Jika ada kabel yang tidak terhubung, perbaiki.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Motor tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa listrik pada bagian Input. Jika ada aliran listrik, periksa motor.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Program PLC tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Komponen mekanikal tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa sprocket, rantai atau bearing. Perbaiki atau ganti apabila sudah tidak layak.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Kesalahan jaringan kabel, sambungan longgar, atau sambungan berkarat.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa urutan kabel-kabel dan sambungan-sambungan. Perbaiki atau ganti bila diperlukan.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.8 TROUBLE 3.1',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 3.1</h5>' .
                '<p class="text-xs mt-1">Kabin tidak bisa berputar ke kiri, walaupun sistem yang lain berfungsi dengan baik.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit kontrol tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa urutan dan sambungan-sambungan kontak dari tombol Cabin Rotation kearah kiri agar dapat digunakan pada PLC. Perbaiki atau ganti jika perlu.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa Limit Switch untuk Cabin Rotation untuk yang arah kiri LS17A. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa Limit Switch untuk Cabin Rotation LS18A (back up).</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa kontak/sambungan dan coil magnetik kontaktor C6 untuk Cabin Rotation arah kiri. Perbaiki atau ganti jika diperlukan.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Kesalahan jaringan kabel, sambungan longgar, atau sambungan berkarat.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa urutan kabel-kabel dan sambungan-sambungan. Perbaiki atau ganti bila diperlukan.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Program PLC tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.9 TROUBLE 3.2',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 3.2</h5>' .
                '<p class="text-xs mt-1">Kabin tidak bisa berputar ke kanan, walaupun sistem yang lain berfungsi dengan baik.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit Kontrol tidak beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa urutan dan sambungan-sambungan kontak dari tombol Cabin Rotation kearah kanan agar dapat digunakan pada PLC. Perbaiki atau ganti jika perlu.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa Limit Switch untuk Cabin Rotation untuk yang arah kanan LS17B. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa Ultimate Limit Switch untuk Cabin Rotation LS18B (back up).</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa kontak/sambungan dan coil magnetik kontaktor C7 untuk Cabin Rotation arah kanan. Perbaiki atau ganti jika diperlukan.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa Link terminal input dan output. Jika tidak berfungsi, replace.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Kesalahan jaringan kabel, sambungan longgar, atau sambungan berkarat.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa urutan kabel-kabel dan sambungan-sambungan. Perbaiki atau ganti bila diperlukan.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Program PLC tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.10 TROUBLE 4',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 4</h5>' .
                '<p class="text-xs mt-1">Auto level Arm tidak bisa bergerak ketika tombol keyswitch diposisikan ke AUTOLEVEL mode, sementara lampu indikator menyala.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit Kontrol tidak beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa posisi dari keyswitch. Jika tidak berfungsi, perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa RL13. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa jaringan kabel untuk PLC. Jika ada sambungan longgar/lepas, perbaiki.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Interlock System untuk gerak vertikal tidak aktif.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa lampu AUTOLEVEL. Jika tidak berfungsi, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Program PLC tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Motor Actuator dari Autolevel tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Motor Actuator. Jika tidak berfungsi perbaiki atau ganti motor.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Mekanisme di Arm macet, patah atau ada bagian yang hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hilangkan penghalang dan perbaiki.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.11 TROUBLE 5',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 5</h5>' .
                '<p class="text-xs mt-1">Suara Alarm tidak berfungsi selama mode AUTOLEVEL dan saat Automatic Levelling tidak berfungsi atau pada saat Main Power Garbarata down.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Kontrol sirkuit tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa relay RL14. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa keyswitch. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa Dry Battery dan tegangan (24VDC). Jika tidak berfungsi, perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa alat pembunyi alarm. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa jaringan kabel untuk PLC. Jika ada sambungan rusak, perbaiki.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Program PLC tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Horn tidak berfungsi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa alat alarm. Jika tidak berfungsi, ganti.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.12 TROUBLE 6',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 6</h5>' .
                '<p class="text-xs mt-1">Ketika kontrol pada posisi AUTO mode, Auto Level Arm dan Roda berhenti pada Fuselage pesawat dan aliran listrik Garbarata dalam keadaan \'ON\', Garbarata tidak mengikuti gerakan naik/turun pesawat.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit Kontrol tidak beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa keyswitch. Jika tidak berfungsi, perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa Limit Switch LS26A dan LS26B. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Jika ada kabel-kabel yang tidak tersambung, perbaiki.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa jaringan kabel untuk PLC. Jika ada sambungan rusak, perbaiki.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Interlock Aktif, periksa indicator vertikal limit, Slope Limit, dan Column Fault Limit Switch.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Program PLC tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.13 TROUBLE 7',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 7</h5>' .
                '<p class="text-xs mt-1">Ketika kontrol pada AUTO mode, Indikator Autolevel ON, Service Warning menyala dan berkelap-kelip sementara suara Buzzer / mendengung terdengar terus menerus.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit control tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Autolevel Fuse, jika fuse putus, ganti dengan fuse baru.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Kesalahan jaringan kabel, sambungan longgar, atau sambungan berkarat.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa urutan kabel-kabel dan sambungan-sambungan. Perbaiki atau ganti bila diperlukan.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Program PLC tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BTU agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.14 TROUBLE 8',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 8</h5>' .
                '<p class="text-xs mt-1">Horizontal Motor tidak bereaksi terhadap semua perintah.</p>' .
                '</div>' .
                '<div class="bg-blue-50 text-blue-900 p-3 rounded-lg border border-blue-100 text-xs mb-4">' .
                '<strong>CATATAN : Saat hal ini terjadi, pastikan bahwa:</strong>' .
                '<ul class="list-decimal pl-4 mt-1.5 space-y-1">' .
                '<li>Lampu power menyala. Jika ada tenaga.</li>' .
                '<li>Tombol Keyswitch berada pada posisi Manual.</li>' .
                '<li>Pastikan kalau Canopy Retracted secara penuh, dan indikator Canopy Down dalam keadaan Off.</li>' .
                '<li>Posisi Garbarata dalam batas memanjang atau memendek dan dalam batas putarannya, dimana kondisi limit switches tidak bergerak.</li>' .
                '<li>MCCB3 pada Distribution Power Panel dalam keadaan ON.</li>' .
                '</ul>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit Kontrol tidak beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa switch tiga posisi. Jika tidak berfungsi, perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa micro switch dan potentiometer pada Joystick. Jika tidak berfungsi, perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa PCB Steering. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa Limit Switches LS1A, LS1B, LS2A, LS2B, LS3A, LS3B, LS4A, LSB, LS19, LS23, LS24, LS25, LS21 dan PX1. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa Limit Switches untuk Wheel Boogie LS13, LS14, LS15 atau LS16. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Periksa semua sistem kabel-kabel pengontrol. Jika rusak, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">7</span><span class="flex-1">Periksa koneksi terminal Input dan Output. Jika tidak berfungsi, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">MCCB3 untuk memberi tenaga pada...</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Nyalakan/\'ON\' MCCB3. Jika MCCB3 Tripped lagi, periksa kesalahan jaringan kabel atau sebab lain yang menyebabkan Trip.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Rem pada Horizontal Motor bekerja tidak normal</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa penghubung magnetik C3, coil/gulungan dan sambungan-sambungan. Ganti jika diperlukan.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa komponen rem pada Horizontal Motor Drive. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Lihat Manual Pengoperasian untuk Brake Motors.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Transistor Inverter tidak bekerja</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa dan ukur Input Power Voltage/ tegangan yang masuk R1/S1/T1.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa kesalahan pada kabel, sambungan-sambungan lepas atau sambungan yang berkarat pada sirkuit.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Jika Transistor Inverter tidak berfungsi, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Bagian Mekanik tidak berfungsi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Sproket-sproket, rantai-rantai dan Bearing. Ganti apabila tidak berfungsi.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Kesalahan jaringan kabel, sambungan longgar, atau sambungan berkarat.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa urutan kabel-kabel dan sambungan-sambungan. Perbaiki atau ganti bila diperlukan.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.15 TROUBLE 9',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 9</h5>' .
                '<p class="text-xs mt-1">Wheel Boogie tetap berbelok ke kanan atau kiri meskipun Joystick mengarah lurus maju atau mundur.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Transistor Inverter tidak bekerja</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Transistor Inverter kanan atau kiri.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Jika Wheel Boogie berputar kearah kanan, periksa Inverter sebelah kanan. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Jika Wheel Boogie berputar kearah kiri, periksa Inverter sebelah kiri. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa PCB Steering. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa kabel-kabel. Jika rusak, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Kutub-kutub positif dan negatif tegangan tidak tepat</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa kabel-kabel sebelah kanan dan kiri Horizontal Motor. Jika tidak benar, perbaiki.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Rem di Horizontal Drive Motor tidak berfungsi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa sambungan dan coil/gulungan magnetic kontaktor C3. Perbaiki seperlunya, atau jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Rem tidak berfungsi. Jika Input Power normal, perbaiki atau ganti rem.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Lihat Manual Operasional untuk Brake Motors.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Program yang telah disetting untuk Transistor Inverter tidak benar</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Reload program parameter untuk Horizontal Drive Inverter.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Lihat Manual Instruksi untuk Transistor Inverter.</span></div></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.16 TROUBLE 10',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 10</h5>' .
                '<p class="text-xs mt-1">Drive Unit/ unit penggerak bergerak kesana kemari ketika bergerak maju lurus atau mundur.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Kesalahan jaringan kabel, sambungan longgar, atau sambungan berkarat.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa koneksi. Perbaiki atau ganti apabila diperlukan.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Limit Switch slow down LS5 tidak dapat beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa limit switch untuk membuka dan menutup, apabila malfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa arm lever limit switch, apabila menyentuh tunnel, lepaskan.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa kabel secara keseluruhan apabila ada yang rusak, segera ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Scanner (Photo electric) untuk slow down tidak dapat beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa scanner (photo electric) kiri atau kanan, apabila malfungsi, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa kaca yang ada pada scanner, apabila kotor, bersihkan.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa tenaga yang masuk ke scanner, apabila ada berarti scanner yang mengalami kerusakan, maka harus diganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa kabel secara keseluruhan, apabila ada kerusakan berarti harus diganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa dan pindahkan apabila ada yang menghalangi scanner.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Transistor inverter tidak dapat beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa program inverter.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Lihat manual instruksi untuk transistor inverter.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Sirkuit control tidak dapat beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa potentiometer pada joystick, apabila malfungsi, perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa system wiring untuk PLC, apabila malfungsi, perbaiki.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa potentio adjustment untuk PCB Steering.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa link terminal input dan output, apabila malfungsi, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Ada beberapa hambatan di roller track</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa roller track secara keseluruhan, atas, bawah, depan dan belakang.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Hilangkan objek atau benda yang berada di lintasan roller.</span></div></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.17 TROUBLE 11',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 11</h5>' .
                '<p class="text-xs mt-1">Tenaga tersedia dan horizontal drive motor berdengung, tetapi tidak beroperasi.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Rem tidak terbuka.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa koneksi C3, apabila mengalami kerusakan, ganti.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Rem mengalami malfungsi. Apabila input normal, perbaiki atau ganti rem.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Kerusakan wiring atau hilang koneksi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Selanjutnya periksa sirkuit wiring dan koneksi. Perbaiki atau ganti apabila perlu.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Kabel motor horizontal rusak.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa kabel motor horizontal, apabila tidak terkoneksi, ganti.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Motor tidak dapat beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa motor dengan megger tester (merger tester), apabila malfungsi, ganti.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Masalah mekanikal</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa motor secara keseluruhan berikut komponennya, seperti rem, rantai dsb.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.18 TROUBLE 12',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 12</h5>' .
                '<p class="text-xs mt-1">Canopy Closure tidak mau naik atau turun</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit Kontrol tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa apakah indicator Service Warning menyala. Periksa MCB4 dan MCB5. Jika rusak, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa Keyswitch, jika tidak berfungsi perbaiki atau ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa tombol Canopy Up/Down. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Periksa Limit Switches untuk canopy kiri LS19, LS20A, dan LS20B. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Periksa Limit Switches untuk canopy kanan LS21, LS22A, dan LS22B. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Periksa RL11 and RL12 untuk Actuator Motor canopy kanan. Hati-hati tegangan 220VAC {1 fase}. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">7</span><span class="flex-1">Periksa RL9 and RL10 untuk Actuator Motor canopy kiri. Hati-hati tegangan 220VAC {1 fase}. Jika tidak berfungsi, ganti.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">8</span><span class="flex-1">Sebuah kabel mungkin putus, ganti kabel.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">9</span><span class="flex-1">Periksa adanya kesalahan jaringan kabel, sambungan lepas atau ada sambungan berkarat.</span></div><div class="flex items-start"><span class="w-5 shrink-0 font-semibold text-slate-700">10</span><span class="flex-1">Periksa hubungan terminal Input dan Output. Jika tidak berfungsi, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Motor Actuator kanan/kiri canopy tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa tenaga/listrik yang masuk. Jika ada tegangan masuk perbaiki atau ganti motor.</span></div><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa rem untuk Motor Actuator. Jika tidak berfungsi, ganti.</span></div></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Program PLC tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BUKAKA TEKNIK UTAMA agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Kesalahan pada jaringan kabel, sambungan lepas atau karat pada sambungan</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Teruskan memeriksa kabel-kabel dan sambungan. Perbaiki atau ganti bila perlu.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Masalah Mekanikal</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa dan singkirkan penghalang pada sistem mekanik canopy.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.19 TROUBLE 13',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 13</h5>' .
                '<p class="text-xs mt-1">Motor Actuator Canopy berbunyi atau motor rusak.</p>' .
                '</div>' .
                '<div class="bg-blue-50 text-blue-900 p-3 rounded-lg border border-blue-100 text-xs mb-4">' .
                '<strong>NOTE :</strong> Pastikan motor tidak tertahan ketika Arm Canopy berjalan.' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Sirkuit Kontrol tidak beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Lihat Masalah 12. Ikuti tindakan no. 1 sd 10.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Motor Capacitor tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Canopy Motor Capacitor yang berada didalam Console Desk. Periksa tegangan dalam motor. Jika normal dan motor tidak berjalan, Capacitor yang tidak berfungsi, ganti.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Canopy Motor tidak beroperasi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa rem Motor Actuator. Jika tidak berfungsi, ganti atau perbaiki.</span></div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.20 TROUBLE 14',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 14</h5>' .
                '<p class="text-xs mt-1">Lampu-lampu</p>' .
                '<ul class="list-disc pl-4 text-xs mt-1.5 space-y-1 text-red-700">' .
                '<li>Periksa semua kabel-kabel lampu.</li>' .
                '<li>Pastikan kalau MCB1 sebagai sumber tenaga listrik ke lampu dalam keadaan ON dan aliran listrik tersedia.</li>' .
                '<li>Pastikan jika saklar lampu berfungsi normal.</li>' .
                '</ul>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Lampu tidak menyala</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5">' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Lampu mengalami kerusakan, Ganti Lampu.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Salah pemasangan kabel, perbaiki.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">adaptor tidak berfungsi, ganti lampu.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Kelembaban terlalu tinggi.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Suhu lampu yang terlalu rendah atau tinggi.</span></div>' .
                '</div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Jangka waktu hidup lampu pendek</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5">' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Tegangan tidak sesuai.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Kesalahan pemasangan kabel.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Waktu hidup lampu yang pendek (kurang dari pada rata-rata pemakaian lampu perharinya). Periksa ke perusahaan pembuat lampu.</span></div>' .
                '</div></td></tr>' .
                '</tbody></table></div></div>',
            'order' => $order++,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '4.7.21 TROUBLE 15',
            'content' => '<div class="rounded-xl border border-red-200 bg-white p-4 shadow-sm mt-6">' .
                '<div class="bg-red-50 text-red-800 p-3 rounded-lg border border-red-100 mb-4">' .
                '<h5 class="font-bold text-xs uppercase">TROUBLE 15</h5>' .
                '<p class="text-xs mt-1">Indikator dari Vertical Lift Column menyala dan pesan error muncul.</p>' .
                '</div>' .
                '<div class="overflow-x-auto">' .
                '<table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs">' .
                '<thead><tr class="bg-gray-50 text-slate-700 font-bold"><th class="p-2 border border-gray-200 text-left w-1/2">PROBABLE CAUSE</th><th class="p-2 border border-gray-200 text-left w-1/2">CORRECTIVE ACTION</th></tr></thead>' .
                '<tbody class="divide-y divide-gray-100 text-slate-600">' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Salah satu sisi Vertical Lift Column bergerak lebih cepat dari yang lain menyebabkan sisinya miring/condong.</span></div></td>' .
                '<td class="p-2 border border-gray-200"><div class="space-y-1.5">' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><div class="flex-1">' .
                '<span>Indikator Column Fault akan menyala bila salah satu Column/tiang naik 70mm lebih tinggi dari yang lain. Hal ini dapat menyebabkan kerusakan struktur pada Lift Column. Jika ini terjadi maka periksa:</span>' .
                '<div class="pl-4 mt-1.5 space-y-1">' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">a</span><div class="flex-1"><span>Plate dasar dari Lift Column.</span>' .
                '<div class="pl-4 mt-0.5 space-y-0.5">' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">i</span><span class="flex-1">Periksa adanya baut yang copot atau longgar.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">ii</span><span class="flex-1">Periksa adanya las/sambungan besi yang rusak/retak.</span></div>' .
                '</div></div></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">c</span><span class="flex-1">Kotak Lift Column. Periksa bagian dalam kotak, pastikan tidak ada yang rusak, perbaiki kerusakan yang dominant agar garbarata dapat beroperasi kembali.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">d</span><span class="flex-1">Jika kedua Lift Column tidak sejajar dan indikator dari kesalahan Lift Column vertikal menyala, departemen pemeliharaan harus segera dihubungi.</span></div>' .
                '</div>' .
                '<div class="mt-2 p-2 bg-amber-50 text-amber-900 border border-amber-100 rounded">' .
                '<strong>PERINGATAN:</strong>' .
                '<ul class="list-disc pl-4 mt-1 space-y-1 text-slate-700">' .
                '<li>Operator tidak disarankan memperbaiki kerusakan.</li>' .
                '<li>Hubungi PT. BUKAKA TEKNIK UTAMA jika terdapat kerusakan yang parah pada struktur Garbarata.</li>' .
                '</ul>' .
                '</div>' .
                '</div></div>' .
                '</div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Sirkuit Kontrol tidak dapat beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5">' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa Limit Switch Column Fault, L dan R (LS7 & LS8).</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa semua kabel-kabel. Jika rusak, ganti.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Periksa hubungan terminal Input dan Output. Jika tidak berfungsi, ganti.</span></div>' .
                '</div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Motor vertikal kanan dan kiri tidak beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa motor vertikal. Jika rusak, ganti.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">4</span><span class="flex-1">Salah satu rem mekanik vertikal motor tidak beroperasi.</span></div></td><td class="p-2 border border-gray-200"><div class="space-y-1.5">' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa rem mekanik. Jika tidak berfungsi, perbaiki atau ganti.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">2</span><span class="flex-1">Periksa gulungan/kumparan magnetik motor rem {C4 dan CS}. Jika rusak, ganti.</span></div>' .
                '<div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">3</span><span class="flex-1">Lihat petunjuk manual untuk motor rem.</span></div>' .
                '</div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">5</span><span class="flex-1">Salah satu Ball Screw tidak berfungsi</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Periksa toleransi dari sekrup yang terpasang. Jika tidak berfungsi, perbaiki jika memungkinkan.</span></div></td></tr>' .
                '<tr><td class="p-2 border border-gray-200 align-top"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">6</span><span class="flex-1">Program tidak beroperasi atau hilang</span></div></td><td class="p-2 border border-gray-200"><div class="flex items-start"><span class="w-4 shrink-0 font-semibold text-slate-700">1</span><span class="flex-1">Hubungi PT. BTU agar mengirim program baru untuk menggantikan yang ada.</span></div></td></tr>' .
                '</tbody></table></div>' .
                '<div class="mt-4 p-3 bg-blue-50 text-blue-900 border border-blue-100 rounded-lg text-xs">' .
                '<strong>NOTE:</strong> Ketika Lift Column tidak bekerja, bagian pemeliharaan harus menemukan penyebabnya. Saat penyebab telah ditemukan, perbaiki. Jika tidak ditemukan adanya kerusakan pada struktur, prosedur yang telah ada pada section 3.5 (Setting Prosedur untuk Lift Column), Bab ini harus diikuti agar Lift Column kembali pada posisi yang benar.' .
                '</div>' .
                '</div>' .
                '</div>',
            'order' => $order++,
        ]);
    }
}
