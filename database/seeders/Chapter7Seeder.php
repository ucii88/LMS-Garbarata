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

        // Hapus modul lama jika ada
        Module::where('chapter_id', $chapter->id)->delete();

        // Hapus diagram & hotspot lama agar bersih
        $diagrams = Diagram::where('chapter_id', $chapter->id)->get();
        foreach ($diagrams as $diagram) {
            Hotspot::where('diagram_id', $diagram->id)->delete();
            $diagram->delete();
        }

        // Mendaftarkan 14 lembar gambar dari bab7.1 sampai bab7.14
        for ($i = 1; $i <= 14; $i++) {
            Module::create([
                'chapter_id' => $chapter->id,
                'title' => "7.$i Lembar Gambar $i",
                'content' => "<p>Lampiran Gambar Elektrikal Lembar $i (As-Built Diagram Garbarata).</p>",
                'image_path' => "images/modules/Bab7/bab7.$i.png",
                'order' => $i,
            ]);
        }
    }
}

