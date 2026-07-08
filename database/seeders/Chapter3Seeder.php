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

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '3.1 Prosedur Pre-docking (Sebelum Pesawat Masuk)',
            'content' => '<p>Operator wajib memastikan kondisi lingkungan apron aman sebelum pesawat tiba di garis henti:</p><ol><li>Periksa tidak ada benda asing (FOD) di area sapuan roda Garbarata.</li><li>Pastikan canopy karet dalam posisi terlipat penuh ke atas.</li><li>Posisikan Garbarata pada markah parkir aman (Home Position).</li></ol>',
            'order' => 1,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '3.2 Prosedur Docking (Merapat ke Pintu Pesawat)',
            'content' => '<p>Langkah-langkah merapatkan jembatan setelah lampu tanda henti menyala dan mesin pesawat dimatikan:</p><ol><li>Gerakkan roda maju secara perlahan menggunakan joystick kontrol kabin.</li><li>Arahkan bumper kabin lurus menghadap pintu utama pesawat.</li><li>Turunkan canopy penutup cuaca secara perlahan hingga menutup celah badan pesawat secara rapat namun tanpa tekanan berlebih.</li><li>Aktifkan sistem sensor auto-leveling.</li></ol>',
            'order' => 2,
        ]);
    }
}
