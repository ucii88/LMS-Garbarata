<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Module;
use App\Models\Diagram;
use App\Models\Hotspot;
use Illuminate\Database\Seeder;

class Chapter7Seeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 7)->first();

        if (!$chapter) {
            return;
        }

        $module7_1 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '7.1 Sirkuit Tenaga (Power Circuit)',
            'content' => '<p>Sistem suplai daya utama Garbarata menggunakan tegangan AC 3-Phase 380V/50Hz dari generator gedung terminal.</p><p>Komponen kelistrikan utama:</p><ul><li><strong>Main Breaker (MCCB):</strong> Pemutus sirkuit utama di panel panel distribusi.</li><li><strong>Inverter Motor Roda:</strong> Mengatur frekuensi motor listrik penggerak roda agar pergerakan halus.</li><li><strong>Inverter Elevasi:</strong> Mengontrol motor pengangkat terowongan.</li></ul>',
            'order' => 1,
        ]);

        $diagram = Diagram::create([
            'chapter_id' => $chapter->id,
            'title' => 'Diagram Sirkuit Kelistrikan Utama',
            'image_path' => 'images/electrical_diagram.png',
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module7_1->id,
            'label' => 'Main Panel Breaker',
            'x_percent' => 50.0,
            'y_percent' => 50.0,
        ]);
    }
}
