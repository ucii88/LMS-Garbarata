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

        // Clean existing modules to prevent duplicate entries on seed
        Module::where('chapter_id', $chapter->id)->delete();

        // Build HTML content for 5.1 Daftar Komponen
        $content = '';

        // 5.1.1 Rotunda Assembly
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2">5.1.1. Rotunda Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Rotunda Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1085:1450 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1085/1450] max-w-sm select-none">' .
            '<img src="/images/modules/technical_drawing.png" class="w-full h-full object-cover rounded-lg" alt="Rotunda Technical Drawing">' .
            
            // Absolute-positioned hotspots mapped center-wise via translate
            '<!-- Hotspots -->' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 29.31%; top: 45.93%;" onclick="scrollToPartRow(1)" title="1. Barrel Rotunda Curtain Assembly (Left side)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 38.34%; top: 56.00%;" onclick="scrollToPartRow(3)" title="3. Guide Pipe Barrel"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 45.71%; top: 66.48%;" onclick="scrollToPartRow(3)" title="3. Guide Pipe Barrel"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 48.66%; top: 50.62%;" onclick="scrollToPartRow(4)" title="4. Tension Barrel Bearing"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 5.53%; top: 69.38%;" onclick="scrollToPartRow(5)" title="5. Slat Curtain Assy (L/R)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 22.67%; top: 57.52%;" onclick="scrollToPartRow(6)" title="6. Tension Barrel"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 53.27%; top: 56.00%;" onclick="scrollToPartRow(7)" title="7. Guide Pipe Barrel Bearing"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 73.92%; top: 6.21%;" onclick="scrollToPartRow(8)" title="8. Roller Bearing Rotunda"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 59.72%; top: 5.52%;" onclick="scrollToPartRow(9)" title="9. Plate Curtain Upper"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 13.27%; top: 46.76%;" onclick="scrollToPartRow(9)" title="9. Plate Curtain Upper"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 19.72%; top: 28.55%;" onclick="scrollToPartRow(10)" title="10. Potentiometer Rotunda Assy"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 88.66%; top: 30.62%;" onclick="scrollToPartRow(11)" title="11. Hinge Pin"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 45.71%; top: 55.59%;" onclick="scrollToPartRow(12)" title="12. Plate Seat Curtain (L/R)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 18.99%; top: 45.66%;" onclick="scrollToPartRow(13)" title="13. Worm Gear Assembly (L/R)"></button>' .
            '</div>' .
            
            // Rotunda Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="part-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">ORT001AM</td><td class="p-2.5">Barrel Rotunda Curtain Assembly (Left side)</td></tr>' .
            '<tr id="part-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">ORT002AM</td><td class="p-2.5">Barrel Rotunda Curtain Assembly (Right side)</td></tr>' .
            '<tr id="part-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">ORT103AM</td><td class="p-2.5">Guide Pipe Barrel</td></tr>' .
            '<tr id="part-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">ORT004SM</td><td class="p-2.5">Tension Barrel Bearing</td></tr>' .
            '<tr id="part-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">ORT005AM</td><td class="p-2.5">Slat Curtain Assy (L/R)</td></tr>' .
            '<tr id="part-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">ORT104AM</td><td class="p-2.5">Tension Barrel</td></tr>' .
            '<tr id="part-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">ORT105AM</td><td class="p-2.5">Guide Pipe Barrel Bearing</td></tr>' .
            '<tr id="part-row-8" class="transition duration-300"><td class="p-2.5 text-center font-bold">8</td><td class="p-2.5 font-mono">ORT008AM</td><td class="p-2.5">Roller Bearing Rotunda</td></tr>' .
            '<tr id="part-row-9" class="transition duration-300"><td class="p-2.5 text-center font-bold">9</td><td class="p-2.5 font-mono">ORT106AM</td><td class="p-2.5">Plate Curtain Upper</td></tr>' .
            '<tr id="part-row-10" class="transition duration-300"><td class="p-2.5 text-center font-bold">10</td><td class="p-2.5 font-mono">ORT023SM</td><td class="p-2.5">Potentiometer Rotunda Assy</td></tr>' .
            '<tr id="part-row-11" class="transition duration-300"><td class="p-2.5 text-center font-bold">11</td><td class="p-2.5 font-mono">ORT012CM</td><td class="p-2.5">Hinge Pin</td></tr>' .
            '<tr id="part-row-12" class="transition duration-300"><td class="p-2.5 text-center font-bold">12</td><td class="p-2.5 font-mono">ORT013CM</td><td class="p-2.5">Plate Seat Curtain (L/R)</td></tr>' .
            '<tr id="part-row-13" class="transition duration-300"><td class="p-2.5 text-center font-bold">13</td><td class="p-2.5 font-mono">ORT013AM</td><td class="p-2.5">Worm Gear Assembly (L/R)</td></tr>' .
            '<tr id="part-row-14" class="transition duration-300"><td class="p-2.5 text-center font-bold">14</td><td class="p-2.5 font-mono">ORT107AM</td><td class="p-2.5">Carpet for Rotunda</td></tr>' .
            '</tbody></table></div>' .
            
            // Embedded Scroll & Highlight Interaction Script for Rotunda
            '<script>' .
            'function scrollToPartRow(no) {' .
            '    const row = document.getElementById("part-row-" + no);' .
            '    if (row) {' .
            '        row.scrollIntoView({ behavior: "smooth", block: "center" });' .
            '        document.querySelectorAll(\'[id^="part-row-"]\').forEach(r => {' .
            '            r.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");' .
            '        });' .
            '        row.classList.add("bg-blue-50", "text-blue-900", "font-semibold");' .
            '        setTimeout(() => {' .
            '            row.classList.remove("bg-blue-50", "text-blue-900", "font-semibold");' .
            '        }, 2000);' .
            '    }' .
            '}' .
            '</script>';

        // 5.1.2 Tunnel Roller
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.2. Tunnel Roller</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) lokasi pemasangan roller dan detail rakitan komponen untuk Tunnel Roller. <strong>Klik pada tombol lingkaran biru transparan di gambar peta lokasi</strong> untuk melihat detail rakitan pada lembar referensi yang sesuai, serta menyorot part number pada tabel di bawah.</p>' .
            
            // Main Location Map Container (Aspect ratio matched to 1181:1332)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1181/1332] max-w-sm select-none">' .
            '<img src="/images/modules/TunnelRoller/tunnel_roller.png" class="w-full h-full object-cover rounded-lg" alt="Tunnel Roller Location Map">' .
            
            // Hotspots for Location Map (1 to 18)
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 42.85%; top: 15.62%;" onclick="scrollToRollerRow(1)" title="1. Fixed Roller (B2 Tunnel A Upper Rear)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 63.51%; top: 34.23%;" onclick="scrollToRollerRow(2)" title="2. Side Roller (B2 Tunnel A Lower Outer Front)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 55.38%; top: 37.99%;" onclick="scrollToRollerRow(3)" title="3. Tandem Roller (B2 Tunnel A Lower Front)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 71.46%; top: 29.13%;" onclick="scrollToRollerRow(4)" title="4. Nosing Ramp"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 52.50%; top: 12.76%;" onclick="scrollToRollerRow(5)" title="5. Fixed Roller (B2 Tunnel A Upper Front)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 41.49%; top: 43.09%;" onclick="scrollToRollerRow(6)" title="6. Fixed Roller (B2 Tunnel A Lower Rear)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 30.14%; top: 62.91%;" onclick="scrollToRollerRow(7)" title="7. Fixed Roller (B3 Tunnel A Upper Rear)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 36.75%; top: 59.46%;" onclick="scrollToRollerRow(8)" title="8. Fixed Roller (B3 Tunnel A Upper Front)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 34.21%; top: 87.84%;" onclick="scrollToRollerRow(9)" title="9. Fixed Roller (B3 Tunnel A Lower Rear)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 54.36%; top: 50.60%;" onclick="scrollToRollerRow(10)" title="10. Fixed Roller (B3 Tunnel B Upper Rear)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.29%; top: 46.55%;" onclick="scrollToRollerRow(11)" title="11. Fixed Roller (B3 Tunnel B Upper Front)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.41%; top: 77.03%;" onclick="scrollToRollerRow(12)" title="12. Fixed Roller (B3 Tunnel B Lower Rear)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 44.88%; top: 86.04%;" onclick="scrollToRollerRow(13)" title="13. Side Roller (B3 Tunnel A Lower Middle)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 74.68%; top: 67.87%;" onclick="scrollToRollerRow(14)" title="14. Side Roller (B3 Tunnel B Lower Outer Front)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 50.80%; top: 81.83%;" onclick="scrollToRollerRow(15)" title="15. Tandem Roller (B3 Tunnel A Lower Front)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 69.43%; top: 75.08%;" onclick="scrollToRollerRow(16)" title="16. Tandem Roller (B3 Tunnel B Lower Front)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.97%; top: 81.68%;" onclick="scrollToRollerRow(17)" title="17. Nosing Ramp"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 81.29%; top: 65.62%;" onclick="scrollToRollerRow(18)" title="18. Nosing Ramp"></button>' .
            '</div>' .
            
            // Component Detail Sheets Alpine Tab Container
            '<div x-data="{ activeTab: 1 }" @switch-detail-tab.window="activeTab = $event.detail.tab" class="my-6 border border-slate-200 rounded-xl bg-slate-50/50 p-4 shadow-sm">' .
            '  <!-- Tab Headers -->' .
            '  <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-3 mb-4 text-[10px] font-bold text-slate-500">' .
            '    <button type="button" @click="activeTab = 1" :class="activeTab === 1 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none">' .
            '        Detail B2 (Roller 1-6)' .
            '    </button>' .
            '    <button type="button" @click="activeTab = 2" :class="activeTab === 2 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none">' .
            '        Detail B3 - Bagian 1 (Roller 7-12)' .
            '    </button>' .
            '    <button type="button" @click="activeTab = 3" :class="activeTab === 3 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none">' .
            '        Detail B3 - Bagian 2 (Roller 13-16)' .
            '    </button>' .
            '  </div>' .

            '  <!-- Tab Contents -->' .
            '  <!-- Tab 1: reference_B2.png (B2 - Roller 1 to 6) -->' .
            '  <div x-show="activeTab === 1" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm aspect-[1073/1466] max-w-xs select-none">' .
            '    <img src="/images/modules/TunnelRoller/reference_B2.png" class="w-full h-full object-cover rounded-lg" alt="Reference B2 Rollers">' .
            '    <button type="button" id="roller-hotspot-1" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.32%; top: 37.93%;" onclick="scrollToRollerRow(1)" title="1. Fixed Roller (B2 Upper Rear)"></button>' .
            '    <button type="button" id="roller-hotspot-2" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.60%; top: 33.83%;" onclick="scrollToRollerRow(2)" title="2. Side Roller (B2 Lower Outer Front)"></button>' .
            '    <button type="button" id="roller-hotspot-3" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.32%; top: 70.94%;" onclick="scrollToRollerRow(3)" title="3. Tandem Roller (B2 Lower Front)"></button>' .
            '    <button type="button" id="roller-hotspot-5" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.76%; top: 70.80%;" onclick="scrollToRollerRow(5)" title="5. Fixed Roller (B2 Upper Front)"></button>' .
            '    <button type="button" id="roller-hotspot-6" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 34.30%; top: 90.59%;" onclick="scrollToRollerRow(6)" title="6. Fixed Roller (B2 Lower Rear)"></button>' .
            '  </div>' .

            '  <!-- Tab 2: reference_B3.png (B3 - Roller 7 to 12) -->' .
            '  <div x-show="activeTab === 2" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm aspect-[1037/1517] max-w-xs select-none">' .
            '    <img src="/images/modules/TunnelRoller/reference_B3.png" class="w-full h-full object-cover rounded-lg" alt="Reference B3 Rollers Part 1">' .
            '    <button type="button" id="roller-hotspot-7" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 6.17%; top: 33.49%;" onclick="scrollToRollerRow(7)" title="7. Fixed Roller (B3 Upper Rear)"></button>' .
            '    <button type="button" id="roller-hotspot-8" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.95%; top: 43.51%;" onclick="scrollToRollerRow(8)" title="8. Fixed Roller (B3 Upper Front)"></button>' .
            '    <button type="button" id="roller-hotspot-9" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.45%; top: 66.58%;" onclick="scrollToRollerRow(9)" title="9. Fixed Roller (B3 Lower Rear)"></button>' .
            '    <button type="button" id="roller-hotspot-10" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 62.87%; top: 67.50%;" onclick="scrollToRollerRow(10)" title="10. Fixed Roller (B3 Upper Rear)"></button>' .
            '    <button type="button" id="roller-hotspot-11" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 7.91%; top: 97.17%;" onclick="scrollToRollerRow(11)" title="11. Fixed Roller (B3 Upper Front)"></button>' .
            '    <button type="button" id="roller-hotspot-12" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 63.84%; top: 96.64%;" onclick="scrollToRollerRow(12)" title="12. Fixed Roller (B3 Lower Rear)"></button>' .
            '  </div>' .

            '  <!-- Tab 3: reference_B3(2).png (B3 - Roller 13 to 16) -->' .
            '  <div x-show="activeTab === 3" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm aspect-[1397/1126] max-w-sm select-none">' .
            '    <img src="/images/modules/TunnelRoller/reference_B3(2).png" class="w-full h-full object-cover rounded-lg" alt="Reference B3 Rollers Part 2">' .
            '    <button type="button" id="roller-hotspot-13" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 6.44%; top: 44.58%;" onclick="scrollToRollerRow(13)" title="13. Side Roller (B3 Lower Middle)"></button>' .
            '    <button type="button" id="roller-hotspot-14" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.98%; top: 45.12%;" onclick="scrollToRollerRow(14)" title="14. Side Roller (B3 Lower Outer Front)"></button>' .
            '    <button type="button" id="roller-hotspot-15" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 6.30%; top: 91.83%;" onclick="scrollToRollerRow(15)" title="15. Tandem Roller (B3 Lower Front)"></button>' .
            '    <button type="button" id="roller-hotspot-16" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition duration-300 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.70%; top: 92.01%;" onclick="scrollToRollerRow(16)" title="16. Tandem Roller (B3 Lower Front)"></button>' .
            '  </div>' .
            '</div>' .
            
            // Tunnel Roller Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="roller-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">1AT001AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B2 - Tunnel A - Upper Rear)</td></tr>' .
            '<tr id="roller-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">1AT005AM</td><td class="p-2.5">Side Roller Unit Assembly (B2 - Tunnel A - Lower Outer Front)</td></tr>' .
            '<tr id="roller-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">1AT006AM</td><td class="p-2.5">Tandem Roller Unit Assy. (B2 - Tunnel A - Lower Front)</td></tr>' .
            '<tr id="roller-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">1AT011CM</td><td class="p-2.5">Nosing Ramp</td></tr>' .
            '<tr id="roller-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">1AT023AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B2 - Tunnel A - Upper Front)</td></tr>' .
            '<tr id="roller-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">1AT024AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B2 - Tunnel A - Lower Rear)</td></tr>' .
            '<tr id="roller-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">2AT025AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel A - Upper Rear)</td></tr>' .
            '<tr id="roller-row-8" class="transition duration-300"><td class="p-2.5 text-center font-bold">8</td><td class="p-2.5 font-mono">2AT026AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel A - Upper Front)</td></tr>' .
            '<tr id="roller-row-9" class="transition duration-300"><td class="p-2.5 text-center font-bold">9</td><td class="p-2.5 font-mono">2AT027AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel A - Lower Rear)</td></tr>' .
            '<tr id="roller-row-10" class="transition duration-300"><td class="p-2.5 text-center font-bold">10</td><td class="p-2.5 font-mono">2BT017AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel B - Upper Rear)</td></tr>' .
            '<tr id="roller-row-11" class="transition duration-300"><td class="p-2.5 text-center font-bold">11</td><td class="p-2.5 font-mono">2BT018AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel B - Upper Front)</td></tr>' .
            '<tr id="roller-row-12" class="transition duration-300"><td class="p-2.5 text-center font-bold">12</td><td class="p-2.5 font-mono">2BT019AM</td><td class="p-2.5">Fixed Roller Unit Assembly (B3 - Tunnel B - Lower Rear)</td></tr>' .
            '<tr id="roller-row-13" class="transition duration-300"><td class="p-2.5 text-center font-bold">13</td><td class="p-2.5 font-mono">2AT029AM</td><td class="p-2.5">Side Roller Unit Assembly (B3 - Tunnel A - Lower Middle)</td></tr>' .
            '<tr id="roller-row-14" class="transition duration-300"><td class="p-2.5 text-center font-bold">14</td><td class="p-2.5 font-mono">2BT021AM</td><td class="p-2.5">Side Roller Unit Assembly (B3 - Tunnel B - Lower Outer Front)</td></tr>' .
            '<tr id="roller-row-15" class="transition duration-300"><td class="p-2.5 text-center font-bold">15</td><td class="p-2.5 font-mono">2AT030AM</td><td class="p-2.5">Tandem Roller Unit Assy. (B3 - Tunnel A - Lower Front)</td></tr>' .
            '<tr id="roller-row-16" class="transition duration-300"><td class="p-2.5 text-center font-bold">16</td><td class="p-2.5 font-mono">2BT022AM</td><td class="p-2.5">Tandem Roller Unit Assy. (B3 - Tunnel B - Lower Front)</td></tr>' .
            '<tr id="roller-row-17" class="transition duration-300"><td class="p-2.5 text-center font-bold">17</td><td class="p-2.5 font-mono">2AT031CM</td><td class="p-2.5">Nosing Ramp</td></tr>' .
            '<tr id="roller-row-18" class="transition duration-300"><td class="p-2.5 text-center font-bold">18</td><td class="p-2.5 font-mono">2BT023CM</td><td class="p-2.5">Nosing Ramp</td></tr>' .
            '<tr id="roller-row-19" class="transition duration-300"><td class="p-2.5 text-center font-bold">19</td><td class="p-2.5 font-mono">2BT100CM</td><td class="p-2.5">Wall Glass</td></tr>' .
            '<tr id="roller-row-20" class="transition duration-300"><td class="p-2.5 text-center font-bold">20</td><td class="p-2.5 font-mono">2BT101CM</td><td class="p-2.5">Handrail</td></tr>' .
            '<tr id="roller-row-21" class="transition duration-300"><td class="p-2.5 text-center font-bold">21</td><td class="p-2.5 font-mono">2BT102CM</td><td class="p-2.5">Tunnel Carpet</td></tr>' .
            '</tbody></table></div>';

        // 5.1.3 Cable carriage device
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.3. Cable carriage device</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Cable carriage device. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1068:1473 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1068/1473] max-w-sm select-none">' .
            '<img src="/images/modules/5.1.3.cable.png" class="w-full h-full object-cover rounded-lg" alt="Cable Carriage Device Technical Drawing">' .
            
            // Hotspot for circle 1
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 61.05%; top: 59.88%;" onclick="scrollToCableRow(1)" title="1. Scissor Cable Assembly"></button>' .
            '</div>' .
            
            // Cable carriage device Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="cable-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OCS100CM</td><td class="p-2.5">Scissor Cable Assembly</td></tr>' .
            '</tbody></table></div>';

        // 5.1.4 Vertical lift column
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.4. Vertical lift column</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Vertical lift column. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1440:2560 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1440/2560] max-w-[280px] select-none">' .
            '<img src="/images/modules/5.1.4Vertical_lift_column.png" class="w-full h-full object-cover rounded-lg" alt="Vertical Lift Column Technical Drawing">' .
            
            // Hotspots mapping for 1 to 11
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 90.97%; top: 52.50%;" onclick="scrollToLiftRow(1)" title="1. Vertical Lift Column Assembly"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 5.39%;" onclick="scrollToLiftRow(2)" title="2. Motor Cover"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 71.39%; top: 22.50%;" onclick="scrollToLiftRow(3)" title="3. Horizontal Motor + Horizontal Motor Bracket + Chain Sprocket"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.33%; top: 93.98%;" onclick="scrollToLiftRow(4)" title="4. Pad Teflon Bearing Comp."></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 13.47%; top: 28.98%;" onclick="scrollToLiftRow(5)" title="5. Side Cover"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 59.72%; top: 26.09%;" onclick="scrollToLiftRow(6)" title="6. Proximity Switch"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 36.02%;" onclick="scrollToLiftRow(7)" title="7. Coupling system assy"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 39.77%;" onclick="scrollToLiftRow(8)" title="8. Upper Column Flange"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.33%; top: 51.25%;" onclick="scrollToLiftRow(9)" title="9. Bearing Thrust Assy /w Cup washer"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 65.08%;" onclick="scrollToLiftRow(10)" title="10. Ball Screw and Nut Assembly"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.47%; top: 81.95%;" onclick="scrollToLiftRow(11)" title="11. Nut Stopper"></button>' .
            '</div>' .
            
            // Vertical lift column Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="lift-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OLC001AM</td><td class="p-2.5">Vertical Lift Column Assembly.</td></tr>' .
            '<tr id="lift-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">OLC013CM</td><td class="p-2.5">Motor Cover</td></tr>' .
            '<tr id="lift-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">OLC101AM</td><td class="p-2.5">Horizontal Motor + Horizontal Motor Bracket + Chain Sprocket</td></tr>' .
            '<tr id="lift-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">OLC007CM</td><td class="p-2.5">Pad Teflon Bearing Comp.</td></tr>' .
            '<tr id="lift-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">OLC048CM</td><td class="p-2.5">Side Cover</td></tr>' .
            '<tr id="lift-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">*</td><td class="p-2.5">Proximity Switch</td></tr>' .
            '<tr id="lift-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">OLC102AM</td><td class="p-2.5">Coupling system assy</td></tr>' .
            '<tr id="lift-row-8" class="transition duration-300"><td class="p-2.5 text-center font-bold">8</td><td class="p-2.5 font-mono">OLC103AM</td><td class="p-2.5">Upper Column Flange</td></tr>' .
            '<tr id="lift-row-9" class="transition duration-300"><td class="p-2.5 text-center font-bold">9</td><td class="p-2.5 font-mono">OLC104AM</td><td class="p-2.5">Bearing Thrust Assy /w Cup washer</td></tr>' .
            '<tr id="lift-row-10" class="transition duration-300"><td class="p-2.5 text-center font-bold">10</td><td class="p-2.5 font-mono">OLC006AM</td><td class="p-2.5">Ball Screw and Nut Assembly.</td></tr>' .
            '<tr id="lift-row-11" class="transition duration-300"><td class="p-2.5 text-center font-bold">11</td><td class="p-2.5 font-mono">OLC011CM</td><td class="p-2.5">Nut Stopper</td></tr>' .
            '</tbody></table></div>' .
            '<p class="text-[10px] text-slate-400 mt-1 italic">Catatan: * Kode part lihat di daftar komponen elektrikal.</p>';

        // 5.1.5 Wheel Bogie Assembly
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.5. Wheel Bogie Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Wheel Bogie Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 864:1217 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[864/1217] max-w-sm select-none">' .
            '<img src="/images/modules/5.1.5.Wheel_Bogie_Assembly.png" class="w-full h-full object-cover rounded-lg" alt="Wheel Bogie Assembly Technical Drawing">' .
            
            // Hotspots mapping for 1 to 19
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 31.25%; top: 86.28%;" onclick="scrollToBogieRow(1)" title="1. Potentiometer Assy /w Cover"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 15.74%; top: 71.98%;" onclick="scrollToBogieRow(2)" title="2. Boogie Frame"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 18.75%; top: 40.10%;" onclick="scrollToBogieRow(3)" title="3. Thrust Bearing /w Clamp"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 37.50%; top: 58.01%;" onclick="scrollToBogieRow(4)" title="4. Swiveling Column"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 15.74%; top: 34.02%;" onclick="scrollToBogieRow(5)" title="5. Tyre Complete"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 61.81%; top: 25.80%;" onclick="scrollToBogieRow(6)" title="6. Horizontal Motor"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 63.43%; top: 42.89%;" onclick="scrollToBogieRow(7)" title="7. Carriage Frame Shaft"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 61.57%; top: 48.48%;" onclick="scrollToBogieRow(8)" title="8. Carriage Frame"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 54.65%; top: 64.75%;" onclick="scrollToBogieRow(9)" title="9. Drive System (Chain and Sprocket)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 35.42%; top: 1.48%;" onclick="scrollToBogieRow(10)" title="10. Chain Cover"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 82.18%; top: 69.35%;" onclick="scrollToBogieRow(11)" title="11. Solid Tyre"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 86.81%; top: 73.62%;" onclick="scrollToBogieRow(12)" title="12. Wheel Rim"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 66.20%; top: 53.25%;" onclick="scrollToBogieRow(13)" title="13. Oil Seal"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 70.83%; top: 53.57%;" onclick="scrollToBogieRow(14)" title="14. Bushing Oil Seal"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 86.57%; top: 61.79%;" onclick="scrollToBogieRow(15)" title="15. Wheel Hub /w Roller Bearing"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 59.03%; top: 94.66%;" onclick="scrollToBogieRow(16)" title="16. Wheel Cover"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 62.96%; top: 97.95%;" onclick="scrollToBogieRow(17)" title="17. Hub Cap"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 52.78%; top: 89.73%;" onclick="scrollToBogieRow(18)" title="18. Landing Gear"></button>' .
            '</div>' .
            
            // Wheel Bogie Assembly Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="bogie-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OLC102AE</td><td class="p-2.5">Potentiometer Assy /w Cover</td></tr>' .
            '<tr id="bogie-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">OLC105AM</td><td class="p-2.5">Boogie Frame</td></tr>' .
            '<tr id="bogie-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">OLC106AM</td><td class="p-2.5">Thrust Bearing /w Clamp</td></tr>' .
            '<tr id="bogie-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">OLC107AM</td><td class="p-2.5">Swiveling Column</td></tr>' .
            '<tr id="bogie-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">OLC023CM</td><td class="p-2.5">Tyre Complete</td></tr>' .
            '<tr id="bogie-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">OLC108CM</td><td class="p-2.5">Horizontal Motor</td></tr>' .
            '<tr id="bogie-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">OLC025CM</td><td class="p-2.5">Carriage Frame Shaft</td></tr>' .
            '<tr id="bogie-row-8" class="transition duration-300"><td class="p-2.5 text-center font-bold">8</td><td class="p-2.5 font-mono">OLC100AM</td><td class="p-2.5">Carriage Frame</td></tr>' .
            '<tr id="bogie-row-9" class="transition duration-300"><td class="p-2.5 text-center font-bold">9</td><td class="p-2.5 font-mono">OLC109AM</td><td class="p-2.5">Drive System (Chain and Sprocket)</td></tr>' .
            '<tr id="bogie-row-10" class="transition duration-300"><td class="p-2.5 text-center font-bold">10</td><td class="p-2.5 font-mono">OLC017CM</td><td class="p-2.5">Chain Cover</td></tr>' .
            '<tr id="bogie-row-11" class="transition duration-300"><td class="p-2.5 text-center font-bold">11</td><td class="p-2.5 font-mono">OLC110SM</td><td class="p-2.5">Solid Tyre</td></tr>' .
            '<tr id="bogie-row-12" class="transition duration-300"><td class="p-2.5 text-center font-bold">12</td><td class="p-2.5 font-mono">OLC111AM</td><td class="p-2.5">Wheel Rim</td></tr>' .
            '<tr id="bogie-row-13" class="transition duration-300"><td class="p-2.5 text-center font-bold">13</td><td class="p-2.5 font-mono">OLC019CM</td><td class="p-2.5">Oil Seal</td></tr>' .
            '<tr id="bogie-row-14" class="transition duration-300"><td class="p-2.5 text-center font-bold">14</td><td class="p-2.5 font-mono">OLC032CM</td><td class="p-2.5">Bushing Oil Seal</td></tr>' .
            '<tr id="bogie-row-15" class="transition duration-300"><td class="p-2.5 text-center font-bold">15</td><td class="p-2.5 font-mono">OLC112AM</td><td class="p-2.5">Wheel Hub /w Roller Bearing</td></tr>' .
            '<tr id="bogie-row-16" class="transition duration-300"><td class="p-2.5 text-center font-bold">16</td><td class="p-2.5 font-mono">OLC026CM</td><td class="p-2.5">Wheel Cover</td></tr>' .
            '<tr id="bogie-row-17" class="transition duration-300"><td class="p-2.5 text-center font-bold">17</td><td class="p-2.5 font-mono">OLC024CM</td><td class="p-2.5">Hub Cap</td></tr>' .
            '<tr id="bogie-row-18" class="transition duration-300"><td class="p-2.5 text-center font-bold">18</td><td class="p-2.5 font-mono">OLC052AM</td><td class="p-2.5">Landing Gear</td></tr>' .
            '<tr id="bogie-row-19" class="transition duration-300"><td class="p-2.5 text-center font-bold">19</td><td class="p-2.5 font-mono">OLC113AM</td><td class="p-2.5">Safety Hoop</td></tr>' .
            '</tbody></table></div>' .
            '<p class="text-[10px] text-slate-400 mt-1 italic">Catatan: * Kode part harap lihat di daftar komponen elektrikal.</p>';

        // 5.1.6 Landing Stair
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.6. Landing Stair</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Landing Stair. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1664:2536 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1664/2536] max-w-sm select-none">' .
            '<img src="/images/modules/5.1.6.Landing_Stair.png" class="w-full h-full object-cover rounded-lg" alt="Landing Stair Technical Drawing">' .
            
            // Hotspots mapping for 1 to 10 (Sized w-6 h-6 to match the larger circles on drawing)
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 88.40%; top: 10.76%;" onclick="scrollToStairRow(1)" title="1. Door Closer"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 88.40%; top: 17.11%;" onclick="scrollToStairRow(2)" title="2. Service Door Assembly"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 47.00%; top: 3.51%;" onclick="scrollToStairRow(3)" title="3. Roof Ladder 1"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 88.40%; top: 28.12%;" onclick="scrollToStairRow(4)" title="4. Lock Unit & door handle"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 51.92%; top: 3.47%;" onclick="scrollToStairRow(5)" title="5. Roof Ladder 2"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.19%; top: 90.14%;" onclick="scrollToStairRow(6)" title="6. Castor Wheel"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 37.38%; top: 14.67%;" onclick="scrollToStairRow(7)" title="7. Hand Rail 2"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.57%; top: 7.26%;" onclick="scrollToStairRow(8)" title="8. Hand Rail 3"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 18.39%; top: 48.03%;" onclick="scrollToStairRow(9)" title="9. Hand Rail 1"></button>' .
            '<button type="button" class="absolute w-6 h-6 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 26.38%; top: 43.85%;" onclick="scrollToStairRow(10)" title="10. Step Plate"></button>' .
            '</div>' .
            
            // Landing Stair Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="stair-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OBB001SM</td><td class="p-2.5">Door Closer</td></tr>' .
            '<tr id="stair-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">OBB002AM</td><td class="p-2.5">Service Door Assembly</td></tr>' .
            '<tr id="stair-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">OST009CM</td><td class="p-2.5">Roof Ladder 1</td></tr>' .
            '<tr id="stair-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">OBB004CM</td><td class="p-2.5">Lock Unit & door handle</td></tr>' .
            '<tr id="stair-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">OST010CM</td><td class="p-2.5">Roof Ladder 2</td></tr>' .
            '<tr id="stair-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">OST001CM</td><td class="p-2.5">Castor Wheel</td></tr>' .
            '<tr id="stair-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">OST007CM</td><td class="p-2.5">Hand Rail 2</td></tr>' .
            '<tr id="stair-row-8" class="transition duration-300"><td class="p-2.5 text-center font-bold">8</td><td class="p-2.5 font-mono">OST011CM</td><td class="p-2.5">Hand Rail 3</td></tr>' .
            '<tr id="stair-row-9" class="transition duration-300"><td class="p-2.5 text-center font-bold">9</td><td class="p-2.5 font-mono">OST005CM</td><td class="p-2.5">Hand Rail 1</td></tr>' .
            '<tr id="stair-row-10" class="transition duration-300"><td class="p-2.5 text-center font-bold">10</td><td class="p-2.5 font-mono">OST006CM</td><td class="p-2.5">Step Plate</td></tr>' .
            '</tbody></table></div>';

        // 5.1.7 Cabin Rotation
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.7. Cabin Rotation</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Cabin Rotation. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1824:2328 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1824/2328] max-w-sm select-none">' .
            '<img src="/images/modules/5.1.7.Cabin_Rotation.png" class="w-full h-full object-cover rounded-lg" alt="Cabin Rotation Technical Drawing">' .
            
            // Hotspots mapping for 1 to 4
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 16.67%; top: 31.62%;" onclick="scrollToRotationRow(1)" title="1. Rotation Drive System"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 66.45%; top: 55.41%;" onclick="scrollToRotationRow(2)" title="2. Bracket Mounting Motor"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 80.37%; top: 84.62%;" onclick="scrollToRotationRow(3)" title="3. Drive Unit Cabin Rotation"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 89.47%; top: 19.16%;" onclick="scrollToRotationRow(4)" title="4. Safety Door Shoe"></button>' .
            '</div>' .
            
            // Cabin Rotation Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="rotation-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OCB106AM</td><td class="p-2.5">Rotation Drive System</td></tr>' .
            '<tr id="rotation-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">OCB062SM</td><td class="p-2.5">Bracket Mounting Motor</td></tr>' .
            '<tr id="rotation-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">OCB105SM</td><td class="p-2.5">Drive Unit Cabin Rotation</td></tr>' .
            '<tr id="rotation-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">OCB103SM</td><td class="p-2.5">Safety Door Shoe</td></tr>' .
            '</tbody></table></div>' .
            '<p class="text-[10px] text-slate-400 mt-1 italic">Catatan: * Kode part harap lihat di daftar komponen elektrikal.</p>';

        // 5.1.8 Cabin Curtain Assembly
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.8. Cabin Curtain Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Cabin Curtain Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1536:2304 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1536/2304] max-w-sm select-none">' .
            '<img src="/images/modules/5.1.8.Cabin_Curtain_Assembly.png" class="w-full h-full object-cover rounded-lg" alt="Cabin Curtain Assembly Technical Drawing">' .
            
            // Hotspots mapping for 1 to 11
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 70.44%; top: 75.00%;" onclick="scrollToCurtainRow(1)" title="1. Roller I Cabin Rotation Ass\'y"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 55.60%; top: 97.31%;" onclick="scrollToCurtainRow(2)" title="2. Roller Cabin Lateral"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 82.55%; top: 73.44%;" onclick="scrollToCurtainRow(3)" title="3. Roller Cabin"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 69.92%; top: 9.46%;" onclick="scrollToCurtainRow(4)" title="4. Slat Curtain (with Glass)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 18.88%; top: 57.73%;" onclick="scrollToCurtainRow(5)" title="5. Slat Curtain (without glass)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 55.21%; top: 78.12%;" onclick="scrollToCurtainRow(6)" title="6. Bearing Housing"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 32.16%; top: 56.94%;" onclick="scrollToCurtainRow(7)" title="7. Barrel Curtain"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 91.28%; top: 16.15%;" onclick="scrollToCurtainRow(8)" title="8. Cover Side Curtain R/L (Top)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 91.28%; top: 58.77%;" onclick="scrollToCurtainRow(8)" title="8. Cover Side Curtain R/L (Bottom)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 35.29%; top: 2.26%;" onclick="scrollToCurtainRow(9)" title="9. Worm Gear Assembly (Top)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 64.84%; top: 66.93%;" onclick="scrollToCurtainRow(9)" title="9. Worm Gear Assembly (Bottom)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.68%; top: 2.26%;" onclick="scrollToCurtainRow(10)" title="10. Roller (Top)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 57.42%; top: 70.40%;" onclick="scrollToCurtainRow(10)" title="10. Roller (Bottom)"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 33.20%; top: 67.10%;" onclick="scrollToCurtainRow(11)" title="11. Plate Curtain Cabin"></button>' .
            '</div>' .
            
            // Cabin Curtain Assembly Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="curtain-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OCB006AM</td><td class="p-2.5">Roller I Cabin Rotation Ass\'y</td></tr>' .
            '<tr id="curtain-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">OCB007AM</td><td class="p-2.5">Roller Cabin Lateral</td></tr>' .
            '<tr id="curtain-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">OCB008AM</td><td class="p-2.5">Roller Cabin</td></tr>' .
            '<tr id="curtain-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">OCB085AM</td><td class="p-2.5">Slat Curtain (with Glass)</td></tr>' .
            '<tr id="curtain-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">OCB055CM</td><td class="p-2.5">Slat Curtain (without glass)</td></tr>' .
            '<tr id="curtain-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">OCB096SM</td><td class="p-2.5">Bearing Housing</td></tr>' .
            '<tr id="curtain-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">OCB012AM</td><td class="p-2.5">Barrel Curtain</td></tr>' .
            '<tr id="curtain-row-8" class="transition duration-300"><td class="p-2.5 text-center font-bold">8</td><td class="p-2.5 font-mono">OCB021CM</td><td class="p-2.5">Cover Side Curtain R/L</td></tr>' .
            '<tr id="curtain-row-9" class="transition duration-300"><td class="p-2.5 text-center font-bold">9</td><td class="p-2.5 font-mono">OCB020AM</td><td class="p-2.5">Worm Gear Assembly</td></tr>' .
            '<tr id="curtain-row-10" class="transition duration-300"><td class="p-2.5 text-center font-bold">10</td><td class="p-2.5 font-mono">OCB019AM</td><td class="p-2.5">Roller</td></tr>' .
            '<tr id="curtain-row-11" class="transition duration-300"><td class="p-2.5 text-center font-bold">11</td><td class="p-2.5 font-mono">OCB017CM</td><td class="p-2.5">Plate Curtain Cabin</td></tr>' .
            '</tbody></table></div>';

        // 5.1.9 Auto Leveler Assembly
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.9. Auto Leveler Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Auto Leveler Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 2318:1824 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[2318/1824] max-w-md select-none">' .
            '<img src="/images/modules/5.1.9.Auto_Leverel_Assembly.png" class="w-full h-full object-cover rounded-lg" alt="Auto Leveler Assembly Technical Drawing">' .
            
            // Hotspots mapping for 1 to 2
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 67.30%; top: 76.64%;" onclick="scrollToLevelerRow(1)" title="1. Autolevel Assembly"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 47.71%; top: 24.89%;" onclick="scrollToLevelerRow(2)" title="2. Actuator Motor 4\""></button>' .
            '</div>' .
            
            // Auto Leveler Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="leveler-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OCB045AM</td><td class="p-2.5">Autolevel Assembly</td></tr>' .
            '<tr id="leveler-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">*</td><td class="p-2.5">Actuator Motor 4"</td></tr>' .
            '</tbody></table></div>' .
            '<p class="text-[10px] text-slate-400 mt-1 italic">Catatan: * Kode part harap lihat di daftar komponen elektrikal.</p>';

        // 5.1.10 Aircraft/Canopy Closure
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.10. Aircraft/Canopy Closure</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Aircraft/Canopy Closure. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1632:2176 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1632/2176] max-w-xs select-none">' .
            '<img src="/images/modules/5.1.10.Aircraft_Closure.png" class="w-full h-full object-cover rounded-lg" alt="Aircraft/Canopy Closure Technical Drawing">' .
            
            // Hotspots mapping for 1 to 7
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 4.04%; top: 31.25%;" onclick="scrollToClosureRow(1)" title="1. Pad Closure"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 9.93%; top: 3.49%;" onclick="scrollToClosureRow(2)" title="2. Aircraft Closure Ass\'y"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 86.89%; top: 29.50%;" onclick="scrollToClosureRow(3)" title="3. Canopy Actuator"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 37.38%; top: 31.53%;" onclick="scrollToClosureRow(4)" title="4. Cover Aircraft Closure Right"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 41.30%; top: 31.53%;" onclick="scrollToClosureRow(5)" title="5. Cover Aircraft closure Left"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 56.99%; top: 97.52%;" onclick="scrollToClosureRow(6)" title="6. Closure Arm Ass\'y Right"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.78%; top: 97.52%;" onclick="scrollToClosureRow(7)" title="7. Closure Arm Ass\'y Left"></button>' .
            '</div>' .
            
            // Aircraft Closure Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="closure-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OCB107AM</td><td class="p-2.5">Pad Closure</td></tr>' .
            '<tr id="closure-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">OCB037CM</td><td class="p-2.5">Aircraft Closure Ass\'y</td></tr>' .
            '<tr id="closure-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">OCB108AM</td><td class="p-2.5">Canopy Actuator</td></tr>' .
            '<tr id="closure-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">OCB053CM</td><td class="p-2.5">Cover Aircraft Closure Right</td></tr>' .
            '<tr id="closure-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">OCB040CM</td><td class="p-2.5">Cover Aircraft closure Left</td></tr>' .
            '<tr id="closure-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">OCB041CM</td><td class="p-2.5">Closure Arm Ass\'y Right</td></tr>' .
            '<tr id="closure-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">OCB078CM</td><td class="p-2.5">Closure Arm Ass\'y Left</td></tr>' .
            '</tbody></table></div>' .
            '<p class="text-[10px] text-slate-400 mt-1 italic">Catatan: * Kode part harap lihat di daftar komponen elektrikal.</p>';

        // 5.1.11 Swing Door and Window Assembly
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.11. Swing Door and Window Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Swing Door and Window Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1632:2176 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1632/2176] max-w-xs select-none">' .
            '<img src="/images/modules/5.1.11.Swing_door.png" class="w-full h-full object-cover rounded-lg" alt="Swing Door and Window Assembly Technical Drawing">' .
            
            // Hotspots mapping for 1 to 8
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 79.29%; top: 5.70%;" onclick="scrollToSwingRow(1)" title="1. Left Side Shield Glass"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 60.60%; top: 25.87%;" onclick="scrollToSwingRow(2)" title="2. Front Shield Glass"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 59.38%; top: 50.74%;" onclick="scrollToSwingRow(3)" title="3. Bumper"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 36.50%; top: 32.70%;" onclick="scrollToSwingRow(4)" title="4. Right Side Glass"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 7.29%; top: 62.36%;" onclick="scrollToSwingRow(5)" title="5. Door Leaf Assy"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 7.29%; top: 57.86%;" onclick="scrollToSwingRow(6)" title="6. Lock System"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 84.07%; top: 31.53%;" onclick="scrollToSwingRow(7)" title="7. Safety Rope"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 36.34%; top: 75.60%;" onclick="scrollToSwingRow(8)" title="8. Door Handle"></button>' .
            '</div>' .
            
            // Swing Door Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="swing-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OCB032SM</td><td class="p-2.5">Left Side Shield Glass</td></tr>' .
            '<tr id="swing-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">OCB029SM</td><td class="p-2.5">Front Shield Glass</td></tr>' .
            '<tr id="swing-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">OCB028CM</td><td class="p-2.5">Bumper</td></tr>' .
            '<tr id="swing-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">OCB034SM</td><td class="p-2.5">Right Side Glass</td></tr>' .
            '<tr id="swing-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">OCB036SM</td><td class="p-2.5">Door Leaf Assy</td></tr>' .
            '<tr id="swing-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">OCB042CM</td><td class="p-2.5">Lock System</td></tr>' .
            '<tr id="swing-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">OCB101SM</td><td class="p-2.5">Safety Rope</td></tr>' .
            '<tr id="swing-row-8" class="transition duration-300"><td class="p-2.5 text-center font-bold">8</td><td class="p-2.5 font-mono">OCB109AM</td><td class="p-2.5">Door Handle</td></tr>' .
            '</tbody></table></div>' .
            '<p class="text-[10px] text-slate-400 mt-1 italic">Catatan: * Kode part harap lihat di daftar komponen elektrikal.</p>';

        // 5.1.12. Rubber Weathering
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.12. Rubber Weathering</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Rubber Weathering. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 1632:2176 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[1632/2176] max-w-xs select-none">' .
            '<img src="/images/modules/5.1.12.Rubber_Weathering.png" class="w-full h-full object-cover rounded-lg" alt="Rubber Weathering Technical Drawing">' .
            
            // Hotspots mapping for 1 to 12
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 14.52%; top: 75.60%;" onclick="scrollToWeatheringRow(1)" title="1. Rigid Frame Weathering"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 8.27%; top: 88.28%;" onclick="scrollToWeatheringRow(2)" title="2. Weathering Corner Upper"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 31.74%; top: 95.82%;" onclick="scrollToWeatheringRow(3)" title="3. Rigid Frame Weathering"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 58.64%; top: 95.36%;" onclick="scrollToWeatheringRow(4)" title="4. Weathering Corner Lower"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 49.69%; top: 68.70%;" onclick="scrollToWeatheringRow(5)" title="5. Rigid Frame Weathering"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 8.21%; top: 71.92%;" onclick="scrollToWeatheringRow(6)" title="6. Weathering Corner Upper"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 23.04%; top: 56.11%;" onclick="scrollToWeatheringRow(7)" title="7. Rubber Black"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 70.04%; top: 92.23%;" onclick="scrollToWeatheringRow(8)" title="8. Upper Rotunda Weathering"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 48.10%; top: 24.13%;" onclick="scrollToWeatheringRow(9)" title="9. Inside Weathering"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 77.63%; top: 71.28%;" onclick="scrollToWeatheringRow(9)" title="9. Inside Weathering"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 90.99%; top: 52.25%;" onclick="scrollToWeatheringRow(10)" title="10. Inside Weathering"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 77.88%; top: 23.67%;" onclick="scrollToWeatheringRow(11)" title="11. Upper Bubble Weathering"></button>' .
            '<button type="button" class="absolute w-4 h-4 rounded-full border-2 border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 46.08%; top: 16.68%;" onclick="scrollToWeatheringRow(12)" title="12. Inside Weathering"></button>' .
            '</div>' .
            
            // Rubber Weathering Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="weathering-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OAT014CM</td><td class="p-2.5">Rigid Frame Weathering</td></tr>' .
            '<tr id="weathering-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">OAT012CM</td><td class="p-2.5">Weathering Corner Upper</td></tr>' .
            '<tr id="weathering-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">OAT013CM</td><td class="p-2.5">Rigid Frame Weathering</td></tr>' .
            '<tr id="weathering-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">OAT015CM</td><td class="p-2.5">Weathering Corner Lower</td></tr>' .
            '<tr id="weathering-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">OAT016CM</td><td class="p-2.5">Rigid Frame Weathering</td></tr>' .
            '<tr id="weathering-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">OBT001CM</td><td class="p-2.5">Weathering Corner Upper</td></tr>' .
            '<tr id="weathering-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">OBT003CM</td><td class="p-2.5">Rubber Black</td></tr>' .
            '<tr id="weathering-row-8" class="transition duration-300"><td class="p-2.5 text-center font-bold">8</td><td class="p-2.5 font-mono">ORT019CM</td><td class="p-2.5">Upper Rotunda Weathering</td></tr>' .
            '<tr id="weathering-row-9" class="transition duration-300"><td class="p-2.5 text-center font-bold">9</td><td class="p-2.5 font-mono">OBT005CM</td><td class="p-2.5">Inside Weathering</td></tr>' .
            '<tr id="weathering-row-10" class="transition duration-300"><td class="p-2.5 text-center font-bold">10</td><td class="p-2.5 font-mono">OAT017CM</td><td class="p-2.5">Inside Weathering</td></tr>' .
            '<tr id="weathering-row-11" class="transition duration-300"><td class="p-2.5 text-center font-bold">11</td><td class="p-2.5 font-mono">OBB005SM</td><td class="p-2.5">Upper Bubble Weathering</td></tr>' .
            '<tr id="weathering-row-12" class="transition duration-300"><td class="p-2.5 text-center font-bold">12</td><td class="p-2.5 font-mono">OBT004CM</td><td class="p-2.5">Inside Weathering</td></tr>' .
            '</tbody></table></div>' .
            '<p class="text-[10px] text-slate-400 mt-1 italic">Catatan: * Kode part harap lihat di daftar komponen elektrikal.</p>' .
            '<p class="text-[10px] text-red-500 font-semibold mt-1">CATATAN: Harap cantumkan tipe dari garbarata dan tunnel untuk setiap pemesanan weathering</p>';

        // 5.1.13. Wire Rope Equalizer
        $content .= '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.13. Wire Rope Equalizer</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Wire Rope Equalizer. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Interactive Diagram Container (Aspect ratio matched to 2176:1632 image)
            '<div class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm my-6 aspect-[2176/1632] w-full select-none" style="max-width: 440px;">' .
            '<img src="/images/modules/5.1.13.Wire_Rope_Equalizer.png" class="w-full h-full object-cover rounded-lg" alt="Wire Rope Equalizer Technical Drawing">' .
            
            // Hotspots mapping for 1 to 6 (including duplicate circles for 1 and 2, sized to match drawing circles)
            '<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 91.00%; top: 39.00%;" onclick="scrollToEqualizerRow(1)" title="1. Wire Rope 1"></button>' .
            '<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 38.30%; top: 5.00%;" onclick="scrollToEqualizerRow(1)" title="1. Wire Rope 1"></button>' .
            '<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 93.90%; top: 39.00%;" onclick="scrollToEqualizerRow(2)" title="2. Wire Rope 2"></button>' .
            '<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 65.90%; top: 33.80%;" onclick="scrollToEqualizerRow(2)" title="2. Wire Rope 2"></button>' .
            '<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 3.70%; top: 80.50%;" onclick="scrollToEqualizerRow(3)" title="3. Drum Tension Ass\'y"></button>' .
            '<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 44.00%; top: 44.00%;" onclick="scrollToEqualizerRow(4)" title="4. Cable Sheave Ass\'y"></button>' .
            '<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 35.10%; top: 63.10%;" onclick="scrollToEqualizerRow(5)" title="5. Cable Equalizer ass\'y, Detail B"></button>' .
            '<button type="button" class="absolute w-2.5 h-2.5 rounded-full border border-blue-400 bg-blue-500/10 shadow-inner transition hover:scale-110 hover:border-blue-600 hover:bg-blue-600/20 -translate-x-1/2 -translate-y-1/2 cursor-pointer focus:outline-none" style="left: 61.80%; top: 38.20%;" onclick="scrollToEqualizerRow(6)" title="6. Wire Rope Anchorage"></button>' .
            '</div>' .
            
            // Wire Rope Equalizer Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="equalizer-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">2BT013SM</td><td class="p-2.5">Wire Rope 1</td></tr>' .
            '<tr id="equalizer-row-2" class="transition duration-300"><td class="p-2.5 text-center font-bold">2</td><td class="p-2.5 font-mono">2BT017SM</td><td class="p-2.5">Wire Rope 2</td></tr>' .
            '<tr id="equalizer-row-3" class="transition duration-300"><td class="p-2.5 text-center font-bold">3</td><td class="p-2.5 font-mono">2BT001AM</td><td class="p-2.5">Drum Tension Ass\'y</td></tr>' .
            '<tr id="equalizer-row-4" class="transition duration-300"><td class="p-2.5 text-center font-bold">4</td><td class="p-2.5 font-mono">2BT006AM</td><td class="p-2.5">Cable Sheave Ass\'y</td></tr>' .
            '<tr id="equalizer-row-5" class="transition duration-300"><td class="p-2.5 text-center font-bold">5</td><td class="p-2.5 font-mono">2BT009AM</td><td class="p-2.5">Cable Equalizer ass\'y, Detail B</td></tr>' .
            '<tr id="equalizer-row-6" class="transition duration-300"><td class="p-2.5 text-center font-bold">6</td><td class="p-2.5 font-mono">2BT103AM</td><td class="p-2.5">Wire Rope Anchorage</td></tr>' .
            '<tr id="equalizer-row-7" class="transition duration-300"><td class="p-2.5 text-center font-bold">7</td><td class="p-2.5 font-mono">2BT016AM</td><td class="p-2.5">Cable Equalizer Ass\'y, Detail C</td></tr>' .
            '</tbody></table></div>' .
            '<p class="text-[10px] text-slate-400 mt-1 italic">Catatan: * Kode part harap lihat di daftar komponen elektrikal.</p>';

        // Save module 5.1
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1 Daftar Komponen',
            'content' => $content,
            'order' => 1,
        ]);

        // 5.2. Electrical parts and others
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.2. Electrical parts and others',
            'content' => '<div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 max-w-2xl mx-auto my-8 space-y-6">' .
                '    <div class="flex items-start gap-4">' .
                '        <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">' .
                '            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' .
                '                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/>' .
                '            </svg>' .
                '        </div>' .
                '        <div class="space-y-2">' .
                '            <h4 class="text-sm font-bold text-slate-800">Bagian Elektrikal (Electrical Parts)</h4>' .
                '            <p class="text-xs text-slate-600 leading-relaxed">' .
                '                Untuk bagian - bagian elektrikal, silahkan menuju ke ' .
                '                <a href="/courses/1/chapters/7" class="text-blue-600 hover:text-blue-800 font-bold underline transition inline-flex items-center gap-1">' .
                '                    lampiran 7' .
                '                    <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' .
                '                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>' .
                '                    </svg>' .
                '                </a>.' .
                '            </p>' .
                '        </div>' .
                '    </div>' .
                '</div>',
            'order' => 2,
        ]);

        // 5.3. Special Tools
        $toolsContent = '<p class="text-xs text-slate-600 leading-relaxed mb-4">' .
            'Berikut adalah daftar peralatan khusus (Special Tools) yang digunakan untuk perawatan dan pengaturan komponen Garbarata. ' .
            '<em class="text-blue-600 font-semibold">Klik pada masing-masing nama alat di bawah ini</em> untuk melihat gambar dan detail visualnya.</p>';

        $toolsContent .= '<div class="space-y-3 mt-6" id="special-tools-accordion">';

        $tools = [
            [
                'id' => 'tool-1',
                'title' => '5.3.1. Jacking stand',
                'img' => 'images/modules/5.3.SpecialTools/5.3.1.Jacking_Stand.png',
                'desc' => 'Penyangga dongkrak khusus yang digunakan untuk menopang struktur Garbarata saat melakukan perawatan roda atau sistem elevasi.'
            ],
            [
                'id' => 'tool-2',
                'title' => '5.3.2. Wrench for roller tunnel adjustment',
                'img' => 'images/modules/5.3.SpecialTools/5.3.2.Wrench_For_Roller.png',
                'desc' => 'Kunci pas khusus untuk menyetel posisi roller pada bagian terowongan (tunnel) agar pergerakan sliding lancar dan lurus.'
            ],
            [
                'id' => 'tool-3',
                'title' => '5.3.3. Tunner roller driver',
                'img' => 'images/modules/5.3.SpecialTools/5.3.3.Tunnel_Roller_Driver.png',
                'desc' => 'Pendorong/pengendali untuk pemasangan atau pembongkaran roller terowongan.'
            ],
            [
                'id' => 'tool-4',
                'title' => '5.3.4. Socket for curtain tension',
                'img' => 'images/modules/5.3.SpecialTools/5.3.4.Socket_For_Curtain_Tension.png',
                'desc' => 'Kunci soket khusus untuk memutar dan menyesuaikan ketegangan pegas pada tirai kabin/rotunda.'
            ],
            [
                'id' => 'tool-5',
                'title' => '5.3.5. Towing bar',
                'img' => 'images/modules/5.3.SpecialTools/5.3.5.Towing_bar.png',
                'desc' => 'Batang penarik darurat untuk memindahkan posisi Garbarata jika terjadi kegagalan sistem penggerak utama.'
            ],
            [
                'id' => 'tool-6',
                'title' => '5.3.6. Wrench for wheel boogie tyre',
                'img' => 'images/modules/5.3.SpecialTools/5.3.6.Wrench_For_Wheel.png',
                'desc' => 'Kunci pas besar yang dirancang khusus untuk melepas atau mengencangkan baut ban karet padat (solid tire) pada wheel boogie.'
            ],
            [
                'id' => 'tool-7',
                'title' => '5.3.7. Driver for flange lift column bolt',
                'img' => 'images/modules/5.3.SpecialTools/5.3.7.Driver_For_Flange.png',
                'desc' => 'Kunci penarik/penggerak khusus untuk baut flange pada tiang pengangkat utama (lift column).'
            ]
        ];

        foreach ($tools as $index => $tool) {
            $isFirst = $index === 0;
            $openAttr = $isFirst ? ' open' : '';

            $toolsContent .= '<details id="' . $tool['id'] . '" class="group rounded-xl border border-slate-200 bg-white shadow-sm overflow-hidden"' . $openAttr . '>';
            
            // Summary header
            $toolsContent .= '<summary class="flex items-center justify-between gap-3 cursor-pointer select-none px-5 py-4 ' .
                'bg-gradient-to-r from-slate-50 to-white hover:from-blue-50 hover:to-white ' .
                'transition-colors duration-200 list-none">';
            $toolsContent .= '<div class="flex items-center gap-3">';
            $toolsContent .= '<span class="flex-shrink-0 w-7 h-7 rounded-full bg-blue-600 text-white text-[11px] font-bold flex items-center justify-center shadow-sm">' .
                ($index + 1) . '</span>';
            $toolsContent .= '<span class="font-semibold text-slate-800 text-sm">' . htmlspecialchars($tool['title']) . '</span>';
            $toolsContent .= '</div>';
            // Chevron icon
            $toolsContent .= '<svg class="w-4 h-4 text-slate-400 transition-transform duration-300 group-open:rotate-180 flex-shrink-0" ' .
                'fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">' .
                '<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>';
            $toolsContent .= '</summary>';

            // Detail area (Image + Description)
            $toolsContent .= '<div class="border-t border-slate-100 bg-slate-50/50 p-5">';
            $toolsContent .= '<p class="text-xs text-slate-500 mb-4">' . htmlspecialchars($tool['desc']) . '</p>';
            $toolsContent .= '<div class="rounded-xl border border-slate-200 bg-white p-3 shadow-xs max-w-xl mx-auto">';
            $toolsContent .= '<img src="/' . $tool['img'] . '" class="w-full max-h-96 object-contain rounded-lg select-none" alt="' . htmlspecialchars($tool['title']) . '" loading="lazy">';
            $toolsContent .= '</div>';
            $toolsContent .= '</div>';
            $toolsContent .= '</details>';
        }

        $toolsContent .= '</div>';

        // Script for smooth open/close and auto-scroll
        $toolsContent .= '<script>' .
            'document.addEventListener("DOMContentLoaded", function() {' .
            '    var allDetails = document.querySelectorAll("#special-tools-accordion details");' .
            '    allDetails.forEach(function(det) {' .
            '        det.addEventListener("toggle", function() {' .
            '            if (det.open) {' .
            '                allDetails.forEach(function(other) {' .
            '                    if (other !== det && other.open) { other.removeAttribute("open"); }' .
            '                });' .
            '                setTimeout(function() {' .
            '                    det.scrollIntoView({ behavior: "smooth", block: "start" });' .
            '                }, 100);' .
            '            }' .
            '        });' .
            '    });' .
            '});' .
            '</script>';

        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.3. Special Tools',
            'content' => $toolsContent,
            'order' => 3,
        ]);
    }
}
