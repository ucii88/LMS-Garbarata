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

        // Hapus modul lama jika ada
        Module::where('chapter_id', $chapter->id)->delete();

        // Hapus diagram & hotspot lama (agar tidak muncul gambar di atas konten)
        $diagrams = Diagram::where('chapter_id', $chapter->id)->get();
        foreach ($diagrams as $diagram) {
            Hotspot::where('diagram_id', $diagram->id)->delete();
            $diagram->delete();
        }

        // ----------------------------------------------------------------
        // Daftar item katalog: tambah/ubah sesuai kebutuhan.
        // Letakkan file PDF di: public/pdfs/chapter6/<filename>.pdf
        // ----------------------------------------------------------------
        $catalogItems = [
            [
                'id'    => 'cat-1',
                'title' => 'Cyclo® 6000',
                'desc'  => 'Dokumen katalog Cyclo Drive seri 6000 (reducer / gearbox). Berisi spesifikasi, rasio, torsi, dan dimensi unit penggerak yang dipakai pada sistem Garbarata.',
                'pdf'   => '/pdfs/chapter6/katalog_Cyclo_6000.pdf',
            ],
            [
                'id'    => 'cat-2',
                'title' => 'Warner Installation & Operation Manual',
                'desc'  => 'Dokumen instalasi dan panduan operasi komponen Warner yang digunakan pada sistem kontrol dan penggerak Garbarata.',
                'pdf'   => '/pdfs/chapter6/Katalog_Warner.pdf',
            ],
            [
                'id'    => 'cat-3',
                'title' => 'HIWIN LAS Series',
                'desc'  => 'Dokumen katalog Linear Guideway seri LAS dari Hiwin. Berisi spesifikasi, dimensi, dan part number komponen panduan linier yang digunakan pada Garbarata.',
                'pdf'   => '/pdfs/chapter6/Katalog_Hiwin_Las_Series.pdf',
            ],
            [
                'id'    => 'cat-4',
                'title' => 'Rooftop Packaged Air Conditioners',
                'desc'  => 'Dokumen katalog unit AC Rooftop Packaged yang digunakan pada sistem pendingin Garbarata. Berisi spesifikasi teknis, kapasitas, dan dimensi unit.',
                'pdf'   => '/pdfs/chapter6/Katalog_Rooftop _Packaged.pdf',
            ],
        ];

        foreach ($catalogItems as $index => $item) {
            $pdfContent = '<p class="text-xs text-slate-500 mb-3">' . htmlspecialchars($item['desc']) . '</p>';

            $pdfPublicPath = public_path(ltrim($item['pdf'], '/'));
            if (file_exists($pdfPublicPath)) {
                $pdfContent .= '<div class="rounded-lg overflow-hidden border border-slate-200 shadow-inner bg-white">';
                $pdfContent .= '<iframe src="' . $item['pdf'] . '" '
                    . 'width="100%" height="700" '
                    . 'class="block w-full" '
                    . 'title="' . htmlspecialchars($item['title']) . '" '
                    . 'loading="lazy">';
                $pdfContent .= '<p class="p-4 text-xs text-slate-500">Browser Anda tidak mendukung tampilan PDF langsung. '
                    . '<a href="' . $item['pdf'] . '" class="text-blue-600 underline" target="_blank">Klik di sini untuk membuka PDF</a>.</p>';
                $pdfContent .= '</iframe>';
                $pdfContent .= '</div>';
            } else {
                $pdfContent .= '<div class="rounded-lg border-2 border-dashed border-slate-200 bg-white p-8 text-center">';
                $pdfContent .= '<svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">'
                    . '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>'
                    . '</svg>';
                $pdfContent .= '<p class="text-sm font-semibold text-slate-500 mb-1">File PDF Belum Tersedia</p>';
                $pdfContent .= '<p class="text-xs text-slate-400 mb-3">Letakkan file PDF di:</p>';
                $pdfContent .= '<code class="text-xs font-mono bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg block text-left max-w-xs mx-auto">'
                    . 'public' . $item['pdf'] . '</code>';
                $pdfContent .= '<p class="text-xs text-slate-400 mt-3">Setelah file diunggah, jalankan kembali seeder atau refresh halaman ini.</p>';
                $pdfContent .= '</div>';
            }

            Module::create([
                'chapter_id' => $chapter->id,
                'title'      => '6.' . ($index + 1) . ' ' . $item['title'],
                'content'    => $pdfContent,
                'order'      => $index + 1,
            ]);
        }
    }
}
