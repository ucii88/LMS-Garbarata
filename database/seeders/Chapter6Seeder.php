<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Module;
use App\Models\Diagram;
use App\Models\Hotspot;
use Illuminate\Database\Seeder;

class Chapter6Seeder extends Seeder
{
    public function run(): void
    {
        $chapter = Chapter::where('order', 6)->first();

        if (!$chapter) {
            return;
        }

        $module6_1 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '6.1 Katalog Drive Column (Kaki Penopang)',
            'content' => '<p>Drive column terdiri dari susunan penggerak roda, motor hidrolik/elektrik, dan sensor limit penyeimbang vertikal.</p>' .
                '<p class="mt-3"><strong>Detail Suku Cadang Terkait:</strong></p><ul>' .
                '<li><strong>(1) Tiang Jack Vertikal (Ball Screw Jack):</strong> Bagian mekanik ulir pengangkat elevasi jembatan.</li>' .
                '<li><strong>(2) Solid Tire (Ban Karet):</strong> Roda ban padat berukuran 40x14 Inch.</li>' .
                '<li><strong>(3) Motor Roda Penggerak:</strong> Motor listrik AC 3.7kW terhubung langsung ke gearbox reduktor roda.</li>' .
                '</ul>',
            'order' => 1,
        ]);

        $diagram6 = Diagram::create([
            'chapter_id' => $chapter->id,
            'title' => 'Katalog Komponen Drive Column',
            'image_path' => 'images/exploded_drive_column.png',
        ]);

        Hotspot::create([
            'diagram_id' => $diagram6->id,
            'target_module_id' => $module6_1->id,
            'label' => 'Lihat Suku Cadang Drive Column',
            'x_percent' => 50.0,
            'y_percent' => 50.0,
        ]);
    }
}
