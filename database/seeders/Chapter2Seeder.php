<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Module;
use Illuminate\Database\Seeder;

class Chapter2Seeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 2)->first();

        if (!$chapter) {
            return;
        }

        $this->module($chapter->id, '1.1 Model', <<<'HTML'
            <p>
                Model dan jenis Garbarata bervariasi bergantung permintaan konsumen. Untuk penamaan tipe
                Garbarata ditentukan berdasarkan panjang Garbarata dari titik pusat Rotunda sampai ujung
                bumper cabin pada saat pendek dan panjang maksimum. Garbarata Bandara Internasional
                Sultan Hasanuddin, Makassar memiliki tipe B3 - 22/39 dan B2 - 21/28 yang merupakan
                Garbarata tiga tunnel atau dua tunnel dengan panjang minimum Garbarata saat diperpendek
                sesuai dengan tipe yang sudah ditentukan. Sebagai contoh, B3 - 22/39 memiliki arti
                22 meter saat Garbarata memendek maksimal dan 39 meter saat diperpanjang maksimal.
                Begitu juga memiliki kesamaan arti dengan tipe B2 - 21/28.
            </p>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/garbarata_2Tunnel.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Garbarata">
            </figure>

            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/garbarata_3Tunnel.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Garbarata 3 tunnel">
            </figure>

            <div class="overflow-x-auto my-6">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr>
                            <th colspan="5" class="border-b-2 border-gray-700 py-2 text-center text-lg font-bold">
                                General Specification
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-400">
                            <td class="py-2 font-medium w-1/3">Type Number</td>
                            <td class="py-2 w-4">:</td>
                            <td class="py-2 font-semibold">B2 - 21/28 SWRGG</td>
                            <td class="py-2 font-semibold">B3 - 22/39 SWLGG</td>
                        </tr>
                        <tr class="border-b border-gray-400">
                            <td class="py-2 font-medium">Number of PBB</td>
                            <td>:</td>
                            <td>3 unit</td>
                            <td>3 unit</td>
                        </tr>
                        <tr class="border-b border-gray-400">
                            <td class="py-2 font-medium">Number of Tunnel</td>
                            <td>:</td>
                            <td>2 Tunnel</td>
                            <td>3 Tunnel</td>
                        </tr>
                        <tr class="border-b border-gray-400">
                            <td class="py-2 font-medium">Service Door Position</td>
                            <td>:</td>
                            <td>Right</td>
                            <td>Left</td>
                        </tr>
                        <tr class="border-b border-gray-400">
                            <td class="py-2 font-medium">Tunnel Side Wall</td>
                            <td>:</td>
                            <td>Glass Wall</td>
                            <td>Glass Wall</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        HTML, 1);

        $this->module($chapter->id, '1.2 Batasan Rancangan', <<<'HTML'
            <div class="overflow-x-auto my-6">
                <table class="w-full border-collapse text-sm">
                    <tbody>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Maximum floor load</td>
                            <td class="py-2 px-3 text-right">200 kg/m<sup>2</sup></td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Maximum roof load</td>
                            <td class="py-2 px-3 text-right">122 kg/m<sup>2</sup></td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Maximum wind speed in operation</td>
                            <td class="py-2 px-3 text-right">27 m/s</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Maximum wind speed not in operation</td>
                            <td class="py-2 px-3 text-right">40 m/s</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Ambient temperature</td>
                            <td class="py-2 px-3 text-right">35&deg;C</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Maximum humidity</td>
                            <td class="py-2 px-3 text-right">80%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        HTML, 2);

        $this->module($chapter->id, '1.3 Dimensi', <<<'HTML'
            <p><strong>1.3.1 Dimensi Internal</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/dimensi_internal.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Dimensi internal">
            </figure>

            <div class="overflow-x-auto my-6">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="py-2 text-center text-lg font-bold">B2 - 23/32 SWRGG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Minimum Clear Internal Width (A)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">1.49 m</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Minimum Clear Internal Height (B)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">2.15 m</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p><strong>1.3.2 Maximum and Minimum Length</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/max_min_length.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Maximum and minimum length">
            </figure>

            <div class="overflow-x-auto my-6">
                <table class="w-full border-collapse text-sm">
                    <thead>
                        <tr>
                            <th colspan="2" class="py-2 text-center text-lg font-bold">B2 - 23/32 SWRGG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Retracted operation limit (A)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">23 m</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="py-2 px-3 font-medium">Extended operation limit (B)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">32 m</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        HTML, 3);

        $this->module($chapter->id, '1.4 Performa', <<<'HTML'
            <p><strong>1.4.1 Pergerakan Garbarata</strong></p>

            <p><strong>a. Gerakan Vertikal</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/gerakan_vertikal.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Gerakan vertikal">
            </figure>
            <p class="text-center font-bold my-2"><strong>B2 - 23/32 SWRGG</strong></p>
            <div class="overflow-x-auto my-4">
                <table class="w-full border border-gray-500 border-collapse text-sm">
                    <tbody>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Lowest level (A)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">2.0 m</td>
                        </tr>
                        <tr>
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Highest level (B)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">5.4 m</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p><strong>b. Sudut Putar Horizontal Rotunda</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/sudut_putar_horizontal_rotunda.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Sudut putar horizontal rotunda">
            </figure>
            <p class="text-center font-bold my-2"><strong>B2 - 23/32 SWRGG</strong></p>
            <div class="overflow-x-auto my-4">
                <table class="w-full border border-gray-500 border-collapse text-sm">
                    <tbody>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Maximum left swing (A)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">87.5&deg;</td>
                        </tr>
                        <tr>
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Maximum right swing (B)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">87.5&deg;</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p><strong>c. Sudut Putar Rotasi Cabin</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/sudut_putar_rotasi_cabin.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Sudut putar rotasi cabin">
            </figure>
            <p class="text-center font-bold my-2"><strong>B2 - 23/32 SWRGG</strong></p>
            <div class="overflow-x-auto my-4">
                <table class="w-full border border-gray-500 border-collapse text-sm">
                    <tbody>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Maximum left rotation (A)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">75&deg;</td>
                        </tr>
                        <tr>
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Maximum right rotation (B)</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">75&deg;</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p><strong>d. Sudut Putar Rotasi Wheel Boogie</strong></p>
            <figure class="my-6 rounded-xl border border-gray-200 bg-gray-50 p-3">
                <img src="/images/modules/sudut_putar_rotasi_wheel_boogie.png" class="mx-auto max-h-80 w-full object-contain rounded-lg" alt="Sudut putar rotasi wheel boogie">
            </figure>
            <p class="text-center font-bold my-2"><strong>B2 SWRGG dan B3 SWLGG</strong></p>

            <p><strong>1.4.2 Kecepatan Operasi</strong></p>
            <div class="overflow-x-auto my-4">
                <table class="w-full border border-gray-500 border-collapse text-sm">
                    <tbody>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Horizontal Movement</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">0 &ndash; 25 m/min</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Vertical Movement</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">1.5 m/min</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Forward and reverse speed</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">&lt; 0.4 m/s</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Vertical drive speed</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">&lt; 0.1 m/s</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Cabin rotation speed</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">&lt; 2&deg;/sec</td>
                        </tr>
                        <tr class="border-b border-gray-500">
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Wheel steering speed</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">&lt; 0.5 m/s</td>
                        </tr>
                        <tr>
                            <td class="border-r border-gray-500 py-2 px-3 font-medium">Auto leveler vertical speed</td>
                            <td class="py-2 px-3 text-right whitespace-nowrap">0.013 m/s</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        HTML, 4);

        $this->module($chapter->id, '2.1 Power Supply', <<<'HTML'
            <p>Sumber tenaga listrik utama Garbarata berasal dari bangunan Bandara yang dibagi sesuai komponen utama berikut:</p>
            <div class="overflow-x-auto my-4">
                <table class="w-full border border-gray-500 border-collapse text-sm">
                    <tbody>
                        <tr>
                            <td class="border border-gray-500 py-2 px-3 font-medium">Drive power</td>
                            <td class="border border-gray-500 py-2 px-3">380V</td>
                            <td class="border border-gray-500 py-2 px-3">3-phase</td>
                            <td class="border border-gray-500 py-2 px-3">50 Hz</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-500 py-2 px-3 font-medium">Lighting and Control power</td>
                            <td class="border border-gray-500 py-2 px-3">220V</td>
                            <td class="border border-gray-500 py-2 px-3">single phase</td>
                            <td class="border border-gray-500 py-2 px-3">50 Hz</td>
                        </tr>
                        <tr>
                            <td rowspan="2" class="border border-gray-500 py-2 px-3 font-medium">Air Conditioner power</td>
                            <td class="border border-gray-500 py-2 px-3">380 VAC</td>
                            <td class="border border-gray-500 py-2 px-3">3 phase</td>
                            <td class="border border-gray-500 py-2 px-3">50 Hz</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-500 py-2 px-3">220 V</td>
                            <td class="border border-gray-500 py-2 px-3">single phase</td>
                            <td class="border border-gray-500 py-2 px-3">50 Hz</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        HTML, 5);

        $this->module($chapter->id, '2.2 Aktuator', <<<'HTML'
            <div class="overflow-x-auto my-4">
                <table class="w-full table-fixed border border-gray-500 border-collapse text-sm">
                    <tbody>
                        <tr>
                            <td class="border border-gray-500 py-2 px-3 font-medium align-top break-words w-[34%]">Horizontal drive motor</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">5.5 kW</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">380VAC</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">3 Phase</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">50 Hz Cyclo drive</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-500 py-2 px-3 font-medium align-top break-words w-[34%]">Vertical drive motor</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">3.7 kW</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">380VAC</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">3 Phase</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">50 Hz Cyclo drive</td>
                        </tr>
                        <tr>
                            <td class="border border-gray-500 py-2 px-3 font-medium align-top break-words w-[34%]">Cabin rotation motor</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">0.75kW</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">380VAC</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">3 Phase</td>
                            <td class="border border-gray-500 py-2 px-3 align-top break-words">50 Hz Cyclo drive</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        HTML, 6);

        $this->module($chapter->id, '2.3 Pencahayaan ', <<<'HTML'
            <p>
                Garbarata dilengkapi dengan pencahayaan yang lengkap, baik interior maupun eksterior,
                serta ditambah dengan lampu emergency dan lampu operasi. Detail posisi lampu terdapat
                pada Bab 7.
            </p>
        HTML, 7);
    }

    private function module(int $chapterId, string $title, string $content, int $order): void
    {
        Module::updateOrCreate(
            [
                'chapter_id' => $chapterId,
                'title' => $title,
            ],
            [
                'content' => $content,
                'image_path' => null,
                'order' => $order,
            ],
        );
    }
}
