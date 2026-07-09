<?php

namespace Database\Seeders;

use App\Models\Chapter;
use App\Models\Diagram;
use App\Models\Hotspot;
use App\Models\Module;
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

        // ----------------------------------------------------------------
        // Bangun HTML konten modul
        // ----------------------------------------------------------------
        $content = '<p class="text-xs text-slate-600 leading-relaxed mb-4">Halaman ini berisi katalog suku cadang dan komponen Garbarata dalam format PDF. '
            . '<em class="text-blue-600 font-semibold">Klik pada masing-masing judul katalog di bawah ini</em> untuk membuka dan membaca dokumen PDF terkait.</p>';

        // Accordion items
        $content .= '<div class="space-y-3 mt-6" id="catalog-accordion">';

        foreach ($catalogItems as $index => $item) {
            $isFirst = $index === 0;
            $openAttr = $isFirst ? ' open' : '';

            $content .= '<details id="' . $item['id'] . '" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden"' . $openAttr . '>';

            // Summary (header yang bisa diklik)
            $content .= '<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 '
                . 'bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white '
                . 'transition-colors duration-200 list-none">';
            $content .= '<div class="flex items-center gap-3">';
            $content .= '<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">'
                . ($index + 1) . '</span>';
            $content .= '<span class="font-semibold text-slate-800 text-sm">' . htmlspecialchars($item['title']) . '</span>';
            $content .= '</div>';
            // Chevron icon (rotates when open)
            $content .= '<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" '
                . 'fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">'
                . '<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>';
            $content .= '</summary>';

            // Konten (PDF viewer)
            $content .= '<div class="border-t border-slate-100">';
            $content .= '<div class="px-5 py-3 bg-slate-50/50">';
            $content .= '<p class="text-xs text-slate-500 mb-3">' . htmlspecialchars($item['desc']) . '</p>';

            // Cek apakah file PDF ada, jika tidak tampilkan placeholder
            $pdfPublicPath = public_path(ltrim($item['pdf'], '/'));
            if (file_exists($pdfPublicPath)) {
                // PDF tersedia — tampilkan dengan iframe
                $content .= '<div class="rounded-lg overflow-hidden border border-slate-200 shadow-inner bg-white">';
                $content .= '<iframe src="' . $item['pdf'] . '" '
                    . 'width="100%" height="700" '
                    . 'class="block w-full" '
                    . 'title="' . htmlspecialchars($item['title']) . '" '
                    . 'loading="lazy">';
                $content .= '<p class="p-4 text-xs text-slate-500">Browser Anda tidak mendukung tampilan PDF langsung. '
                    . '<a href="' . $item['pdf'] . '" class="text-blue-600 underline" target="_blank">Klik di sini untuk membuka PDF</a>.</p>';
                $content .= '</iframe>';
                $content .= '</div>';
            } else {
                // PDF belum ada — tampilkan placeholder informatif
                $content .= '<div class="rounded-lg border-2 border-dashed border-slate-200 bg-white p-8 text-center">';
                $content .= '<svg class="w-12 h-12 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">'
                    . '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>'
                    . '</svg>';
                $content .= '<p class="text-sm font-semibold text-slate-500 mb-1">File PDF Belum Tersedia</p>';
                $content .= '<p class="text-xs text-slate-400 mb-3">Letakkan file PDF di:</p>';
                $content .= '<code class="text-xs font-mono bg-slate-100 text-slate-600 px-3 py-1.5 rounded-lg block text-left max-w-xs mx-auto">'
                    . 'public' . $item['pdf'] . '</code>';
                $content .= '<p class="text-xs text-slate-400 mt-3">Setelah file diunggah, jalankan kembali seeder atau refresh halaman ini.</p>';
                $content .= '</div>';
            }

            $content .= '</div>'; // end padding wrapper
            $content .= '</div>'; // end content
            $content .= '</details>';
        }

        $content .= '</div>'; // end accordion

        // Script untuk smooth open/close dan auto-scroll
        $content .= '<script>'
            . 'document.addEventListener("DOMContentLoaded", function() {'
            . '    var allDetails = document.querySelectorAll("#catalog-accordion details");'
            . '    allDetails.forEach(function(det) {'
            . '        det.addEventListener("toggle", function() {'
            . '            if (det.open) {'
            . '                allDetails.forEach(function(other) {'
            . '                    if (other !== det && other.open) { other.removeAttribute("open"); }'
            . '                });'
            . '                setTimeout(function() {'
            . '                    det.scrollIntoView({ behavior: "smooth", block: "start" });'
            . '                }, 100);'
            . '            }'
            . '        });'
            . '    });'
            . '});'
            . '</script>';

        // ----------------------------------------------------------------
        // Simpan sebagai satu modul
        // ----------------------------------------------------------------
        Module::create([
            'chapter_id' => $chapter->id,
            'title'      => '6.1 Katalog Komponen Garbarata',
            'content'    => $content,
            'order'      => 1,
        ]);
    }
}
