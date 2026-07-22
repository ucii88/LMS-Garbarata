<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Module;
use Illuminate\Database\Seeder;

class Chapter3Seeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 3)->first();

        if (!$chapter) {
            return;
        }

        Module::where('chapter_id', $chapter->id)->delete();

        $this->module($chapter->id, '1.1 Deskripsi Detail Pengoperasian', <<<'HTML'
            <p>
                Pengaturan untuk pengoperasian Garbarata terletak pada konsol kontrol di kabin yang merujuk pada layout face plate untuk beragam kontrol seperti indicator dan announciator. Berikut ini adalah gambaran dari beberapa kontrol penting :
            </p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/control_face_plate.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="Control Face Plate">
                <figcaption class="text-center mt-3 font-semibold">
                    Control Face Plate
                </figcaption>
            </figure>

            <p><strong>a. Telephone Socket</strong></p>

            <p>
                Soket untuk kabel telekomunikasi di posisiskan pada konsol desk.
            </p>

            <p><strong>b. Tombol Lampu</strong></p>

            <p>
                Tombol lampu untuk menyalakan lampu Garbarata. Baik yang interior,
                exterior, maupun obstruction Garbarata.
            </p>

            <p><strong>c. Tombol Emergency Stop</strong></p>

            <p>
                Tombol Emergency stop berada di control console dan wheel boogie
                berfungsi untuk menghentikan aliran listrik dari terminal ke Garbarata. Ketika
                tombol stop emergency ditekan saat manual dan auto mode, maka Garbarata
                berhenti beroperasi dan disertai bunyi klakson dan buzzer.
            </p>

            <p><strong>d. Tombol Power on dan off</strong></p>

            <div class="overflow-x-auto my-6">
                <table class="w-full border border-gray-500 border-collapse text-sm">
                    <tbody>
                        <tr class="border-b border-gray-500">
                            <td class="border border-gray-500 px-4 py-3 font-semibold w-1/4">
                                Tombol On
                            </td>
                            <td class="border border-gray-500 px-4 py-3">
                                Tombol power ON mengaktifkat semua power stand-by untuk semua kontrol motor dan lampu pada power indicator. Pastikan keyswitch pada posisi "OFF"
                            </td>
                        </tr>

                        <tr>
                            <td class="border border-gray-500 px-4 py-3 font-semibold">
                                Tombol Off
                            </td>
                            <td class="border border-gray-500 px-4 py-3">
                                <p>1. Setelah pengoperasian normal dan Garbarata kembali ke posisi yang telah ditentukan/parkir, tombol power off harus ditekan. Hal ini akan menghentikan energi/daya pada mesin, dan kontrol power.</p>

                                <p class="mt-3">2. Dalam keadaan darurat, tombol Stop Emergency harus ditekan secepatnya, hal ini akan mematikan semua listrik, kecuali lampu.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p><strong>e. Keyswitch</strong></p>

            <p>
                Terdapat tida posisi keyswitch yaitu off, manual dan auto
            </p>

            <div class="overflow-x-auto my-6">
                <table class="w-full border border-gray-500 border-collapse text-sm">
                    <tbody>

                        <tr class="border-b border-gray-500">
                            <td class="border border-gray-500 px-4 py-3 font-semibold w-1/4">
                                Off
                            </td>
                            <td class="border border-gray-500 px-4 py-3">
                                <ul class="list-disc pl-5">
                                    <li>Garbarata dalam keadaan stand by</li>
                                </ul>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-500">
                            <td class="border border-gray-500 px-4 py-3 font-semibold">
                                Manual
                            </td>
                            <td class="border border-gray-500 px-4 py-3">
                                <ul class="list-disc pl-5">
                                    <li>Lampu manual indicator akan menyala</li>
                                    <li>Seluruh komponen penggerak garbarata dapat digerakkan</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <td class="border border-gray-500 px-4 py-3 font-semibold">
                                Auto
                            </td>
                            <td class="border border-gray-500 px-4 py-3">
                                <ul class="list-disc pl-5">
                                    <li>Lampu auto akan menyala</li>
                                    <li>Seluruh pergerakkan manual akan mati</li>
                                </ul>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <p><strong>f. Canopy Left or Canopy Right</strong></p>

            <p>
                Dua tombol tipe dead man bekerja mengontrol kanopi kanan dan kiri untuk
                menyesuaikan posisi canopy terhadap Pesawat. Jika penutupan tidak benar,
                (lampu indikator CANOPY DOWN tetap menyala) Garbarata tidak bisa maju
                ke depan karena ada interlock.
            </p>

            <p><strong>g. Tombol Cabin Rotation</strong></p>

            <p>
                Dua tombol tipe dead man juga digunakan untuk mengatur gerakan putar
                kabin ke arah kanan atau kiri.
            </p>

            <p><strong>h. Tombol Cabin Floor</strong></p>

            <p>
                Garbarata dilengkapi dengan floor cabin yang dapat digerakkan sesuai
                kebutuhan ketinggian. Dua tombol cabin floor yang dapat di tinggikan atau
                diturunkan.
            </p>

            <p><strong>i. Tombol Gerakan Vertikal</strong></p>

            <p>
                Dua push buttons yaitu up dan down yang digunakan untuk meninggikan atau
                merendahkan Garbarata.
            </p>

            <p><strong>j. Horizontal Drive Control (Joystick)</strong></p>

            <p>
                Kontrol Joystick 4-quadrant pada Garbarata digunakan untuk menggerakkan
                ke arah depan, belakang, kanan, dan kiri. Joystick bersifat spring loaded yang
                akan kembali netral ketika dilepaskan. Selama joystick digerakkan ke arah
                depan, atau belakang, kecepatan Garbarata akan naik secara proporsional
                terhadap posisi joystick. Steering, kiri atau kanan bisa dilakukan berurutan
                dalam arah gerakan maju atau mundur.
            </p>

            <p><strong>k. Touch Screen Display Indicator</strong></p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/touchscreen_display.png"
                     class="mx-auto max-h-96 w-full object-contain rounded-lg"
                     alt="Touchscreen Display">
                <figcaption class="text-center mt-3 font-semibold">
                    Touchscreen Display
                </figcaption>
            </figure>

            <ol class="list-lower-roman pl-6 space-y-4">

                <li>
                    <strong>Manual on/off:</strong> Indikator Manual ‘ON’ menyala ketika posisi
                    keyswitch kontrol dalam mode manual untuk pengoperasian manual.
                    Sedangkan indicator MANUAL OFF menyala ketika posisi keyswitch dalam
                    posisi OFF atau AUTO.
                </li>

                <li>
                    <strong>Autolevel on/off:</strong> Dengan memutar keyswitch ke posisi auto akan
                    menghidupkan indicator autolevel dan autolevel akan keluar.
                </li>

                <li>
                    <strong>Safety shoe:</strong> Indikator ini akan menyala jika aktif dalam keadaan auto.
                </li>

                <li>
                    <strong>Maximum cabin rotation:</strong> Indikator ini menyala ketika kabin mencapai batas
                    putaran maximumnya.
                </li>

                <li>
                    <strong>Maximum travel:</strong> Indikator ini menyala ketika tunnel mencapai
                    pemanjangan maksimum horizontal atau travel limit pemendekan.
                </li>

                <li>
                    <strong>Vertical limit:</strong> Indikator ini menyala ketika tunnel mencapai travel limit
                    maksimal arah vertikal.
                </li>

                <li>
                    <strong>Maximum steering:</strong> Indikator ini menyala ketika wheel boogie mencapai
                    steering limit maksimalnya.
                </li>

                <li>
                    <strong>Maximum swing:</strong> Hal ini akan ditandai dengan lampu swing indikator
                    dan alarm akan berbunyi ketika rotunda menyentuh limit rotasinya.
                </li>

                <li>
                    <strong>Service warning:</strong> Service warning indicator akan menyala ketika ada
                    error/alarm pada Garbarata.
                </li>

                <li>
                    <strong>Autolevel warning:</strong> Indikator akan menyala ketika system autolevel
                    bekerja lebih dari 4 detik.
                </li>

                <li>
                    <strong>Bumper limit:</strong> Indikator ini akan menyala jika bumper bersentuhan
                    dengan badan pesawat.
                </li>

                <li>
                    <strong>Canopy down:</strong> Jika penarikan Canopy tidak benar-benar naik/retract
                    hal ini akan digambarkan dengan lampu indikator “CANOPY DOWN”.
                </li>

                <li>
                    <strong>Slow down:</strong> Indikator ini menyala ketika sensor scanner mendeteksi
                    badan pesawat sekitar 1 m dan/atau sebelum Garbarata benar-benar
                    memanjang atau memendek.
                </li>

                <li>
                    <strong>Column fault:</strong> Indikator ini menyala dan bel peringatan berbunyi ketika
                    lift column kanan dan kiri terpisah sekitar 70 mm.
                </li>

                <li>
                    <strong>Safety Hoop:</strong> Indikator akan menyala jika safety hoop bersinggungan
                    dengan benda asing.
                </li>

                <li>
                    <strong>Tunnel slope:</strong> Pada slope negatif ataupun positif, indikator akan
                    menyala ketika tunnel menyentuh Slope Limitnya.
                </li>

                <li>
                    <strong>Video monitoring system:</strong> Video monitor menampilkan total
                    gambaran wheel boogie. Operator dapat melihat ke arah mana wheel
                    diarahkan dan ke arah mana Garbarata akan bergerak dari posisi awalnya.
                </li>

            </ol>
        HTML, 1);

        $this->module($chapter->id, '2.1 Penggerak Horizontal', <<<'HTML'
            <p>
                Saat tombol POWER ON ditekan (dihidupkan) PLC akan aktif yang berfungsi
                mengatur seluruh tegangan serta kontrol pada seluruh komponen Garbarata.
                Dengan memutar keyswitch ke posisi manual akan mengalirkan tenaga ke seluruh
                komponen Garbarata termasuk salah satunya adalah penggerak horizontal.
            </p>

            <p>
                Garbarata merupakan mesin robotik yang mempunyai banyak sensor untuk
                mendeteksi setiap pergerakan. Seperti contoh saat Garbarata memendek
                maksimum, maka garbarata tidak akan bisa lagi dipendekkan, atau ketika
                garbarata dipanjangkan maksimum, maka Garbarata tidak akan dapat lagi
                diperpanjang. Saat garbarata bergerak secara horizontal, secara otomatis
                lampu rotary dan travel warning bell akan menyala sevagai warning bagi kru
                kru lain yang berada di sekitar Garbarata.
            </p>

            <p><strong>Garbarata dapat bergerak secara horizontal jika :</strong></p>

            <ol class="list-decimal pl-6">
                <li>Tidak terjadi perbedaan sudut slope Garbarata dengan floor pada rotunda</li>
                <li>Canopy dalam keadaan terlipat</li>
                <li>Vertical lift column tidak sedang aktif</li>
                <li>Safety hoop tidak terganjal benda asing</li>
                <li>Berada dalam rentang putaran horizontal maksimum</li>
                <li>Saat posisi Garbarata 2 meter dari badan pesawat, maka Garbarata secara otomatis akan bergerak lambat walaupun joystick diarahkan ke depan secara penuh.</li>
            </ol>

            <p class="mt-4"><strong>a) Bergerak Maju</strong></p>

            <p>
                Dengan menggerakkan joystick ke arah depan akan menggerakkan
                Garbarata ke arah depan, dan secara simultan akan mempercepat kecepatan
                Garbarata. Garbarata dapat digerakkan maju jika tidak berada dalam posisi
                panjang maksimum.
            </p>

            <p><strong>b) Bergerak mundur</strong></p>

            <p>
                Untuk gerakan mundur atau retract, arahkan joystick ke arah belakang /
                mundur dan secara simultan akan bertambah cepat. Garbarata tidak dapat
                digerakkan mundur jika tidak berada dalam kondisi pendek maksimum.
            </p>

            <p><strong>c) Bergerak ke kiri</strong></p>

            <p>
                arahkan joystick ke arah kiri dan untuk ke arah kanan arahkan joystick
                kearah kanan.
            </p>
        HTML, 2);

        $this->module($chapter->id, '2.2 Rotasi Kabin', <<<'HTML'
            <p>
                Tombol rotasi kabin berfungsi menggerakkan kabin ke kiri atau ke kanan.
            </p>

            <p><strong>Kabin dapat digerakkan jika :</strong></p>

            <ol class="list-lower-roman pl-6">
                <li>Tombol rotasi tidak ditekan secara bersamaan</li>
                <li>Canopy sedang dalam keadaan tertutup</li>
                <li>tidak berada dalam posisi maksimum kiri atau kanan</li>
                <li>cabin tidak menyentuh body pesawat</li>
            </ol>

            <p>
                Kabin dapat diputar ke kiri atau ke kanan menggunakan tombol rotasi kabin
                pada konsol kontrol.
            </p>
        HTML, 3);

        $this->module($chapter->id, '2.3 Penggerak Vertikal', <<<'HTML'
            <p>
                Penggerak vertical berfungsi menggerakkan Garbarata secara vertical, dengan
                menggunakan tombol vertical up / down pada konsol kontrol.
            </p>

            <p><strong>Garbarata dapat digerakkan secara vertical jika :</strong></p>

            <ol class="list-lower-roman pl-6">
                <li>Tombol vertical up dan down tidak ditekan secara bersamaan</li>
                <li>Garbarata tidak berada dalam posisi tinggi atau rendah maksimum.</li>
                <li>Canopy dalam keadaan terlipat sempurna</li>
                <li>Garbarata tidak digerakkan horizontal</li>
            </ol>
        HTML, 4);

        $this->module($chapter->id, '2.4 Penggerak Canopy', <<<'HTML'
            <p>
                Canopy berfungsi sebagai pembatas antara lingkungan dengan internal
                Garbarata saat sedang menempel dengan body pesawat. Canopy memiliki
                actuator kanan dan kiri. Canopy akan menempel pada badan pesawat pada
                tekanan tertentu yang tidak terlalu rendah juga tidak terlalu kuat.
            </p>
        HTML, 5);

        $this->module($chapter->id, '3. Mode Auto (Autolevel)', <<<'HTML'
            <p>
                Mode auto digunakan untuk mengunci komponen penggerak Garbarata yang tidak
                digunakan saat proses service. Saat keyswitch pada posisi Auto, maka seluruh
                komponen penggerak Garbarata akan mati.
            </p>

            <p>
                Mode auto hanya diaktifkan ketika proses loading dan unloading penumpang,
                jika proses sudah selesai kembalikan Garbarata pada posisi parkir dan matikan
                seluruh daya serta keyswitch dalam keadaan off.
            </p>

            <p><strong>a. Ketika keyswitch berada pada posisi AUTO, maka :</strong></p>

            <ul class="list-disc pl-6">
                <li>Fungsi horizontal drive tidak aktif</li>
                <li>Fungsi vertikal drive hanya aktif melalui roda autolevel (otomatis)</li>
                <li>Dalam keadaan autolevel mode, sistem canopy beroperasi secara otomatis</li>
                <li>Fungsi putaran cabin off</li>
                <li>Indicator autolevel menyala</li>
                <li>Fungsi pengaturan lantai kabin OFF</li>
            </ul>

            <p class="mt-4"><strong>b. Ketika pesawat naik atau turun, hal-hal berikut terjadi:</strong></p>

            <ul class="list-disc pl-6">
                <li>Ketika pesawat naik, sensor pada roda menyala. Ini mengatur output PLC untuk memberikan energi pada vertikal motor untuk naik.</li>
                <li>Pada saat pesawat bergerak turun, sensor pada roda menyala. Hal ini mengatur PLC output untuk memberi energi pada vertikal motor untuk turun.</li>
                <li>Jika indikator autolevel dan indikator service warning menyala, alarm akan berbunyi untuk memberi tanda pada ground crew jika terjadi kegagalan pada system.</li>
                <li>Untuk mematikan alarm ini, seseorang harus memutar tiga tombol posisi pada keadaan off/manual.</li>
            </ul>

            <p class="mt-4">
                <strong>Saat pengoperasian tetap pastikan Garbarata berada dalam pengawasan intens operator Garbarata .</strong>
            </p>
        HTML, 6);
        
        $this->module($chapter->id, '4.1 Prosedur Pengoperasian Standar (Mode Manual)', <<<'HTML'

            <p><strong>a. Periksa dan bersihkan arean pergerakan Garbarata dari benda enda mengganggu.</strong></p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.1_a.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.a">
            </figure>

            <p><strong>b. Nyalakan lampu exterior dan juga interior serta AC</strong></p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.1_b.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.b">
            </figure>

            <p><strong>c. Kontrol Konsol</strong></p>

            <p>1. Pastikan keyswitch dalam mode Off</p>

            <p>2. Tekan tombol Power On dan lampu tombol On akan menyala</p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.1_c2.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.c2">
            </figure>

            <p>
                3. Putar keyswitch ke mode manual, sesaat setelah diputar menuju mode
                manual, akan terdengar bunyi beep buzzer.
            </p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.1_c3.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.c3">
            </figure>

            <p><strong>d. Periksa komponen berikut</strong></p>

            <ol class="list-lower-roman pl-6 space-y-2">
                <li>
                    Closure dalam keadaan terlipat penuh, ketika lampu canopy down dalam
                    keadaan On, Garbarata tidak akan bisa digerakkan.
                </li>

                <li>
                    Autolevel dalam keadaan tidak bergerak.
                </li>

                <li>
                    Pastikan tidak ada orang di sepanjang tunnel terutama pada area ramp
                    tunnel dan area pertemuan antar tunnel.
                </li>
            </ol>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.1_d.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.d">
            </figure>

            <p>
                <strong>e.</strong> Gunakan Joystick untuk menggerakkan Garbarata maju atau mundur,
                gunakan tombol penggerak vertical dan cabin rotation untuk memosisikan
                Garbarata sesuai dengan posisi pesawat.
            </p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.1_e.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.e">
            </figure>

            <p>
                <strong>f.</strong> Setelah Garbarata menyentuh badan pesawat, sesuaikan bumper cabin
                dengan pintu pesawat. Saat bumper cabin sudah dekat dengan badan
                pesawat, kecepatan Garbarata secara otomatis akan turun.
            </p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.1_f.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.f">
            </figure>

            <p><strong>g. Turunkan Canopy Closure</strong></p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.1_g.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.1.g">
            </figure>

        HTML, 7);

        $this->module($chapter->id, '4.2 Prosedure Standar Operasi (Auto Mode)', <<<'HTML'
            <p><strong>a. Putar keyswitch ke posisi auto</strong></p>
            <p>
                Catatan: Ketika autolevel dalam keadaan aktif, semua penggerak pada
                control console tidak dapat bekerja.
            </p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_a.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.a">
            </figure>
            <p>
                <strong>b.</strong> Pastikan autolevel berkontak sempurna dengan badan pesawat. Jika
                Autolevel tidak bergerak secara sempurna jangan gunakan Garbarata,
                perbaiki autolevel terlebih dahulu.
            </p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_b.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.b">
            </figure>
            <p><strong>c. Buka pintu pesawat</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_c.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.c">
            </figure>
            <p><strong>d. Letakkan safety door shoe dibawah pintu pesawat</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_d.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.d">
            </figure>
            <p><strong>e. Setelah proses selesai, tutup pintu pesawat</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_e.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.e">
            </figure>
            <p><strong>f. Tutup service door</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_f.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.f">
            </figure>
            <p><strong>g. Putar keyswitch ke posisi manual</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_g.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.g">
            </figure>
            <p><strong>h. Lipat closure secara maksimal</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_h.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.h">
            </figure>
            <p><strong>1. Kembalikan Garbarata ke posisi parkir</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_i.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.i">
            </figure>
            <p><strong>j. Putar keyswitch ke mode off, dan matikan Garbarata serta cabut kunci</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_j.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.j">
            </figure>
            <p><strong>k. Tekan tombol off untuk mematikan garbarata</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.2_k.png" class="mx-auto max-h-96 w-full object-contain rounded-lg" alt="4.2.k">
            </figure>
            <p><strong>l. Matikan lampu dan AC jika tidak digunakan</strong></p>
            <p>
                <strong>Catatan :</strong> Tombol emergency stop hanya digunakan dalam keadaan darurat.
            </p>
        HTML, 8);
        
        $this->module($chapter->id, '4.3 Prosedur Pengoperasian Darurat', <<<'HTML'
            <p><strong>a. Over Swing</strong></p>
            <p>
                Penjelasan berikut merupakan prosedur jika Garbarata bergerak (swing)
                terlalu jauh sehingga melewati batas maksimum pada rotunda column.
            </p>
            <ol class="list-lower-roman pl-6 space-y-4">
                <li>
                    Jika Garbarata bergerak terlalu jauh dan menyentuh sensor limit
                    switch utama, maka Garbarata secara otomatis akan berhenti, untuk
                    mengembalikannya Garbarata harus digerakkan berlawanan.
                </li>

                <li>
                    Jika Garbarata melewati sensor limit switch utama maka terdapat
                    sensor limit switch cadangan (back up). Ketika Garbarata menyentuh
                    sensor limit switch back up, maka swing limit indicator akan menyala,
                    dan lampu service warning akan menyala serta Garbarata secara
                    otomatis akan mati. Untuk mengembalikannya, Garbarata harus
                    digerakkan kembali ke parking position. Ketika Garbarata telah berada
                    di parking position, tekan tombol reset untuk mengembalikan
                    Garbarata ke operasi normal. Segera hubungi petugas maintenance
                    untuk mengidentifikasi kegagalan limit switch utama dalam operasi.
                </li>
            </ol>

            <p class="mt-6"><strong>b. Over Steer</strong></p>

            <p>
                Prosedur berikut ini dilakukan jika Garbarata bergerak melebihi posisi
                rentang gerak steering.
            </p>

            <ol class="list-lower-roman pl-6 space-y-4">
                <li>
                    Dalam keadaan normal, jika operator menggerakkan Garbarata ke arah
                    kanan atau kiri, saat mencapai rentang maksimum maka limit switch
                    yang menjadi pembatas gerak akan berfungsi.
                </li>

                <li>
                    Setiap limit switch memiliki back up limit switch yang menjadi sensor
                    cadangan saat limit switch utama (initial) tidak berfungsi.
                </li>
            </ol>

            <p>
                Saat limit switch utama gagal, maka pergerakan Garbarata akan dibatasi
                oleh limit switch back up, dan indicator maksimum steering dan service
                warning ON akan berbunyi.
            </p>

            <p>
                Tindakan yang perlu dilakukan adalah arahkan Garbarata kembali ke
                posisi parkir, setelah tekan tombol reset untuk mengembalikan
                Garbarata ke operasi normal.
            </p>

            <p>
                Segera hubungi petugas maintenance untuk mengidentifikasi kegagalan
                limit switch utama dalam operasi.
            </p>

        HTML, 9);


        $this->module($chapter->id, '4.4 Parkir', <<<'HTML'

            <p>
                Pada saat memarkirkan Garbarata jika tiupan angin melebihi 25 m/s,
                Garbarata sebaiknya diputar agar bagian depan dari panjangnya terhindar
                dari tiupan angin, dan pastikan bahwa bagian yang terkena angin
                diminimalkan. Garbarata sebaiknya dipendekkan dan diturunkan.
            </p>

            <p class="mt-6"><strong>Catatan :</strong></p>

            <ul class="list-disc pl-6 space-y-3">
                <li>
                    Untuk mencegah angin yang berhembus kencang kedalam kabin,
                    operator harus selalu menutup pintu kabin / rolling door ketika
                    Garbarata tidak dioperasikan. Pada saat Garbarata kembali ke posisi
                    parkir, operator harus menutup pintu dan memendekkan atau memutar
                    Garbarata menjauh dari arah angin tersebut.
                </li>

                <li>
                    Jangan tinggalkan Garbarata kosong yang tidak digunakan dalam
                    keadaan autolevel menempel pada Pesawat. Ketika Garbarata tidak
                    digunakan, maka posisikan Garbarata sesuai posisi pesawat.
                </li>
            </ul>

        HTML, 10);

        $this->module($chapter->id, '4.5 Penggunaan Jacking Stand', <<<'HTML'
            <p>
                Pada situasi dimana Jacking Stand diperlukan untuk menyangga
                Garbarata atau memperbaiki wheel boogie, ikuti langkah-langkah berikut:
            </p>
            <p><strong>4.5.1</strong> Naikkan Garbarata untuk memungkinkan Jacking Stand berada di bawah Garbarata support beams.</p>
            <p><strong>4.5.2</strong> Tempatkan stand langsung di bawah support beams.</p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/chapter3_4.5.2.png"
                     class="mx-auto max-h-96 w-full object-contain rounded-lg"
                     alt="Jacking Stand">
            </figure>
            <p>
                <strong>4.5.3</strong> Turunkan Garbarata sampai support beams berada di atas
                jacking stand, dan stand (dongkrak) berdiri kuat pada apron.
                Lanjutkan dengan menahan tombol Down untuk menaikkan wheel
                boogie dari tanah untuk service.
            </p>
        HTML, 11);

        $this->module($chapter->id, '4.6 Malfungsi Pergerakan atau Fault Power Garbarata', <<<'HTML'
            <p>
                Pada situasi fault power atau malfungsi lainnya, akan sangat
                mempengaruhi pergerakan Garbarata. Jika Garbarata harus digerakan
                ataupun ditarik, dibawah ini merupakan prosedur-prosedur yang dapat
                diikuti apabila peringatan dan interlock tidak berfungsi. Pastikan bahwa
                wheel boogie tidak berotasi terlalu berlebihan pada saat dilakukan
                penarikan. Column jangan dirotasikan melebihi 87,5 derajat dari garis
                tengah.
            </p>
            <p><strong>Prosedur penggerakan meliputi :</strong></p>
            <p>
                <strong>4.6.1</strong> Pasang tali penarik ditempatnya pada drive column. Lalu
                sambungkan tali penarik ke plat eye hook yang terdapat di column frame
                menggunakan belenggu, setelah itu kencangkan pin pengunci.
            </p>
            <p>
                <strong>4.6.2</strong> Sambungkan ujung dari tali penarik ke kendaraan penarik.
            </p>
            <p>
                <strong>4.6.3</strong> Lepaskan rem pada motor wheel boogie dengan memutar
                knob rem searah jarum jam pada motor.
            </p>
            <p>
                <strong>4.6.4</strong> Tarik Garbarata secara perlahan, jangan tarik Garbarata
                dengan kasar atau secara tiba-tiba dengan kecepatan tinggi.
            </p>
            <p>
                <strong>4.6.5</strong> Tarik Garbarata kearah sesuai dengan posisi wheel boogie,
                jangan tarik Garbarata dengan paksa kearah lain berlawanan dengan
                wheel boogie.
            </p>
            <p>
                <strong>4.6.6</strong> Rem motor akan berfungsi secara otomatis seperti biasa
                ketika power kembali seperti semula, tetapi ada satu saran keamanan,
                kunci kembali rem motor wheel boogie setelah selesai menarik
                Garbarata dengan cara memutar knob rem berlawanan arah jarum jam.
            </p>
        HTML, 12);
    }

    private function module(int $chapterId, string $title, string $content, int $order): void
    {
        $englishTitles = [
            '1.1 Deskripsi Detail Pengoperasian' => '1.1 Detailed Operating Description',
            '2.1 Penggerak Horizontal' => '2.1 Horizontal Drive',
            '2.2 Rotasi Kabin' => '2.2 Cabin Rotation',
            '2.3 Penggerak Vertikal' => '2.3 Vertical Drive',
            '2.4 Penggerak Canopy' => '2.4 Canopy Drive',
            '3. Mode Auto (Autolevel)' => '3. Auto Mode (Autolevel)',
            '4.1 Prosedur Pengoperasian Standar (Mode Manual)' => '4.1 Standard Operating Procedure (Manual Mode)',
            '4.2 Prosedure Standar Operasi (Auto Mode)' => '4.2 Standard Operating Procedure (Auto Mode)',
            '4.3 Prosedur Pengoperasian Darurat' => '4.3 Emergency Operating Procedure',
            '4.4 Parkir' => '4.4 Parking',
            '4.5 Penggunaan Jacking Stand' => '4.5 Use of Jacking Stand',
            '4.6 Malfungsi Pergerakan atau Fault Power Garbarata' => '4.6 Garbarata Movement Malfunction or Power Failure',
        ];

        Module::create([
            'chapter_id' => $chapterId,
            'title' => ['id' => $title, 'en' => $englishTitles[$title] ?? $title],
            'content' => $content,
            'image_path' => null,
            'order' => $order,
        ]);
    }
}
