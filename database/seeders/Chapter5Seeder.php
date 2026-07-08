<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Module;
use Illuminate\Database\Seeder;

class Chapter5Seeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 5)->first();

        if (!$chapter) {
            return;
        }

        Module::create([
            'chapter_id' => $chapter->id,
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
            'chapter_id' => $chapter->id,
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
    }
}
