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

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '2.1 Spesifikasi Dimensi Fisik',
            'content' => '<p>Data Teknis dimensi fisik jembatan penyeberangan Garbarata:</p><div class="overflow-x-auto my-4"><table class="min-w-full divide-y divide-gray-200 border border-gray-100 text-xs"><thead><tr class="bg-gray-50 text-slate-600 font-bold"><th>Parameter</th><th class="p-2">Nilai Minimal</th><th class="p-2">Nilai Maksimal</th></tr></thead><tbody class="divide-y divide-gray-100 text-slate-600"><tr><td class="p-2">Panjang Terowongan (Retracted/Extended)</td><td class="p-2">18.5 Meter</td><td class="p-2">39.0 Meter</td></tr><tr class="bg-slate-50/50"><td class="p-2">Tinggi Kabin (Elevasi/Vertikal)</td><td class="p-2">2.1 Meter</td><td class="p-2">5.4 Meter</td></tr><tr><td class="p-2">Kecepatan Rotasi Roda</td><td class="p-2">0 deg/sec</td><td class="p-2">4.2 deg/sec</td></tr></tbody></table></div>',
            'order' => 1,
        ]);

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '2.2 Batas Toleransi Beban',
            'content' => '<p>Beban struktural maksimum Garbarata mencakup berat terowongan, hembusan angin, dan berat penumpang berjalan:</p><ul><li><strong>Beban Hidup Terdistribusi:</strong> Maksimum 300 kg/m² pada terowongan.</li><li><strong>Kecepatan Angin Operasional:</strong> Maksimum 60 knot (111 km/jam). Di atas itu, jembatan harus ditarik ke posisi parkir jangkar.</li></ul>',
            'order' => 2,
        ]);
    }
}
