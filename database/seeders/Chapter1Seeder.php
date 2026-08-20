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
        if (!$chapter) return;
        $module1 = $this->module($chapter->id, '1.1 Rotunda', [
                'id' => '1.1 Rotunda',
                'en' => '1.1 Rotunda',
            ], [
                'id' => '
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
                'en' => '<p><strong>The main components of Garbarata consist of:</strong></p><p>
                    <strong>Rotunda</strong>designed as the central axis for vertical and horizontal movement of Garbarata.
                    During operation, rotunda columns, floors, ceilings and corridor wall panels are abutted
                    with the terminal not moving (static), while the rotunda rigid frame and roof will rotate
                    adjust column movement. The rotunda consists of:
                </p><ul class="space-y-4">
                    <li>
                        <strong>a) Rotunda Corridor</strong><br>

                        The Rotunda Corridor is the link between the rotunda and the terminal building.
                        The Rotunda Corridor is designed using flexible weather seals and floor steps
                        with a hinge connection from the rotunda to the terminal building so that there is no load
                        as well as vibrations from the Garbarata which are channeled to the fixed link.
                    </li><li>
                        <strong>b) Rotunda Support Column</strong><br>

                        The Rotunda Support Column is a static support for the Garbarata.
                        Rotunda Support column rests on the foundation with eight anchor bolts
                        each of which is equipped with 3 nuts.
                    </li><li>
                        <strong>c) Main Distribution Panel</strong><br>

                        The electrical panel is installed on the equipped rotunda support column
                        with circuit breakers and transformers needed to change
                        and adjust the need for electric current supplied from the tenninal building
                        for electricity needs at Garbarata.
                    </li><li>
                        <strong>d) Aluminum Side Curtains</strong><br>

                        Aluminum side curtains are installed on both sides of the rolling Rotunda
                        on a coil on each side and can follow the rotational movement of the rotunda.
                        Both coils have springs attached along the axis to provide
                        tension on the curtain and keep it tight and tight.
                    </li><li>
                        <strong>e) Rotunda Swing Limit Switches</strong><br>

                        The limit switch is mounted on a rotating rigid frame at the bottom of the rotunda,
                        and the cam is installed on the static/non-rotating rotunda flange.
                    </li>
                </ul>
            ',
            ], 'images/modules/rotunda.png', 1);

        $module2 = $this->module($chapter->id, '1.2 Telescopic Tunnel', [
                'id' => '1.2 Telescopic Tunnel',
                'en' => '1.2 Telescopic Tunnel',
            ], [
                'id' => '
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
                'en' => '<p>
                    Starting from the rotunda, the tunnels are called tunnels A, B and C
                    for 3 tunnel Garbarata (A and B for 2 tunnel Garbarata). Telescoping tunnel
                    rectangular in shape, with the largest tunnel size being close to the plane.
                </p><p>
                    All tunnels are made of corrugated plate with supporting flanges. Holes
                    Drilled into the roof flange so water can flow down. Water channels are made
                    on each side of the Garbarata floor, inside Tunnels B and C.
                </p><ul class="space-y-4">
                    <li>
                        <strong>a) Rails and Roller Bearings</strong><br>

                        Rails for the roller track are made on each side so that the Garbarata can move
                        forward and backward smoothly. All tunnels have roller tracks at the top
                        and bottom. A stopper is welded to the lower roller track of tunnel B
                        to prevent the roller from coming off the end of the track.
                    </li><li>
                        <strong>b) Rotunda Guide Rollers</strong><br>

                        Tunnel guide rollers are installed on the left and right sides of the rotunda, the main function
                        The purpose of this guide roller is to maintain the distance and position between
                        tunnel with a rigid frame when the Garbarata moves up, down and
                        rotating (left and right).
                    </li><li>
                        <strong>c) Cable Scissors</strong><br>

                        Cable scissors are installed under the tunnel, holding and carrying the power cable
                        and control cables to remain connected while the Garbarata extends and
                        shortened. The scissor cable is connected between the back of tunnel A to
                        rear of tunnel B.
                    </li><li>
                        <strong>d) Ramps</strong><br>

                        In the telescoping tunnel section that intersects tunnel A
                        and B, there is a transition bridge (ramp) and also between tunnel B
                        and C which is used to overcome height differences on the floor
                        tunnels. This ramp is attached to the tunnel using hinges. Handrails
                        installed on the right and left.
                    </li><li>
                        <strong>e) Glass Wall Panels</strong><br>

                        Colored glass is installed along the tunnel walls. Glass walls installed
                        with a floating system so there is no pressure or load
                        weighing down the glass walls.
                    </li><li>
                        <strong>f) Roof Safety Hand Rail</strong><br>

                        Roof safety hand rail is installed on the roof which functions as
                        safety for airport crew who are working on the Garbarata roof.
                    </li>
                </ul>
            ',
            ], 'images/modules/telescoping_tunnels.png', 2);

        $module3 = $this->module($chapter->id, '1.3 Vertical Lift Column', [
                'id' => '1.3 Vertical Lift Column',
                'en' => '1.3 Vertical Lift Column',
            ], [
                'id' => '
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
                'en' => '<p>
                    The vertical lift column consists of a ball screw and nut installed in a square steel tube.
                    Column lift components also include a vertical drive motor, brake system,
                    cable tray, and limit switch.
                </p><ul class="space-y-4">
                    <li>
                        <strong>a) Ball screws and nut assembly</strong><br>

                        The ball screw and nut consist of a chain coupler, thrust bearing, top plate,
                        oil cup, wiper and safety device. Ball screws and nuts have concave
                        helical ball race, forms a closed groove where the bearing balls
                        rotates uniformly with the rotation of the screw. If the motor is running, the ball nut
                        will move along the axis of the screw, changing the rotational motion of the screw
                        be a straight linear movement of the nut.
                    </li><li>
                        <strong>b) Grease Nipple</strong><br>

                        Lubrication of the ball screw and nut can be done via the grease nipple
                        is on the outside of the bottom column. Raise the lift column to the highest position
                        high, then attach the grease gun to the grease nipple. Start adding grease
                        while lowering the lift column to the lowest position. Repeat process
                        applying grease if necessary.
                    </li><li>
                        <strong>c) Vertical Drive Motors and Brakes</strong><br>

                        This vertical drive motor uses an electro-magnetic system and brakes
                        spring-setting, which is designed to stop and hold a load with
                        right. The brake system is connected directly to the motor terminals so that
                        will automatically release the brake when the motor is activated.
                    </li><li>
                        <strong>d) Cable tray assembly</strong><br>

                        The cable tray on the drive column contains the cables from the wheel bogie.
                        The cable is routed from the J-box under tunnel C, through the cable tray and
                        ends in a horizontal motor.
                    </li><li>
                        <strong>e) Height Indicator</strong><br>

                        The bridge has a proximity switch located on the motor flange on the side
                        on the drive column to detect the number of rotations of the ball screw. This signal
                        sends data digitally to the control console which is then processed
                        to show how far the Garbarata has moved up or down.
                    </li>
                </ul>
            ',
            ], '', 3);

        $module4 = $this->module($chapter->id, '1.4 Wheel Boogie', [
                'id' => '1.4 Wheel Boogie',
                'en' => '1.4 Wheel Boogie',
            ], [
                'id' => '
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
                'en' => '<p>
                    <strong>Wheel Boogie</strong>consists of frame, tires, drive chain,
                    electric motor, limit switch box, landing gear (optional) and
                    electrical cables.
                </p><ul class="space-y-4">
                    <li>
                        <strong>a) Wheels</strong><br>

                        Two solid tires are installed on the frame. Trunions help distribute
                        The load held on each wheel is balanced.
                    </li><li>
                        <strong>b) Chains Drives</strong><br>

                        The right and left wheels have two chains with duplex sprockets
                        on the motor shaft and wheels. Chain guard protects workers on the apron.
                    </li><li>
                        <strong>c) Limit Switch</strong><br>

                        The steering limit switch is installed on the cross beam below the bogie.
                        If the bogie turns left or right, the cam limit switch will
                        Touch the limit switch at the end of the steering limit and activate it
                        warning buzzer on the control console to indicate oversteering.
                    </li><li>
                        <strong>d) Motors and Brakes</strong><br>

                        Each drive chain is connected to a motor gear. 3 phase motor
                        It uses electro-magnetic brakes, which release braking power
                        at the same time as the motor is activated. Those brakes too
                        can be released manually, this is required in the circumstances
                        emergency, if the Garbarata needs to be towed/moved when it is not
                        there is electric power.
                    </li><li>
                        <strong>e) Safety Hoop</strong><br>

                        A safety hoop is a functional safety device
                        to anticipate the presence of objects or personal beings that are close by
                        with wheel boogie. Safety hoop made of RHS with sides
                        1 inch cross section.
                    </li>
                </ul>
            ',
            ], 'images/modules/wheel_boogie.png', 4);

        $module5 = $this->module($chapter->id, '1.5 Service Access', [
                'id' => '1.5 Service Access',
                'en' => '1.5 Service Access',
            ], [
                'id' => '
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
                'en' => '<p>
                    Service doors, platforms and stairs are located on the right and left sides
                    at the front of the tunnel. This service access provides a path from the apron to
                    Garbarata or vice versa for ground crew.
                </p><ul class="space-y-4">
                    <li>
                        <strong>a) Service Door</strong><br>

                        Service door is a steel door that is equipped with
                        glass window, opening towards the outside of the platform.
                    </li><li>
                        <strong>b) Platforms</strong><br>

                        The height of the platform is made the same as the cabin floor.
                        The platform floor is made of checkered patterned aluminum
                        mounted on a galvanized steel frame and surrounded by
                        galvanized steel handrail. A light is installed above the service
                        door to illuminate the platform.
                    </li><li>
                        <strong>c) Service Stairs</strong><br>

                        This ladder is a self-adjusting ladder mounted on a frame
                        galvanized steel and handrails are installed on both sides of the stairs.
                        Self-adjusting means the ladder can adjust its height
                        according to the position of the Garbarata up and down. Castor wheel supports
                        service stair and allows the stairs to follow the Garbarata
                        operates around the apron.
                    </li><li>
                        <strong>d) Roof Access Ladder</strong><br>

                        A galvanized ladder is attached to the leading platform
                        tunnel roof as access for maintenance crews.
                    </li>
                </ul>
            ',
            ], 'images/modules/service_access.png', 5);

        $module6 = $this->module($chapter->id, '1.6 Cabin', [
                'id' => '1.6 Cabin',
                'en' => '1.6 Cabin',
            ], [
                'id' => '
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
                'en' => '<p>
                    <strong>Cabin</strong>Made of steel, exterior coated
                    with epoxy base paint and interior parts with floor covering,
                    ceiling and lighting. The electric motor is installed in the section
                    The bottom of the cabin functions to rotate the cabin. There is also a cabin in the cabin
                    side curtain, double swing door, and control console.
                </p><ul class="space-y-4">
                    <li>
                        <strong>a) Double Swing Door</strong><br>

                        A double swing door is attached to the cabin, when closed
                        The double swing door can protect the interior and operator
                        from the conditions outside and around it when the Garbarata is in operation
                        not used.
                    </li><li>
                        <strong>b) Closure</strong><br>

                        When Garbarata docks with a plane, closure
                        cover the gaps between the cabin and the plane. Closure
                        shaped in folds and made of weather-resistant material.
                        Pressure-sensitive limit switches on both sides prevent
                        closure suppresses excessive fuselage.
                    </li><li>
                        <strong>c) Side Curtains</strong><br>

                        Curtain is made of aluminum and like the rotunda,
                        The curtain has a right and left side, which can roll up
                        on a coil following the cabin during rotation. Second
                        The coil has a spring attached along the axis
                        to provide tension on the curtain, keeping it steady
                        tense and tight.
                    </li><li>
                        <strong>d) Control Console</strong><br>

                        In the Control panel there are all the necessary controls
                        to operate the Garbarata. These controls will
                        explained in another chapter that discusses operational controls.
                    </li><li>
                        <strong>e) Safety Door Shoes</strong><br>

                        Safety Door Shoe is a back up sensor for the bridge when
                        autolevel cannot detect changes in altitude.
                        Safety door shoes must be positioned under the aircraft door
                        during the docking process.
                    </li>
                </ul>
            ',
            ], 'images/modules/cabin.png', 6);

        $module7 = $this->module($chapter->id, '2.1 Main-Distribution Panel', [
                'id' => '2.1 Main-Distribution Panel',
                'en' => '2.1 Main-Distribution Panel',
            ], [
                'id' => '
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
                'en' => '<figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                    <img src="/images/modules/main_distribution_panel.png"
                        class="mx-auto max-h-96 w-full object-contain rounded-lg"
                        alt="Main Distribution Panel">
                </figure>
                <p class="text-center text-sm text-gray-600 mb-6">
                    Main-Distribution Panel
                </p><p>
                    The Main-Distribution Panel is positioned on the Rotunda Column of the Garbarata.
                    Its main function is to transfer and share electrical power
                    from the airport building to the Garbarata safely.
                </p><br>
                <p><strong>The internal components of the Main Power Panel are as follows:</strong></p><br>
                <p><strong>(a) Circuit Breaker (MCCB/ MCB/ ELCB)</strong></p><p>
                    Circuit Breaker functions to protect energy from airport buildings
                    towards Garbarata. Circuit Breakers used such as MCCB,
                    MCB and ELCB to control power
                </p><ul class="list-disc ml-6 mt-2">
                    <li>Main Power Breaker for Main Distribution Panel</li><li>Main Power Breaker for Drive Power</li><li>Main Power Breaker for Lighting and Control System</li><li>Main Power Breaker for Air Conditioner System</li><li>Main Power Breaker for Rotunda Air Conditioner</li><li>etc (as needed)</li></ul>

                <br>

                <p><strong>(b) Contactor (C)</strong></p><p>
                    Contactors connect electrical power to several components.
                    When a failure occurs, the Contactor will open and disconnect
                    all electrical power to the component.
                </p><br>

                <p><strong>(c) Terminal Block (TB) and Terminal Strip (TS)</strong></p><p>
                    TB and TS are used as cable terminals.
                </p><br>

                <p><strong>(d) Relay (RL)</strong></p><p>
                    Relays are used to control circuits using signals
                    low powered or where multiple circuits are required
                    controlled with a single signal.
                </p><br>

                <p><strong>(e) Pilot Lamp (PL)</strong></p><p>
                    Three indicator lights as indicators of electric power flow
                    Garbarata.
                </p>
            ',
            ], '', 7);

        $module8 = $this->module($chapter->id, '2.2 Distribution Power Panel', [
                'id' => '2.2 Distribution Power Panel',
                'en' => '2.2 Distribution Power Panel',
            ], [
                'id' => '
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
                'en' => '<p>
                    The Distribution Power Panel consists of transistors, inverters,
                    magnetic contactor and circuit breaker. All positions and types
                    The components in the Distribution Power Panel differ depending
                    consumer needs. Specific detailed data is shown in the figure
                    As-Built.
                </p><br>

                <p><strong>(a) Circuit Breaker (MCB/ MCCB/ ELCB)</strong></p><p>
                    Circuit Breaker functions to protect energy from airport buildings
                    towards Garbarata. The Circuit Breaker used is like an MCCB.
                    MCB and ELCB to control power
                </p><ol class="list-decimal ml-6 mt-2 space-y-1">
                    <li>Lighting Power Breaker</li><li>Control Power Breaker</li><li>Receptacle Power breaker</li><li>Horizontal Motor Breaker</li><li>Vertical Motor breaker</li><li>Cabin Motor breaker</li><li>Air Conditional Breaker</li></ol>

                <br>

                <p><strong>(b) Contactor</strong></p><ol class="list-decimal ml-6 mt-2 space-y-4">
                    <li>
                        <strong>Tunnel lights and rotunda main contactor</strong><p class="mt-2">
                            Magnetic contactors are used to connect power
                            from the Lighting Power Breaker to the tunnel lights and
                            rotunda. The operating system is on the console desk
                            in the Cabin.
                        </p>
                    </li><li>
                        <strong>Magnetic Contactor</strong><p class="mt-2">
                            Magnetic contactor reverses CW/CCW motor rotation
                            according to PLC commands
                        </p>
                    </li></ol>

                <br>

                <p><strong>(c) Variable Speed Drive</strong></p><p>
                    Garbarata uses several Variable Speed transistor units
                    Drive, the inverter uses power through Main
                    Contactor.
                </p><br>

                <p><strong>(d) Thermal Overloads</strong></p><p>
                    Thermal Overload is on the Power Panel Box and will trip
                    and stops the motor when the component is overloaded.
                    The circuit will remain open until the thermal overload is reset
                    back. And this will also reset the contactor.
                </p>
            ',
            ], '', 8);

        $module9 = $this->module($chapter->id, '2.3 Console Desk', [
                'id' => '2.3 Console Desk',
                'en' => '2.3 Console Desk',
            ], [
                'id' => '
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
                'en' => '<p>
                    The bridge is managed and controlled via the Console Desk.
                    On the Console Desk there is a Control Interface (Buttons and Touchscreen)
                    and Control Panel (Relay, Fuse, and PLC)
                </p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                    <img src="/images/modules/console_desk.png"
                        class="mx-auto max-h-96 w-full object-contain rounded-lg"
                        alt="Console Desk">
                </figure>
                <p class="text-center text-sm text-gray-600 mb-6">
                    Console Desk
                </p><br>
                <h4><strong>(a) Control Interface</strong></h4><p>
                    The control interface is positioned above the Console Desk.
                    The touchscreen displays the condition of the Garbarata via several indicators.
                    Operation details are explained in Chapter three.
                </p><figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                    <img src="/images/modules/control_interface.png"
                        class="mx-auto max-h-96 w-full object-contain rounded-lg"
                        alt="Control Interface">
                </figure>
                <p class="text-center text-sm text-gray-600 mb-6">
                    Control Interface
                </p><br>

                <h4><strong>(b) Control Panel</strong></h4><p>
                    All operating systems are in the Control Panel and positioned
                    under Control Interface. Garbarata control center is located at
                    that part.
                </p>
            ',
            ], '', 9);

        $module10 = $this->module($chapter->id, '2.4 Pencahayaan', [
                'id' => '2.4 Pencahayaan',
                'en' => '2.4 Lighting',
            ], [
                'id' => '
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
                'en' => '<p><strong>a. Interior Lighting</strong></p><div class="overflow-x-auto my-6">
                    <table class="w-full border border-black border-collapse text-sm">
                        <tbody>
                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Tunnel Lights
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Rotunda Lights
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Cabin Lights
                                </td></tr>
                        </tbody>
                    </table>
                </div>

                <p><strong>b. Exterior Lighting</strong></p><div class="overflow-x-auto my-6">
                    <table class="w-full border border-black border-collapse text-sm">
                        <tbody>
                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Landing Stair Lights
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Obstruction Lights
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Rotary Lamp
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Flood light Tunnel Light
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Cabin LED Light
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Control Panel Lights
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Flood light cabin LED Light
                                </td></tr>

                            <tr>
                                <td class="border border-black px-4 py-2">
                                    Emergency LED Light
                                </td></tr>

                        </tbody>
                    </table>
                </div>
                <p>
                    The exterior and interior lighting control center is located at
                    <strong>Console Desk</strong>.
                </p>
            ',
            ], '', 10);

        $module11 = $this->module($chapter->id, '2.5 Safety Device / Sensor / Actuator', [
                'id' => '2.5 Safety Device / Sensor / Actuator',
                'en' => '2.5 Safety Device / Sensor / Actuator',
            ], [
                'id' => '<p>Garbarata menggunakan motor listrik dan sistem mekanik yang dilengkapi berbagai <strong>Safety Device</strong>, <strong>Sensor</strong>, dan <strong>Actuator</strong> untuk menjamin keselamatan pengoperasian. Berikut komponen-komponen yang terdapat pada setiap bagian Garbarata.</p>
<p><strong>a. Rotunda</strong></p>
<div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm" style="width: 100%; height: 176.375px;">
<tbody>
<tr style="height: 39.1944px;">
<td class="border border-gray-500 px-4 py-2 w-1/2" style="width: 43.1399%; height: 39.1944px;">Limit switch Initial Rotunda Left / Right</td>
<td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 39.1944px;">Untuk membatasi rotasi Rotunda secara horizontal</td>
</tr>
<tr style="height: 39.1944px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 39.1944px;">Limit switch Ultimate Rotunda Left / Right</td>
<td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 39.1944px;">Untuk membatasi rotasi Rotunda secara horizontal</td>
</tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Proximity Slope Up/Down</td>
<td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Membatasi perubahan ketinggian Garbarata</td>
</tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Encoder Rotunda Rotation sensor</td>
<td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Menentukan posisi angular Rotunda</td>
</tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Potentiometer Rotunda Rotation Sensor</td>
<td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Menentukan posisi angular Rotunda</td>
</tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Camera CCTV / Closed Circuit Television</td>
<td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Memeriksa situasi apron&nbsp;</td>
</tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Camera Box and Wiper</td>
<td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Melindungi Kamera dari gangguan eksternal</td>
</tr>
</tbody>
</table>
</div>
<p><strong>b. Tunnel (A/B/C)</strong></p>
<div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Limit switch Initial Full Retract &amp; Full Extend</td>
<td class="border border-gray-500 px-4 py-2">Membatasi perubahan panjang Garbarata</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Ultimate Full Retract &amp; Full Extend</td>
<td class="border border-gray-500 px-4 py-2">Membatasi perubahan panjang Garbarata</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Slow down Tunnel Travel</td>
<td class="border border-gray-500 px-4 py-2">Memperlambat kecepatan Garbarata saat mendekati badan pesawat</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Travel Tunnel Sensor</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi perubahan panjang Garbarata</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Reset Travel Tunnel Sensor</td>
<td class="border border-gray-500 px-4 py-2">Sebagai kalibrator sensor</td>
</tr>
</tbody>
</table>
</div>
<p><strong>c. Cabin</strong></p>
<div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Limit switch Bumper Limit</td>
<td class="border border-gray-500 px-4 py-2">Untuk mendeteksi badan pesawat</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Horn/Bell</td>
<td class="border border-gray-500 px-4 py-2">Sebagai sinyal pertanda Garbarata sedang beroperasi</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Safety Door Shoe</td>
<td class="border border-gray-500 px-4 py-2">Backup jika autolevel tidak dapat bekerja</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Photo Electric Switch</td>
<td class="border border-gray-500 px-4 py-2">Untuk mendeteksi posisi pesawat dan memperlambat kecepatan Garbarata</td>
</tr>
</tbody>
</table>
</div>
<p>&nbsp;</p>
<p><strong>Canopy</strong></p>
<div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm" style="width: 100%; height: 137.18px;">
<tbody>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2 w-1/2" style="width: 49.2356%; height: 19.5972px;">Limit switch Left Canopy Retract</td>
<td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 19.5972px;">Membatasi gerakan canopy saat retract</td>
</tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 49.2356%; height: 19.5972px;">Limit switch Right Canopy Retract</td>
<td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 19.5972px;">Membatasi gerakan canopy saat retract</td>
</tr>
<tr style="height: 39.1944px;">
<td class="border border-gray-500 px-4 py-2" style="width: 49.2356%; height: 39.1944px;">Limit switch Left Canopy Stop/Extend &amp; over Pressure</td>
<td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 39.1944px;">Membatasi gerakan canopy jika kelebihan tekanan</td>
</tr>
<tr style="height: 39.1944px;">
<td class="border border-gray-500 px-4 py-2" style="width: 49.2356%; height: 39.1944px;">Limit switch Right Canopy Stop/Extend &amp; over Pressure</td>
<td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 39.1944px;">Membatasi gerakan canopy jika kelebihan tekanan</td>
</tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 49.2356%; height: 19.5972px;">Actuator Motor Canopy R/L</td>
<td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 19.5972px;">Untuk menggerakkan canopy</td>
</tr>
</tbody>
</table>
</div>
<p><strong>Cabin Rotation</strong></p>
<div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Limit switch Initial Cabin Rotation Left &amp; Ultimate Cabin Rotation Left</td>
<td class="border border-gray-500 px-4 py-2">Membatasi gerakan rotasi kabin ke kiri</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Initial Cabin Rotation Right &amp; Ultimate Cabin Rotation Right</td>
<td class="border border-gray-500 px-4 py-2">Membatasi gerakan rotasi kabin ke kanan</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Cabin Rotation Sensor</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi posisi angular cabin</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Reset cabin rotation sensor</td>
<td class="border border-gray-500 px-4 py-2">Sebagai kalibrator sensor</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Actuator Motor Rotation Cabin</td>
<td class="border border-gray-500 px-4 py-2">Untuk menggerakkan cabin</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Cabin Floor Up / Down</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi perubahan ketinggian cabin floor</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Actuator Motor Cabin Floor</td>
<td class="border border-gray-500 px-4 py-2">Menggerakkan cabin floor</td>
</tr>
</tbody>
</table>
</div>
<p><strong>Autolevel</strong></p>
<div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Proximity Ultimate Auto level Wheel Up/ Down</td>
<td class="border border-gray-500 px-4 py-2">Untuk mendeteksi perubahan ketinggian pesawat</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Auto level Not Out</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi jika autolevel tidak keluar</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Auto level Not Contact</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi jika autolevel tidak berkontak dengan badan pesawat</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Auto level Wheel Up/Down</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi putaran wheel autolevel</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Actuator Motor Auto level Stop</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi autolevel jika sudah berkontak dengan pesawat</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Actuator Motor Auto level</td>
<td class="border border-gray-500 px-4 py-2">Untuk menggerakkan autolevel</td>
</tr>
</tbody>
</table>
</div>
<p><strong>d. Lift Column</strong></p>
<div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Actuator Motor Vertical Column L/R</td>
<td class="border border-gray-500 px-4 py-2">Menggerakkan lift column</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Counter Column Right</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi ketinggian Garbarata</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Reset Counter Column Right</td>
<td class="border border-gray-500 px-4 py-2">Sebagai kalibrator sensor</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Column Fault Left</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi jika lift column unbalance</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Column Fault Right</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi jika lift column unbalance</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Initial Vertical Up/Down Left</td>
<td class="border border-gray-500 px-4 py-2">Sebagai sensor initial</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Initial Vertical Up/Down Right</td>
<td class="border border-gray-500 px-4 py-2">Sebagai sensor initial</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Ultimate Vertical Up/Down Left</td>
<td class="border border-gray-500 px-4 py-2">Sebagai ultimate sensor</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Ultimate Vertical Up/Down Right</td>
<td class="border border-gray-500 px-4 py-2">Sebagai ultimate sensor</td>
</tr>
</tbody>
</table>
</div>
<p><strong>e. Wheel Boogie</strong></p>
<div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Limit switch Initial Steer Left</td>
<td class="border border-gray-500 px-4 py-2">Sebagai sensor inisial wheel boogie</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Initial Steer Right</td>
<td class="border border-gray-500 px-4 py-2">Sebagai sensor inisial wheel boogie</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Ultimate Steer Right</td>
<td class="border border-gray-500 px-4 py-2">Sebagai sensor ultimate wheel boogie</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Ultimate Steer Left</td>
<td class="border border-gray-500 px-4 py-2">Sebagai sensor ultimate wheel boogie</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Encoder Wheel Boogie Rotation Sensor</td>
<td class="border border-gray-500 px-4 py-2">Mendeteksi putaran wheel boogie</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Safety Hoop</td>
<td class="border border-gray-500 px-4 py-2">Sebagai pelindung dan detector wheel boogie dari benda asing</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Actuator Motor Horizontal Drive L/R</td>
<td class="border border-gray-500 px-4 py-2">Untuk menggerakkan wheel boogie</td>
</tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Inverter Variable speed drive Horizontal motor Left/right</td>
<td class="border border-gray-500 px-4 py-2">Untuk mempercepat atau memperlambat wheel boogie</td>
</tr>
</tbody>
</table>
</div>',
                'en' => '<p>Garbarata uses electric motors and mechanical systems equipped with various <strong>Safety Devices</strong>, <strong>Censorship</strong>, and <strong>Actuator</strong>to ensure operational safety. The following are the components contained in each section of the Garbarata.</p><p><strong>a. Rotunda</strong>s</p><div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm" style="width: 100%; height: 176.375px;">
<tbody>
<tr style="height: 39.1944px;">
<td class="border border-gray-500 px-4 py-2 w-1/2" style="width: 43.1399%; height: 39.1944px;">Limit switch Initial Rotunda Left / Right</td><td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 39.1944px;">To limit the horizontal rotation of the Rotunda</td></tr>
<tr style="height: 39.1944px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 39.1944px;">Limit switch Ultimate Rotunda Left / Right</td><td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 39.1944px;">To limit the horizontal rotation of the Rotunda</td></tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Proximity Slope Up/Down</td><td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Limit changes in the height of the bridge</td></tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Encoder Rotunda Rotation sensor</td><td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Determining the angular position of the Rotunda</td></tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Rotunda Rotation Sensor Potentiometer</td><td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Determining the angular position of the Rotunda</td></tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">CCTV Camera / Closed Circuit Television</td><td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Checking the apron situation </td></tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 43.1399%; height: 19.5972px;">Camera Box and Wiper</td><td class="border border-gray-500 px-4 py-2" style="width: 51.9604%; height: 19.5972px;">Protects the Camera from external interference</td></tr>
</tbody>
</table>
</div>
<p><strong>b. Tunnel (A/B/C)</strong></p><div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Limit switch Initial Full Retract & Full Extend</td><td class="border border-gray-500 px-4 py-2">Limit changes to the length of the bridge</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Ultimate Full Retract & Full Extend</td><td class="border border-gray-500 px-4 py-2">Limit changes to the length of the bridge</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Slow down Tunnel Travel</td><td class="border border-gray-500 px-4 py-2">Slows down the speed of the Garbarata when approaching the fuselage</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Travel Tunnel Sensor</td><td class="border border-gray-500 px-4 py-2">Detecting changes in the length of the bridge</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Reset Travel Tunnel Sensor</td><td class="border border-gray-500 px-4 py-2">As sensor calibrator</td></tr>
</tbody>
</table>
</div>
<p><strong>c. Cabin</strong>s</p><div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Limit switch Bumper Limit</td><td class="border border-gray-500 px-4 py-2">To detect the fuselage</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Horn/Bell</td><td class="border border-gray-500 px-4 py-2">As a signal to indicate that Garbarata is in operation</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Safety Door Shoe</td><td class="border border-gray-500 px-4 py-2">Backup if autolevel doesn\'t work</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Photo Electric Switch</td><td class="border border-gray-500 px-4 py-2">To detect aircraft position and slow down Garbarata speed</td></tr>
</tbody>
</table>
</div>
<p></p><p><strong>Canopy</strong></p><div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm" style="width: 100%; height: 137.18px;">
<tbody>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2 w-1/2" style="width: 49.2356%; height: 19.5972px;">Limit switch Left Canopy Retract</td><td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 19.5972px;">Limits canopy movement when retracting</td></tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 49.2356%; height: 19.5972px;">Limit switch Right Canopy Retract</td><td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 19.5972px;">Limits canopy movement when retracting</td></tr>
<tr style="height: 39.1944px;">
<td class="border border-gray-500 px-4 py-2" style="width: 49.2356%; height: 39.1944px;">Limit switch Left Canopy Stop/Extend & over Pressure</td><td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 39.1944px;">Restricts canopy movement if excessive pressure occurs</td></tr>
<tr style="height: 39.1944px;">
<td class="border border-gray-500 px-4 py-2" style="width: 49.2356%; height: 39.1944px;">Limit switch Right Canopy Stop/Extend & over Pressure</td><td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 39.1944px;">Restricts canopy movement if excessive pressure occurs</td></tr>
<tr style="height: 19.5972px;">
<td class="border border-gray-500 px-4 py-2" style="width: 49.2356%; height: 19.5972px;">R/L Canopy Motor Actuator</td><td class="border border-gray-500 px-4 py-2" style="width: 45.8648%; height: 19.5972px;">To move the canopy</td></tr>
</tbody>
</table>
</div>
<p><strong>Cabin Rotation</strong></p><div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Limit switch Initial Cabin Rotation Left & Ultimate Cabin Rotation Left</td><td class="border border-gray-500 px-4 py-2">Restricts cabin rotation movement to the left</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Initial Cabin Rotation Right & Ultimate Cabin Rotation Right</td><td class="border border-gray-500 px-4 py-2">Restricts cabin rotation movement to the right</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Cabin Rotation Sensor</td><td class="border border-gray-500 px-4 py-2">Detecting angular cabin position</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Reset cabin rotation sensor</td><td class="border border-gray-500 px-4 py-2">As sensor calibrator</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Actuator Motor Rotation Cabin</td><td class="border border-gray-500 px-4 py-2">To move the cabin</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Cabin Floor Up / Down</td><td class="border border-gray-500 px-4 py-2">Detect changes in cabin floor height</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Cabin Floor Motor Actuator</td><td class="border border-gray-500 px-4 py-2">Moving cabin floor</td></tr>
</tbody>
</table>
</div>
<p><strong>Autolevel</strong></p><div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Proximity Ultimate Auto level Wheel Up/ Down</td><td class="border border-gray-500 px-4 py-2">To detect changes in aircraft altitude</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Auto level Not Out</td><td class="border border-gray-500 px-4 py-2">Detect if autolevel is not exiting</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Auto level Not Contact</td><td class="border border-gray-500 px-4 py-2">Detects if the autolevel is not in contact with the fuselage</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Auto level Wheel Up/Down</td><td class="border border-gray-500 px-4 py-2">Detecting autolevel wheel rotation</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Actuator Motor Auto level Stop</td><td class="border border-gray-500 px-4 py-2">Detects autolevel if it is in contact with the plane</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Actuator Motor Auto level</td><td class="border border-gray-500 px-4 py-2">To move autolevel</td></tr>
</tbody>
</table>
</div>
<p><strong>d. Column Elevator</strong>s</p><div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Vertical Column L/R Motor Actuator</td><td class="border border-gray-500 px-4 py-2">Move lift column</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Counter Column Right</td><td class="border border-gray-500 px-4 py-2">Detecting the height of the bridge</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Proximity Reset Counter Column Right</td><td class="border border-gray-500 px-4 py-2">As sensor calibrator</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Column Fault Left</td><td class="border border-gray-500 px-4 py-2">Detect if lift column is unbalanced</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Column Fault Right</td><td class="border border-gray-500 px-4 py-2">Detect if lift column is unbalanced</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Initial Vertical Up/Down Left</td><td class="border border-gray-500 px-4 py-2">As sensor initial</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Initial Vertical Up/Down Right</td><td class="border border-gray-500 px-4 py-2">As sensor initial</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Ultimate Vertical Up/Down Left</td><td class="border border-gray-500 px-4 py-2">As ultimate sensor</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit Switch Ultimate Vertical Up/Down Right</td><td class="border border-gray-500 px-4 py-2">As ultimate sensor</td></tr>
</tbody>
</table>
</div>
<p><strong>e. Wheel Boogie</strong></p><div class="overflow-x-auto my-6">
<table class="w-full border border-gray-500 border-collapse text-sm">
<tbody>
<tr>
<td class="border border-gray-500 px-4 py-2 w-1/2">Limit switch Initial Steer Left</td><td class="border border-gray-500 px-4 py-2">As wheel boogie initial sensor</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Initial Steer Right</td><td class="border border-gray-500 px-4 py-2">As wheel boogie initial sensor</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Ultimate Steer Right</td><td class="border border-gray-500 px-4 py-2">As ultimate wheel boogie sensor</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Ultimate Steer Left</td><td class="border border-gray-500 px-4 py-2">As ultimate wheel boogie sensor</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Encoder Wheel Boogie Rotation Sensor</td><td class="border border-gray-500 px-4 py-2">Detecting wheel boogie rotation</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Limit switch Safety Hoop</td><td class="border border-gray-500 px-4 py-2">As a protector and wheel boogie detector from foreign objects</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">L/R Horizontal Drive Motor Actuator</td><td class="border border-gray-500 px-4 py-2">To move the boogie wheel</td></tr>
<tr>
<td class="border border-gray-500 px-4 py-2">Inverter Variable speed drive Horizontal motor Left/right</td><td class="border border-gray-500 px-4 py-2">To speed up or slow down the wheel boogie</td>
</tr>
</tbody>
</table>
</div>',
            ], '', 11);

        $diagram = $this->diagram($chapter->id, 'Diagram Struktur Utama Garbarata', 'images/garbarata.png');

        $this->hotspot($diagram->id, $module1->id, 'Rotunda', 13.50, 13.00);
        $this->hotspot($diagram->id, $module2->id, 'Telescopic Tunnel', 25.00, 20.00);
        $this->hotspot($diagram->id, $module3->id, 'Vertical Lift Column', 74.80, 67.00);
        $this->hotspot($diagram->id, $module4->id, 'Wheel Boogie', 72.00, 77.00);
        $this->hotspot($diagram->id, $module5->id, 'Service Stair', 76.50, 57.00);
        $this->hotspot($diagram->id, $module6->id, 'Cabin and Control Unit', 87.00, 45.00);
    }

    private function module(int $chapterId, string $title, array $titleTranslations, array $contentTranslations, string $imagePath, int $order): Module
    {
        $modules = Module::where('chapter_id', $chapterId)->where('order', $order)->orderBy('id')->get();
        $module = $modules->shift() ?? new Module();
        $modules->each->delete();
        $module->fill(['chapter_id' => $chapterId, 'title' => $titleTranslations, 'content' => $contentTranslations, 'image_path' => $imagePath ?: null, 'order' => $order]);
        $module->save();
        return $module;
    }

    private function diagram(int $chapterId, string $title, string $imagePath): Diagram
    {
        $diagrams = Diagram::where('chapter_id', $chapterId)->orderBy('id')->get();
        $diagram = $diagrams->shift() ?? new Diagram();
        $diagrams->each->delete();
        $diagram->fill(['chapter_id' => $chapterId, 'title' => $title, 'image_path' => $imagePath]);
        $diagram->save();
        return $diagram;
    }

    private function hotspot(int $diagramId, int $moduleId, string $label, float $xPercent, float $yPercent): void
    {
        Hotspot::updateOrCreate(['diagram_id' => $diagramId, 'target_module_id' => $moduleId], ['label' => $label, 'x_percent' => $xPercent, 'y_percent' => $yPercent]);
    }
}