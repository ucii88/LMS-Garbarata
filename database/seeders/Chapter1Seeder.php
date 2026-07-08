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

        $module1_1 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '1.1 Rotunda',
            'image_path' => 'images/modules/rotunda.png',
            'content' => '<p><strong>Komponen utama Garbarata terdiri dari :</p></strong> <p><strong>Rotunda</strong> dirancang sebagai pusat sumbu untuk gerakan vertikal dan horizontal Garbarata. Selama pengoperasian, column rotunda, lantai, langit-langit dan panel dinding koridor yang berbatasan dengan terminal tidak bergerak (statis), sedangkan rotunda rigid frame dan atap akan berputar menyesuaikan pergerakan column. Rotunda terdiri dari:</p><ul class="space-y-4"><li><strong>a) Rotunda Corridor</strong><br>Rotunda Corridor adalah penghubung antara rotunda dan gedung terminal. Rotunda Corridor dirancang menggunakan weather seal yang fleksibel dan pijakan lantai dengan sambungan engsel dari rotunda terhadap gedung terminal sehingga tidak ada beban maupun getaran dari Garbarata yang di salurkan ke fixed link.</li><li><strong>b) Rotunda Support Column</strong><br>Rotunda Support Column adalah penyangga statis Garbarata. Rotunda Support column bertumpu pada pondasi dengan delapan anchor bolt yang masing-masing dilengkapi dengan 3 mur.</li><li><strong>c) Main Distribution Panel</strong><br>Electrical panel dipasang pada rotunda support column yang dilengkapi dengan circuit breaker dan transformer yang dibutuhkan untuk mengubah dan menyesuaikan kebutuhan arus listrik yang di supply dari gedung tenninal untuk kebutuhan listrik di Garbarata.</li><li><strong>d) Aluminum Side Curtains</strong><br>Aluminum side curtain dipasang pada kedua sisi Rotunda yang menggulung pada sebuah kumparan disetiap sisinya serta dapat mengikuti gerakan putaran rotunda. Kedua kumparan mempunyai pegas yang terpasang disepanjang sumbu untuk memberikan tegangan pada curtain dan menjaganya tetap kencang dan rapat.</li><li><strong>e) Rotunda Swing Limit Switches</strong><br>Limit switch dipasang pada rigid frame yang berputar di bagian bawah rotunda, dan cam dipasang pada flange rotunda yang statis/tidak berputar.</li></ul>',
            'order' => 1,
        ]);

        $module1_2 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '1.2 Telescopic Tunnel',
            'image_path' => 'images/modules/telescoping_tunnels.png',
            'content' => '<p>Dimulai dari arah rotunda, tunnel-tunnel dinamakan dengan tunnel A, B dan C untuk Garbarata 3 tunnel (A dan B untuk Garbarata 2 tunnel). Telescoping tunnel berbentuk persegi empat, dengan ukuran tunnel paling besar yang dekat dengan pesawat.</p><p>Semua tunnel terbuat dari plat berombak dengan flange penyangga. Lubang-lubang dibor pada atap flange sehingga air dapat mengalir kebawah. Saluran air di buat pada tiap sisi lantai Garbarata, sebelah dalam Tunnel B dan C.</p><ul class="space-y-4"><li><strong>a) Rails and Roller Bearings</strong><br>Rel untuk roller track dibuat pada tiap sisi agar Garbarata dapat bergerak maju dan mundur dengan lancar. Semua tunnel memiliki track roller di atas dan bawah. Sebuah stopper dilas pada jalur roller bagian bawah tunnel B untuk mencegah roller keluar dari ujung tracknya.</li><li><strong>b) Rotunda Guide Rollers</strong><br>Tunnel guide roller dipasang pada sisi kiri dan kanan rotunda, fungsi utama dari guide roller ini adalah untuk mempertahankan jarak dan posisi antara tunnel dengan rigid frame sewaktu Garbarata bergerak naik, turun dan berputar (kekiri dan kanan).</li><li><strong>c) Cable Scissors</strong><br>Cable scissor terpasang dibawah tunnel, memegang dan membawa kabel power dan kabel control agar tetap terkoneksi sewaktu Garbarata memanjang dan memendek. Cable scissor dikaitkan antara bagian belakang tunnel A ke bagian belakang tunnel B.</li><li><strong>d) Ramps</strong><br>Pada bagian telescoping tunnel yang saling bersinggungan antara tunnel A dan B, terdapat sebuah jembatan transisi (ramp) dan juga antara tunnel B dan C yang digunakan untuk mengatasi perbedaan ketinggian pada lantai tunnel. Ramp ini terpasang dengan tunnel menggunakan engsel. Handrail dipasang disebelah kanan dan kiri.</li><li><strong>e) Glass Wall Panel</strong><br>Sepanjang dinding tunnel terpasang kaca berwarna. Dinding kaca terpasang dengan floating system sehingga tak ada tekanan ataupun beban yang membebani dinding kaca tersebut.</li><li><strong>f) Roof Safety Hand Rail</strong><br>Roof safety hand rail dipasang pada bagian roof yang berfungsi sebagai pengaman bagi kru Bandara yang sedang bekerja di roof Garbarata.</li></ul>',
            'order' => 2,
        ]);

        $module1_3 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '1.3 Cabin',
            'image_path' => 'images/modules/cabin.png',
            'content' => '<p><strong>Kabin</strong> terbuat dari baja, bagian exterior dilapisi dengan cat dasar epoxy dan bagian interior dengan penutup lantai, langit-langit dan penerangan. Motor listrik dipasang di bagian bawah cabin berfungsi untuk memutar kabin. Pada cabin juga terdapat side curtain, double swing door, dan control console.</p><ul class="space-y-4"><li><strong>a) Double Swing Door</strong><br>Sebuah double swing door terpasang pada cabin, ketika ditutup double swing door tersebut dapat melindungi interior dan operator dari kondisi diluar dan sekitarnya pada saat Garbarata sedang tidak digunakan.</li><li><strong>b) Closure</strong><br>Ketika Garbarata melakukan docking dengan pesawat, closure menutupi celah-celah antara cabin dengan pesawat. Closure berbentuk lipatan-lipatan dan terbuat dari bahan tahan cuaca. Limit switch pressure-sensitive di kedua sisinya mencegah closure menekan badan pesawat yang berlebihan.</li><li><strong>c) Side Curtains</strong><br>Curtain terbuat dari alumunium dan seperti halnya rotunda, curtain memiliki sisi kanan dan kiri, yang dapat menggulung pada sebuah kumparan mengikuti cabin saat rotasi. Kedua kumparan mempunyai pegas yang terpasang sepanjang sumbu untuk memberikan tegangan pada curtain, menjaganya tetap tegang dan rapat.</li><li><strong>d) Control Console</strong><br>Pada Control panel terdapat semua kontrol yang diperlukan untuk mengoperasikan Garbarata. Kontrol-kontrol ini akan dijelaskan pada bab lain yang membahas kontrol operasi.</li><li><strong>e) Safety Door Shoe</strong><br>Safety Door Shoe merupakan back up sensor garbarata ketika autolevel tidak dapat mendeteksi perubahan ketinggian. Safety door shoe wajib diposisikan di bawah pintu pesawat saat proses docking.</li></ul>',
            'order' => 3,
        ]);

        $module1_4 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '1.4 Wheel Boogie',
            'image_path' => 'images/modules/wheel_boogie.png',
            'content' => '<p><strong>Wheel Boogie</strong> terdiri dari frame, ban, drive chain, motor listrik, kotak limit switch, landing gear (optional) dan kabel-kabel listrik.</p><ul class="space-y-4"><li><strong>a) Wheels</strong><br>Dua solid tire terpasang pada frame. Trunion membantu mendistribusi beban yang ditahan pada setiap roda secara seimbang.</li><li><strong>b) Chains Drives</strong><br>Roda kanan dan kiri mempunyai dua rantai dengan duplex sprockets pada shaft motor dan roda. Chain guard melindungi pekerja di apron.</li><li><strong>c) Limit Switch</strong><br>Steering limit switch terpasang pada cross beam dibawah bogie. Jika bogie berputar ke kiri atau kanan, cam limit switch akan menyentuh limit switch pada batas akhir steering dan mengaktifkan warning buzzer di control console untuk menandakan oversteering.</li><li><strong>d) Motors and Brakes</strong><br>Setiap drive chain dihubungkan dengan gear motor. Motor 3 phase ini menggunakan rem electro-magnetic, yang melepaskan daya remnya bersamaan dengan diaktifkannya niotcfr tersebut. Rem tersebut juga dapat dilepaskan secara manual, ini dibutuhkan dalam keadaan darurat, jika Garbarata perlu di tarik/dipindah pada saat tidak ada daya listrik.</li><li><strong>e) Safety Hoop</strong><br>Safety hoop merupakan alat pengaman/ safety device yang berfungsi untuk mengantisipasi adanya benda atau personal yang berada dekat dengan wheel boogie. Safety hoop terbuat dari RHS dengan sisi penampang 1 inchi.</li></ul>',
            'order' => 4,
        ]);

        $module1_5 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '1.5 Service Access',
            'image_path' => 'images/modules/service_access.png',
            'content' => '<p>Pintu service door, platform dan tangga terletak pada sisi kanan dan kiri pada bagian depan tunnel. Service access ini memberi jalan dari apron ke Garbarata atau sebaliknya untuk ground crew.</p><ul class="space-y-4"><li><strong>a) Service Door</strong><br>Service door adalah sebuah pintu steel yang dilengkapi dengan jendela kaca, terbuka kearah luar platform.</li><li><strong>b) Platform</strong><br>Posisi ketinggian platform dibuat sama dengan lantai cabin. Lantai Platform terbuat dari aluminium bermotif checkered yang terpasang di atas frame baja galvanis dan dikelilingi oleh handrail baja galvanis. Sebuah lampu terpasang di atas service door untuk menerangi platform.</li><li><strong>c) Service Stair</strong><br>Tangga ini adalah tangga self-adjusting terpasang pada frame baja galvanis dan kedua sisi tangga ini terpasang handrail. Self-adjusting berarti tangga dapat menyesuaikan ketinggiannya menurut posisi naik turunnya Garbarata. Castor wheel menyangga service stair dan memungkinkan tangga mengikuti Garbarata beroperasi seputar apron.</li><li><strong>d) Roof Access Ladder</strong><br>Sebuah tangga yang digalvanis terpasang pada platform menuju atap tunnel sebagai akses untuk para kru maintenance.</li></ul>',
            'order' => 5,
        ]);

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
            'label' => 'Cabin',
            'x_percent' => 87.0,
            'y_percent' => 45.0,
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

         Module::create([
            'chapter_id' => $chapter->id,
            'title' => '2.1 Main-Distribution Panel',
            'content' => '
                <p>
                    Main-Distribution Panel diposisikan pada Rotunda Column Garbarata.
                    Fungsi utamanya adalah mentransfer dan membagi tenaga listrik dari bangunan bandara menuju Garbarata dengan aman.
                </p>

                <br>

                <p><strong>Komponen internal Main Power Panel sebagai berikut:</strong></p>

                <br>

                <p><strong>(a) Circuit Breaker (MCCB/ MCB/ ELCB)</strong></p>

                <p>
                    Circuit Breaker berfungsi melindungi tenaga dari bangunan bandara menuju Garbarata.
                    Circuit Breaker yang digunakan seperti MCCB, MCB dan ELCB untuk mengontrol tenaga
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
                    Ketika terjadi kegagalan, Contactor akan terbuka dan memutuskan semua tenaga listrik ke komponen tersebut.
                </p>

                <br>

                <p><strong>(c) Terminal Block (TB) dan Terminal Strip (TS)</strong></p>

                <p>
                    TB dan TS digunakan sebagai terminal kabel.
                </p>

                <br>

                <p><strong>(d) Relay (RL)</strong></p>

                <p>
                    Relay digunakan untuk mengontrol circuit menggunakan sinyal bertenaga rendah
                    atau dimana beberapa circuit yang harus dikontrol dengan satu sinyal.
                </p>

                <br>

                <p><strong>(e) Pilot Lamp (PL)</strong></p>

                <p>
                    Tiga lampu indicator sebagai indicator aliran tenaga listrik Garbarata.
                </p>
            ',
            'order' => 6,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '2.2 Distribution Power Panel',
            'content' => '
                <p>
                    Distribution Power Panel terdiri dari Transistor, inverter, magnetic contactor dan
                    circuit breaker. Semua posisi dan jenis komponen di dalam Distribution Power Panel
                    berbeda tergantung kebutuhan konsumen. Data detil spesifik ditampilkan pada gambar
                    As-Built.
                </p>

                <br>

                <p><strong>(a) Circuit Breaker (MCB/ MCCB/ ELCB)</strong></p>

                <p>
                    Circuit Breaker berfungsi melindungi tenaga dari bangunan bandara menuju Garbarata.
                    Circuit Breaker yang digunakan seperti MCCB. MCB dan ELCB untuk mengontrol tenaga
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
                            Magnetic contactor digunakan untuk menyambungkan tenaga dari
                            Lighting Power Breaker menuju lampu tunnel dan rotunda.
                            Sistem operasinya terdapat pada console desk di Cabin.
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
                    Garbarata menggunakan beberapa unit transistor Variable Speed Drive,
                    Inverter tersebut menggunakan tenaga melalui Main Contactor.
                </p>

                <br>

                <p><strong>(d) Thermal Overloads</strong></p>

                <p>
                    Thermal Overload berada pada Box Power Panel dan akan trip dan
                    menghentikan motor ketika komponen tersebut overload.
                    Circuit akan tetap terbuka sampai thermal overload di reset kembali.
                    Dan hal ini juga akan me reset contactor.
                </p>
            ',
            'order' => 7,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '2.3 Console Desk',
            'content' => '
                <p>
                    Garbarata dikendalikan dan dikontrol melalui Console Desk. Pada Console Desk
                    terdapat Control Interface (Tombol dan Touchscreen) dan Control Panel
                    (Relay, Fuse, dan PLC)
                </p>

                <br>

                <h4><strong>(a) Control Interface</strong></h4>

                <p>
                    Control interface diposisikan diatas Console Desk. Touchscreen menampilkan
                    kondisi Garbarata melalui beberapa indicator. Detil Operasi dijelaskan pada Bab tiga.
                </p>

                <br>

                <h4><strong>(b) Control Panel</strong></h4>

                <p>
                    Semua system operasi berada di dalam Control Panel dan diposisikan dibawah
                    Control Interface. Pusat kendali Garbarata berada pada bagian tersebut.
                </p>
            ',
            'order' => 8,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '2.4 Pencahayaan',
            'content' => '
                <h4><strong>(a) Pencahayaan Interior</strong></h4>

                <ul class="list-disc ml-6 mt-3 space-y-1">
                    <li>Lampu Tunnel</li>
                    <li>Lampu Rotunda</li>
                    <li>Lampu Cabin</li>
                </ul>

                <br>

                <h4><strong>(b) Pencahayaan Eksterior</strong></h4>

                <ul class="list-disc ml-6 mt-3 space-y-1">
                    <li>Lampu Landing Stair</li>
                    <li>Lampu Obstruction</li>
                    <li>Rotary Lamp</li>
                    <li>Flood light Tunnel Light</li>
                    <li>Cabin LED Light</li>
                    <li>Lampu Control Panel</li>
                    <li>Flood light cabin LED Light</li>
                    <li>Emergency LED Light</li>
                </ul>

                <br>

                <p>
                    Pusat kendali pencahayaan eksterior dan interior terletak pada
                    <strong>Console Desk</strong>.
                </p>
            ',
            'order' => 9,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '2.5 Safety Device / Sensor / Actuator',
            'content' => '
                <p>
                    Garbarata menggunakan motor listrik dan sistem mekanik yang dilengkapi
                    berbagai <strong>Safety Device</strong>, <strong>Sensor</strong>, dan
                    <strong>Actuator</strong> untuk menjamin keselamatan pengoperasian.
                    Berikut komponen-komponen yang terdapat pada setiap bagian Garbarata.
                </p>

                <br>

                <h4><strong>(a) Rotunda</strong></h4>

                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>Rotunda Limit Switch</li>
                    <li>Rotunda Proximity Sensor</li>
                    <li>Rotunda Encoder</li>
                    <li>Potentiometer</li>
                    <li>CCTV Camera</li>
                    <li>Camera Box</li>
                    <li>Camera Wiper</li>
                </ul>

                <br>

                <h4><strong>(b) Tunnel</strong></h4>

                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>Full Retract Limit Switch</li>
                    <li>Full Extend Limit Switch</li>
                    <li>Slow Down Limit Switch</li>
                    <li>Travel Sensor</li>
                    <li>Reset Sensor</li>
                </ul>

                <br>

                <h4><strong>(c) Cabin</strong></h4>

                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>Bumper Limit Switch</li>
                    <li>Horn / Bell</li>
                    <li>Safety Door Shoe</li>
                    <li>Photo Electric Switch</li>
                </ul>

                <br>

                <h4><strong>(d) Canopy</strong></h4>

                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>Canopy Retract Limit Switch</li>
                    <li>Canopy Extend Limit Switch</li>
                    <li>Canopy Over Pressure Switch</li>
                    <li>Canopy Motor Actuator</li>
                </ul>

                <br>

                <h4><strong>(e) Cabin Rotation</strong></h4>

                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>Cabin Rotation Limit Switch</li>
                    <li>Cabin Rotation Proximity Sensor</li>
                    <li>Cabin Rotation Motor</li>
                    <li>Cabin Floor Motor</li>
                </ul>

                <br>

                <h4><strong>(f) Auto Level</strong></h4>

                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>Auto Level Proximity Sensor</li>
                    <li>Wheel Sensor</li>
                    <li>Auto Level Motor Actuator</li>
                </ul>

                <br>

                <h4><strong>(g) Lift Column</strong></h4>

                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>Vertical Motor</li>
                    <li>Counter Sensor</li>
                    <li>Initial Limit Switch</li>
                    <li>Ultimate Limit Switch</li>
                </ul>

                <br>

                <h4><strong>(h) Wheel Bogie</strong></h4>

                <ul class="list-disc ml-6 mt-2 space-y-1">
                    <li>Steering Limit Switch</li>
                    <li>Encoder Rotation Sensor</li>
                    <li>Safety Hoop</li>
                    <li>Horizontal Drive Motor</li>
                    <li>Variable Speed Drive</li>
                </ul>
            ',
            'order' => 10,
        ]);
    }
}
