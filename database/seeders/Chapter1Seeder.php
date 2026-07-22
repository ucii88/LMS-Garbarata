<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Module;
use App\Models\Diagram;
use App\Models\Hotspot;
use Illuminate\Database\Seeder;

class Chapter1Seeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 1)->first();

        if (!$chapter) {
            return;
        }

        // 1.1 Rotunda
        $module1_1 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '1.1 Rotunda', 'en' => '1.1 Rotunda'],
            'image_path' => 'images/modules/rotunda.png',
            'content' => '
                <p><strong>Komponen utama Garbarata terdiri dari :</strong></p>

                <p>
                    <strong>Rotunda</strong> dirancang sebagai pusat sumbu untuk gerakan vertikal dan horizontal Garbarata.
                    Selama pengoperasian, column rotunda, lantai, langit-langit dan panel dinding koridor yang berbatasan
                    dengan terminal tidak bergerak (statis), sedangkan rotunda rigid frame dan atap akan berputar
                    menyesuaikan pergerakan column. Rotunda terdiri dari:
                </p>

                <ul class="space-y-4">
                    <li>
                        <strong>a) Rotunda Corridor</strong><br>

                        Rotunda Corridor adalah penghubung antara rotunda dan gedung terminal.
                        Rotunda Corridor dirancang menggunakan weather seal yang fleksibel dan pijakan lantai
                        dengan sambungan engsel dari rotunda terhadap gedung terminal sehingga tidak ada beban
                        maupun getaran dari Garbarata yang di salurkan ke fixed link.
                    </li>

                    <li>
                        <strong>b) Rotunda Support Column</strong><br>

                        Rotunda Support Column adalah penyangga statis Garbarata.
                        Rotunda Support column bertumpu pada pondasi dengan delapan anchor bolt
                        yang masing-masing dilengkapi dengan 3 mur.
                    </li>

                    <li>
                        <strong>c) Main Distribution Panel</strong><br>

                        Electrical panel dipasang pada rotunda support column yang dilengkapi
                        dengan circuit breaker dan transformer yang dibutuhkan untuk mengubah
                        dan menyesuaikan kebutuhan arus listrik yang di supply dari gedung tenninal
                        untuk kebutuhan listrik di Garbarata.
                    </li>

                    <li>
                        <strong>d) Aluminum Side Curtains</strong><br>

                        Aluminum side curtain dipasang pada kedua sisi Rotunda yang menggulung
                        pada sebuah kumparan disetiap sisinya serta dapat mengikuti gerakan putaran rotunda.
                        Kedua kumparan mempunyai pegas yang terpasang disepanjang sumbu untuk memberikan
                        tegangan pada curtain dan menjaganya tetap kencang dan rapat.
                    </li>

                    <li>
                        <strong>e) Rotunda Swing Limit Switches</strong><br>

                        Limit switch dipasang pada rigid frame yang berputar di bagian bawah rotunda,
                        dan cam dipasang pada flange rotunda yang statis/tidak berputar.
                    </li>
                </ul>
            ',
            'order' => 1,
        ]);

        $module1_2 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '1.2 Telescopic Tunnel', 'en' => '1.2 Telescopic Tunnel'],
            'image_path' => 'images/modules/telescoping_tunnels.png',
            'content' => '
                <p>
                    Dimulai dari arah rotunda, tunnel-tunnel dinamakan dengan tunnel A, B dan C
                    untuk Garbarata 3 tunnel (A dan B untuk Garbarata 2 tunnel). Telescoping tunnel
                    berbentuk persegi empat, dengan ukuran tunnel paling besar yang dekat dengan pesawat.
                </p>

                <p>
                    Semua tunnel terbuat dari plat berombak dengan flange penyangga. Lubang-lubang
                    dibor pada atap flange sehingga air dapat mengalir kebawah. Saluran air di buat
                    pada tiap sisi lantai Garbarata, sebelah dalam Tunnel B dan C.
                </p>

                <ul class="space-y-4">
                    <li>
                        <strong>a) Rails and Roller Bearings</strong><br>

                        Rel untuk roller track dibuat pada tiap sisi agar Garbarata dapat bergerak
                        maju dan mundur dengan lancar. Semua tunnel memiliki track roller di atas
                        dan bawah. Sebuah stopper dilas pada jalur roller bagian bawah tunnel B
                        untuk mencegah roller keluar dari ujung tracknya.
                    </li>

                    <li>
                        <strong>b) Rotunda Guide Rollers</strong><br>

                        Tunnel guide roller dipasang pada sisi kiri dan kanan rotunda, fungsi utama
                        dari guide roller ini adalah untuk mempertahankan jarak dan posisi antara
                        tunnel dengan rigid frame sewaktu Garbarata bergerak naik, turun dan
                        berputar (kekiri dan kanan).
                    </li>

                    <li>
                        <strong>c) Cable Scissors</strong><br>

                        Cable scissor terpasang dibawah tunnel, memegang dan membawa kabel power
                        dan kabel control agar tetap terkoneksi sewaktu Garbarata memanjang dan
                        memendek. Cable scissor dikaitkan antara bagian belakang tunnel A ke
                        bagian belakang tunnel B.
                    </li>

                    <li>
                        <strong>d) Ramps</strong><br>

                        Pada bagian telescoping tunnel yang saling bersinggungan antara tunnel A
                        dan B, terdapat sebuah jembatan transisi (ramp) dan juga antara tunnel B
                        dan C yang digunakan untuk mengatasi perbedaan ketinggian pada lantai
                        tunnel. Ramp ini terpasang dengan tunnel menggunakan engsel. Handrail
                        dipasang disebelah kanan dan kiri.
                    </li>

                    <li>
                        <strong>e) Glass Wall Panel</strong><br>

                        Sepanjang dinding tunnel terpasang kaca berwarna. Dinding kaca terpasang
                        dengan floating system sehingga tak ada tekanan ataupun beban yang
                        membebani dinding kaca tersebut.
                    </li>

                    <li>
                        <strong>f) Roof Safety Hand Rail</strong><br>

                        Roof safety hand rail dipasang pada bagian roof yang berfungsi sebagai
                        pengaman bagi kru Bandara yang sedang bekerja di roof Garbarata.
                    </li>
                </ul>
            ',
            'order' => 2,
        ]);

        // 1.3 Vertical Lift Column
        $module1_3 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '1.3 Vertical Lift Column', 'en' => '1.3 Vertical Lift Column'],
            'image_path' => null,
            'content' => '
                <p>
                    Vertical lift column terdiri dari ball screw dan nut yang terpasang didalam square steel tube.
                    Komponen lift column juga termasuk motor vertical drive, system penahan (brake),
                    tempat kabel (cable tray), dan limit switch.
                </p>

                <ul class="space-y-4">
                    <li>
                        <strong>a) Ball screws and nut assembly</strong><br>

                        Ball screw dan nut terdiri dari chain coupler, thrust bearing, top plate,
                        oil cup, wiper dan alat pengaman. Ball screw dan nut memiliki concave
                        helical ball race, membentuk alur yang tertutup dimana bola-bola bearing
                        berotasi beraturan dengan berputarnya screw. Jika motor menyala, ball nut
                        akan bergerak sepanjang sumbu dari screw, merubah gerakan putar dari screw
                        menjadi gerakan linear lurus dari nut.
                    </li>

                    <li>
                        <strong>b) Grease Nipple</strong><br>

                        Pelumasan ball screw dan nut dapat dilakukan melalui grease nipple yang
                        berada di bagian luar column bawah. Naikan lift column sampai posisi paling
                        tinggi, lalu pasang grease gun ke grease nipple. Mulai masukan grease/gemuk
                        sambil menurunkan lift column sampai posisi paling bawah. Ulangi proses
                        pemberian grease jika diperlukan.
                    </li>

                    <li>
                        <strong>c) Vertical Drive Motors and Brakes</strong><br>

                        Motor vertical drive ini menggunakan system electro-magnetic dan rem
                        spring-setting, yang dirancang untuk menghentikan dan menahan beban dengan
                        tepat. System rem terhubung langsung ke terminal-terminal motor sehingga
                        akan secara otomatis melepaskan rem ketika motor diaktifkan.
                    </li>

                    <li>
                        <strong>d) Cable tray assembly</strong><br>

                        Cable tray pada drive column memuat kabel-kabel dari wheel bogie.
                        Kabel dialirkan dari J-box di bawah tunnel C, melalui cable tray dan
                        berakhir di motor horizontal.
                    </li>

                    <li>
                        <strong>e) Height Indicator</strong><br>

                        Garbarata memiliki proximity switch terletak pada flange motor di bagian
                        atas drive column untuk mendeteksi banyaknya putaran ball screw. Sinyal ini
                        mengirim data secara digital ke control console yang kemudian diproses
                        untuk menunjukkan sejauh mana Garbarata sudah bergerak naik atau turun.
                    </li>
                </ul>
            ',
            'order' => 3,
        ]);

        // 1.4 Wheel Boogie
        $module1_4 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '1.4 Wheel Boogie', 'en' => '1.4 Wheel Boogie'],
            'image_path' => 'images/modules/wheel_boogie.png',
            'content' => '
                <p>
                    <strong>Wheel Boogie</strong> terdiri dari frame, ban, drive chain,
                    motor listrik, kotak limit switch, landing gear (optional) dan
                    kabel-kabel listrik.
                </p>

                <ul class="space-y-4">
                    <li>
                        <strong>a) Wheels</strong><br>

                        Dua solid tire terpasang pada frame. Trunion membantu mendistribusi
                        beban yang ditahan pada setiap roda secara seimbang.
                    </li>

                    <li>
                        <strong>b) Chains Drives</strong><br>

                        Roda kanan dan kiri mempunyai dua rantai dengan duplex sprockets
                        pada shaft motor dan roda. Chain guard melindungi pekerja di apron.
                    </li>

                    <li>
                        <strong>c) Limit Switch</strong><br>

                        Steering limit switch terpasang pada cross beam dibawah bogie.
                        Jika bogie berputar ke kiri atau kanan, cam limit switch akan
                        menyentuh limit switch pada batas akhir steering dan mengaktifkan
                        warning buzzer di control console untuk menandakan oversteering.
                    </li>

                    <li>
                        <strong>d) Motors and Brakes</strong><br>

                        Setiap drive chain dihubungkan dengan gear motor. Motor 3 phase
                        ini menggunakan rem electro-magnetic, yang melepaskan daya remnya
                        bersamaan dengan diaktifkannya motor tersebut. Rem tersebut juga
                        dapat dilepaskan secara manual, ini dibutuhkan dalam keadaan
                        darurat, jika Garbarata perlu di tarik/dipindah pada saat tidak
                        ada daya listrik.
                    </li>

                    <li>
                        <strong>e) Safety Hoop</strong><br>

                        Safety hoop merupakan alat pengaman/ safety device yang berfungsi
                        untuk mengantisipasi adanya benda atau personal yang berada dekat
                        dengan wheel boogie. Safety hoop terbuat dari RHS dengan sisi
                        penampang 1 inchi.
                    </li>
                </ul>
            ',
            'order' => 4,
        ]);

        // 1.5 Service Access
        $module1_5 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '1.5 Service Access', 'en' => '1.5 Service Access'],
            'image_path' => 'images/modules/service_access.png',
            'content' => '
                <p>
                    Pintu service door, platform dan tangga terletak pada sisi kanan dan kiri
                    pada bagian depan tunnel. Service access ini memberi jalan dari apron ke
                    Garbarata atau sebaliknya untuk ground crew.
                </p>

                <ul class="space-y-4">
                    <li>
                        <strong>a) Service Door</strong><br>

                        Service door adalah sebuah pintu steel yang dilengkapi dengan
                        jendela kaca, terbuka kearah luar platform.
                    </li>

                    <li>
                        <strong>b) Platform</strong><br>

                        Posisi ketinggian platform dibuat sama dengan lantai cabin.
                        Lantai Platform terbuat dari aluminium bermotif checkered yang
                        terpasang di atas frame baja galvanis dan dikelilingi oleh
                        handrail baja galvanis. Sebuah lampu terpasang di atas service
                        door untuk menerangi platform.
                    </li>

                    <li>
                        <strong>c) Service Stair</strong><br>

                        Tangga ini adalah tangga self-adjusting terpasang pada frame
                        baja galvanis dan kedua sisi tangga ini terpasang handrail.
                        Self-adjusting berarti tangga dapat menyesuaikan ketinggiannya
                        menurut posisi naik turunnya Garbarata. Castor wheel menyangga
                        service stair dan memungkinkan tangga mengikuti Garbarata
                        beroperasi seputar apron.
                    </li>

                    <li>
                        <strong>d) Roof Access Ladder</strong><br>

                        Sebuah tangga yang digalvanis terpasang pada platform menuju
                        atap tunnel sebagai akses untuk para kru maintenance.
                    </li>
                </ul>
            ',
            'order' => 5,
        ]);

        // 1.6 Cabin
        $module1_6 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '1.6 Cabin', 'en' => '1.6 Cabin'],
            'image_path' => 'images/modules/cabin.png',
            'content' => '
                <p>
                    <strong>Kabin</strong> terbuat dari baja, bagian exterior dilapisi
                    dengan cat dasar epoxy dan bagian interior dengan penutup lantai,
                    langit-langit dan penerangan. Motor listrik dipasang di bagian
                    bawah cabin berfungsi untuk memutar kabin. Pada cabin juga terdapat
                    side curtain, double swing door, dan control console.
                </p>

                <ul class="space-y-4">
                    <li>
                        <strong>a) Double Swing Door</strong><br>

                        Sebuah double swing door terpasang pada cabin, ketika ditutup
                        double swing door tersebut dapat melindungi interior dan operator
                        dari kondisi diluar dan sekitarnya pada saat Garbarata sedang
                        tidak digunakan.
                    </li>

                    <li>
                        <strong>b) Closure</strong><br>

                        Ketika Garbarata melakukan docking dengan pesawat, closure
                        menutupi celah-celah antara cabin dengan pesawat. Closure
                        berbentuk lipatan-lipatan dan terbuat dari bahan tahan cuaca.
                        Limit switch pressure-sensitive di kedua sisinya mencegah
                        closure menekan badan pesawat yang berlebihan.
                    </li>

                    <li>
                        <strong>c) Side Curtains</strong><br>

                        Curtain terbuat dari alumunium dan seperti halnya rotunda,
                        curtain memiliki sisi kanan dan kiri, yang dapat menggulung
                        pada sebuah kumparan mengikuti cabin saat rotasi. Kedua
                        kumparan mempunyai pegas yang terpasang sepanjang sumbu
                        untuk memberikan tegangan pada curtain, menjaganya tetap
                        tegang dan rapat.
                    </li>

                    <li>
                        <strong>d) Control Console</strong><br>

                        Pada Control panel terdapat semua kontrol yang diperlukan
                        untuk mengoperasikan Garbarata. Kontrol-kontrol ini akan
                        dijelaskan pada bab lain yang membahas kontrol operasi.
                    </li>

                    <li>
                        <strong>e) Safety Door Shoe</strong><br>

                        Safety Door Shoe merupakan back up sensor garbarata ketika
                        autolevel tidak dapat mendeteksi perubahan ketinggian.
                        Safety door shoe wajib diposisikan di bawah pintu pesawat
                        saat proses docking.
                    </li>
                </ul>
            ',
            'order' => 6,
        ]);

        // Diagram & Hotspots
        $diagram = Diagram::create([
            'chapter_id' => $chapter->id,
            'title' => 'Diagram Struktur Utama Garbarata',
            'image_path' => 'images/garbarata.png',
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module1_1->id,
            'label' => 'Rotunda',
            'x_percent' => 13.5,
            'y_percent' => 13.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module1_2->id,
            'label' => 'Telescopic Tunnel',
            'x_percent' => 25.0,
            'y_percent' => 20.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module1_3->id,
            'label' => 'Vertical Lift Column',
            'x_percent' => 74.8,
            'y_percent' => 67.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module1_4->id,
            'label' => 'Wheel Boogie',
            'x_percent' => 72.0,
            'y_percent' => 77.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module1_5->id,
            'label' => 'Service Access',
            'x_percent' => 76.5,
            'y_percent' => 57.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module1_6->id,
            'label' => 'Cabin',
            'x_percent' => 87.0,
            'y_percent' => 45.0,
        ]);

        // 2.1 Main-Distribution Panel
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '2.1 Main-Distribution Panel', 'en' => '2.1 Main Distribution Panel'],
            'content' => '
                <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                    <img src="/images/modules/main_distribution_panel.png"
                        class="mx-auto max-h-96 w-full object-contain rounded-lg"
                        alt="Main Distribution Panel">
                </figure>
                <p class="text-center text-sm text-gray-600 mb-6">
                    Main-Distribution Panel
                </p>
                <p>
                    Main-Distribution Panel diposisikan pada Rotunda Column Garbarata.
                    Fungsi utamanya adalah mentransfer dan membagi tenaga listrik
                    dari bangunan bandara menuju Garbarata dengan aman.
                </p>
                <br>
                <p><strong>Komponen internal Main Power Panel sebagai berikut:</strong></p>
                <br>
                <p><strong>(a) Circuit Breaker (MCCB/ MCB/ ELCB)</strong></p>
                <p>
                    Circuit Breaker berfungsi melindungi tenaga dari bangunan bandara
                    menuju Garbarata. Circuit Breaker yang digunakan seperti MCCB,
                    MCB dan ELCB untuk mengontrol tenaga
                </p>

                <ul class="list-disc ml-6 mt-2">
                    <li>Main Power Breaker untuk Main Distribution Panel</li>
                    <li>Main Power Breaker untuk Drive Power</li>
                    <li>Main Power Breaker untuk Lighting and Control System</li>
                    <li>Main Power Breaker untuk Air Conditioner System</li>
                    <li>Main Power Breaker untuk Rotunda Air Conditioner</li>
                    <li>dll (sesuai kebutuhan)</li>
                </ul>

                <br>

                <p><strong>(b) Contactor (C)</strong></p>

                <p>
                    Contactor menghubungkan tenaga listrik untuk beberapa komponen.
                    Ketika terjadi kegagalan, Contactor akan terbuka dan memutuskan
                    semua tenaga listrik ke komponen tersebut.
                </p>

                <br>

                <p><strong>(c) Terminal Block (TB) dan Terminal Strip (TS)</strong></p>

                <p>
                    TB dan TS digunakan sebagai terminal kabel.
                </p>

                <br>

                <p><strong>(d) Relay (RL)</strong></p>

                <p>
                    Relay digunakan untuk mengontrol circuit menggunakan sinyal
                    bertenaga rendah atau dimana beberapa circuit yang harus
                    dikontrol dengan satu sinyal.
                </p>

                <br>

                <p><strong>(e) Pilot Lamp (PL)</strong></p>

                <p>
                    Tiga lampu indicator sebagai indicator aliran tenaga listrik
                    Garbarata.
                </p>
            ',
            'order' => 7,
        ]);

        // 2.2 Distribution Power Panel
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '2.2 Distribution Power Panel', 'en' => '2.2 Distribution Power Panel'],
            'content' => '
                <p>
                    Distribution Power Panel terdiri dari Transistor, inverter,
                    magnetic contactor dan circuit breaker. Semua posisi dan jenis
                    komponen di dalam Distribution Power Panel berbeda tergantung
                    kebutuhan konsumen. Data detil spesifik ditampilkan pada gambar
                    As-Built.
                </p>

                <br>

                <p><strong>(a) Circuit Breaker (MCB/ MCCB/ ELCB)</strong></p>

                <p>
                    Circuit Breaker berfungsi melindungi tenaga dari bangunan bandara
                    menuju Garbarata. Circuit Breaker yang digunakan seperti MCCB.
                    MCB dan ELCB untuk mengontrol tenaga
                </p>

                <ol class="list-decimal ml-6 mt-2 space-y-1">
                    <li>Lighting Power Breaker</li>
                    <li>Control Power Breaker</li>
                    <li>Receptacle Power breaker</li>
                    <li>Horizontal Motor Breaker</li>
                    <li>Vertical Motor breaker</li>
                    <li>Cabin Motor breaker</li>
                    <li>Air Conditional Breaker</li>
                </ol>

                <br>

                <p><strong>(b) Contactor</strong></p>

                <ol class="list-decimal ml-6 mt-2 space-y-4">
                    <li>
                        <strong>Lampu Tunnel dan rotunda main contactor</strong>

                        <p class="mt-2">
                            Magnetic contactor digunakan untuk menyambungkan tenaga
                            dari Lighting Power Breaker menuju lampu tunnel dan
                            rotunda. Sistem operasinya terdapat pada console desk
                            di Cabin.
                        </p>
                    </li>

                    <li>
                        <strong>Magnetic Contactor</strong>

                        <p class="mt-2">
                            Magnetic contactor membalikkan putaran motor CW/CCW
                            sesuai perintah PLC
                        </p>
                    </li>
                </ol>

                <br>

                <p><strong>(c) Variable Speed Drive</strong></p>

                <p>
                    Garbarata menggunakan beberapa unit transistor Variable Speed
                    Drive, Inverter tersebut menggunakan tenaga melalui Main
                    Contactor.
                </p>

                <br>

                <p><strong>(d) Thermal Overloads</strong></p>

                <p>
                    Thermal Overload berada pada Box Power Panel dan akan trip
                    dan menghentikan motor ketika komponen tersebut overload.
                    Circuit akan tetap terbuka sampai thermal overload di reset
                    kembali. Dan hal ini juga akan me reset contactor.
                </p>
            ',
            'order' => 8,
        ]);

        // 2.3 Console Desk
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '2.3 Console Desk', 'en' => '2.3 Console Desk'],
            'content' => '
                <p>
                    Garbarata dikendalikan dan dikontrol melalui Console Desk.
                    Pada Console Desk terdapat Control Interface (Tombol dan Touchscreen)
                    dan Control Panel (Relay, Fuse, dan PLC)
                </p>
                <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                    <img src="/images/modules/console_desk.png"
                        class="mx-auto max-h-96 w-full object-contain rounded-lg"
                        alt="Console Desk">
                </figure>
                <p class="text-center text-sm text-gray-600 mb-6">
                    Console Desk
                </p>

                <br>
                <h4><strong>(a) Control Interface</strong></h4>
                <p>
                    Control interface diposisikan diatas Console Desk.
                    Touchscreen menampilkan kondisi Garbarata melalui beberapa indicator.
                    Detil Operasi dijelaskan pada Bab tiga.
                </p>

                <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                    <img src="/images/modules/control_interface.png"
                        class="mx-auto max-h-96 w-full object-contain rounded-lg"
                        alt="Control Interface">
                </figure>
                <p class="text-center text-sm text-gray-600 mb-6">
                    Control Interface
                </p>
                <br>

                <h4><strong>(b) Control Panel</strong></h4>
                <p>
                    Semua system operasi berada di dalam Control Panel dan diposisikan
                    dibawah Control Interface. Pusat kendali Garbarata berada pada
                    bagian tersebut.
                </p>
            ',
            'order' => 9,
        ]);

        // 2.4 Pencahayaan
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '2.4 Pencahayaan', 'en' => '2.4 Lighting'],
            'content' => '
                <p><strong>a. Pencahayaan Interior</strong></p>
                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-black border-collapse text-sm">
                        <tbody>
                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Lampu Tunnel
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Lampu Rotunda
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Lampu Cabin
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p><strong>b. Pencahayaan Eksterior</strong></p>
                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-black border-collapse text-sm">
                        <tbody>
                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Lampu Landing Stair
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Lampu Obstruction
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Rotary Lamp
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Flood light Tunnel Light
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Cabin LED Light
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Lampu Control Panel
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Flood light cabin LED Light
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Emergency LED Light
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <p>
                    Pusat kendali pencahayaan eksterior dan interior terletak pada
                    <strong>Console Desk</strong>.
                </p>
            ',
            'order' => 10,
        ]);

        // 2.5 Safety Device / Sensor / Actuator
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => ['id' => '2.5 Safety Device / Sensor / Actuator', 'en' => '2.5 Safety Device / Sensor / Actuator'],
            'content' => '
                <p>
                    Garbarata menggunakan motor listrik dan sistem mekanik yang
                    dilengkapi berbagai <strong>Safety Device</strong>,
                    <strong>Sensor</strong>, dan <strong>Actuator</strong> untuk
                    menjamin keselamatan pengoperasian. Berikut komponen-komponen
                    yang terdapat pada setiap bagian Garbarata.
                </p>

                <p><strong>a. Rotunda</strong></p>

                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-gray-500 border-collapse text-sm">
                        <tbody>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2 w-1/2">
                                    Limit switch Initial Rotunda Left / Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk membatasi rotasi Rotunda secara horizontal
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Ultimate Rotunda Left / Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Slope Up/Down
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Membatasi perubahan ketinggian Garbarata
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Encoder Rotunda Rotation sensor
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Menentukan posisi angular Rotunda
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Potentiometer Rotunda Rotation Sensor
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Menentukan posisi angular rotunda
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Camera CCTV / Closed Circuit Television
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Memeriksa situasi apron
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Camera Box and Wiper
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Melindungi Kamera dari gangguan eksternal
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <p><strong>b. Tunnel (A/B/C)</strong></p>

                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-gray-500 border-collapse text-sm">
                        <tbody>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2 w-1/2">
                                    Limit switch Initial Full Retract &amp; Full Extend
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Membatasi perubahan panjang Garbarata
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Ultimate Full Retract &amp; Full Extend
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Slow down Tunnel Travel
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Memperlambat kecepatan Garbarata saat mendekati badan pesawat
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Travel Tunnel Sensor
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi perubahan panjang Garbarata
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Reset Travel Tunnel Sensor
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai kalibrator sensor
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <p><strong>c. Cabin</strong></p>

                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-gray-500 border-collapse text-sm">
                        <tbody>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2 w-1/2">
                                    Limit switch Bumper Limit
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk mendeteksi badan pesawat
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Horn/Bell
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai sinyal pertanda Garbarata sedang beroperasi
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Safety Door Shoe
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Backup jika autolevel tidak dapat bekerja
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Photo Electric Switch
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk mendeteksi posisi pesawat dan memperlambat kecepatan Garbarata
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <br>
                <p><strong>Canopy</strong></p>
                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-gray-500 border-collapse text-sm">
                        <tbody>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2 w-1/2">
                                    Limit switch Left Canopy Retract
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Membatasi gerakan canopy saat retract
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Right Canopy Retract
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Left Canopy Stop/Extend &amp; over Pressure
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Membatasi gerakan canopy jika kelebihan tekanan
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Right Canopy Stop/Extend &amp; over Pressure
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Actuator Motor Canopy R/L
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk menggerakkan canopy
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <p><strong>Cabin Rotation</strong></p>

                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-gray-500 border-collapse text-sm">
                        <tbody>
                            <tr>
                                <td class="border border-gray-500 px-4 py-2 w-1/2">
                                    Limit switch Initial Cabin Rotation Left &amp; Ultimate Cabin Rotation Left
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Membatasi gerakan rotasi kabin ke kiri
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Initial Cabin Rotation Right &amp; Ultimate Cabin Rotation Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Membatasi gerakan rotasi kabin ke kanan
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Cabin Rotation Sensor
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi posisi angular cabin
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Reset cabin rotation sensor
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai kalibrator sensor
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Actuator Motor Rotation Cabin
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk menggerakkan cabin
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Cabin Floor Up / Down
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi perubahan ketinggian cabin floor
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Actuator Motor Cabin Floor
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Menggerakkan cabin floor
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <p><strong>Autolevel</strong></p>

                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-gray-500 border-collapse text-sm">
                        <tbody>
                            <tr>
                                <td class="border border-gray-500 px-4 py-2 w-1/2">
                                    Proximity Ultimate Auto level Wheel Up/ Down
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk mendeteksi perubahan ketinggian pesawat
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Auto level Not Out
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi jika autolevel tidak keluar
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Auto level Not Contact
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi jika autolevel tidak berkontak dengan badan pesawat
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit Switch Auto level Wheel Up/Down
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi putaran wheel autolevel
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit Switch Actuator Motor Auto level Stop
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi autolevel jika sudah berkontak dengan pesawat
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Actuator Motor Auto level
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk menggerakkan autolevel
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <p><strong>d. Lift Column</strong></p>
                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-gray-500 border-collapse text-sm">
                        <tbody>
                            <tr>
                                <td class="border border-gray-500 px-4 py-2 w-1/2">
                                    Actuator Motor Vertical Column L/R
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Menggerakkan lift column
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Counter Column Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi ketinggian Garbarata
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Proximity Reset Counter Column Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai kalibrator sensor
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit Switch Column Fault Left
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi jika lift column unbalance
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit Switch Column Fault Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit Switch Initial Vertical Up/Down Left
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai sensor initial
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit Switch Initial Vertical Up/Down Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit Switch Ultimate Vertical Up/Down Left
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai ultimate sensor
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit Switch Ultimate Vertical Up/Down Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <p><strong>e. Wheel Boogie</strong></p>
                <div class="overflow-x-auto my-6">
                    <table class="w-full border border-gray-500 border-collapse text-sm">
                        <tbody>
                            <tr>
                                <td class="border border-gray-500 px-4 py-2 w-1/2">
                                    Limit switch Initial Steer Left
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai sensor inisial wheel boogie
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Initial Steer Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Ultimate Steer Right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai sensor ultimate wheel boogie
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Ultimate Steer Left
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Encoder Wheel Boogie Rotation Sensor
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Mendeteksi putaran wheel boogie
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Limit switch Safety Hoop
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Sebagai pelindung dan detector wheel boogie dari benda asing
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Actuator Motor Horizontal Drive L/R
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk menggerakkan wheel boogie
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-500 px-4 py-2">
                                    Inverter Variable speed drive Horizontal motor Left/right
                                </td>
                                <td class="border border-gray-500 px-4 py-2">
                                    Untuk mempercepat atau memperlambat wheel boogie
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            ',
            'order' => 11,
        ]);
    }
}
