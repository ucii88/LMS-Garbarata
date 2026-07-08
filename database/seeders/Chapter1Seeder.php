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
            'title' => '1.1 Rotunda (Pangkal Garbarata)',
            'image_path' => 'images/modules/rotunda.png',
            'content' => '<p><strong>Rotunda</strong> adalah bagian pangkal atau poros utama Garbarata yang terhubung langsung dengan terminal bandara (departure gate).</p><p>Karakteristik penting Rotunda:</p><ul><li>Memiliki engsel rotasi horizontal yang memungkinkan terowongan Garbarata berputar ke kiri dan kanan hingga sudut tertentu.</li><li>Memiliki sistem penyeimbang beban agar struktur terowongan tetap kokoh ketika memanjang.</li><li>Dilengkapi pintu transisi aman dari gedung terminal menuju area Garbarata.</li></ul>',
            'order' => 1,
        ]);

        $module1_2 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '1.2 Telescopic Tunnel (Terowongan)',
            'image_path' => 'images/modules/telescoping_tunnels.png',
            'content' => '<p><strong>Telescopic Tunnel</strong> adalah lorong berjalan berbentuk tabung persegi yang dapat memanjang dan memendek (sistem teleskopik).</p><p>Komponen di dalam Tunnel:</p><ul><li><strong>Inner & Outer Tunnel:</strong> Segmen lorong yang saling berhimpitan dan bergeser maju/mundur.</li><li><strong>Flooring & Lighting:</strong> Karpet anti-slip dan pencahayaan LED darurat untuk kenyamanan penumpang.</li><li><strong>Service Doors:</strong> Pintu darurat/akses tangga luar yang berada di sepanjang lorong.</li></ul>',
            'order' => 2,
        ]);

        $module1_3 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '1.3 Cabin & Control Console (Kabin Kemudi)',
            'image_path' => 'images/modules/cabin.png',
            'content' => '<p><strong>Kabin Kontrol</strong> terletak di ujung Garbarata yang langsung menempel ke pintu pesawat (aircraft door).</p><p>Di dalam kabin ini terdapat panel kontrol utama bagi operator:</p><ul><li><strong>Joystick Kontrol:</strong> Mengatur pergerakan maju-mundur terowongan dan menaikkan/menurunkan elevasi kabin.</li><li><strong>Canopy Controller:</strong> Menurunkan penutup karet pelindung cuaca (canopy) ke atas badan pesawat.</li><li><strong>Auto-leveling Arm:</strong> Lengan sensor otomatis yang mendeteksi perubahan tinggi pintu pesawat akibat naik-turunnya beban muatan/penumpang, lalu menyesuaikan tinggi Garbarata secara otomatis.</li></ul>',
            'order' => 3,
        ]);

        $module1_4 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '1.4 Drive Column & Wheels (Kolom Penggerak)',
            'image_path' => 'images/modules/wheel_boogie.png',
            'content' => '<p><strong>Drive Column (Wheels)</strong> merupakan kaki penopang utama sekaligus sistem penggerak roda mekanis Garbarata.</p><p>Sistem ini meliputi:</p><ul><li><strong>Dua Roda Besar:</strong> Digerakkan oleh motor listrik AC atau sistem hidrolik independen untuk memutar dan menggerakkan maju/mundur.</li><li><strong>Elevating System:</strong> Tiang penyangga vertikal bersumbu ulir (ball screw) atau hidrolik silinder untuk menaikkan/menurunkan seluruh tinggi terowongan.</li><li><strong>Wheel Guard:</strong> Pelindung ban dari benturan objek asing di apron bandara.</li></ul>',
            'order' => 4,
        ]);

        $diagram = Diagram::create([
            'chapter_id' => $chapter->id,
            'title' => 'Diagram Struktur Utama Garbarata',
            'image_path' => 'images/garbarata.png',
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module1_1->id,
            'label' => 'Rotunda (Pangkal)',
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
            'label' => 'Cabin & Control Console',
            'x_percent' => 87.0,
            'y_percent' => 45.0,
        ]);

        Hotspot::create([
            'diagram_id' => $diagram->id,
            'target_module_id' => $module1_4->id,
            'label' => 'Drive Column & Wheels',
            'x_percent' => 72.0,
            'y_percent' => 77.0,
        ]);
    }
}
