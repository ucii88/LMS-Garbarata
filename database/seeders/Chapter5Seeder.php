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
        // 5.1.1 Rotunda Assembly
        $c_5_1_1 = '<h4 class="font-bold text-slate-800 text-xs mb-2">5.1.1. Rotunda Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Rotunda Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
            
            '<script>' .
            '        }, 2000);' .
            '    }' .
            '}' .
            '</script>';

        
// 5.1.2 Tunnel Roller
        $c_5_1_2 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.2. Tunnel Roller</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) lokasi pemasangan roller dan detail rakitan komponen untuk Tunnel Roller. <strong>Klik pada tombol lingkaran biru transparan di gambar peta lokasi</strong> untuk melihat detail rakitan pada lembar referensi yang sesuai, serta menyorot part number pada tabel di bawah.</p>' .
            
            // Component Detail Sheets Alpine Tab Container with Drag & Drop Editor
            '<div x-data="{' .
            '   activeTab: 1,' .
            '   editMode: false,' .
            '   dragId: null,' .
            '   hotspotsB2: [' .
            '       { id: 1, label: \'1\', title: \'1. Fixed Roller (B2 Upper Rear)\', left: 9.32, top: 37.93 },' .
            '       { id: 2, label: \'2\', title: \'2. Side Roller (B2 Lower Outer Front)\', left: 57.60, top: 33.83 },' .
            '       { id: 3, label: \'3\', title: \'3. Tandem Roller (B2 Lower Front)\', left: 9.32, top: 70.94 },' .
            '       { id: 5, label: \'5\', title: \'5. Fixed Roller (B2 Upper Front)\', left: 60.76, top: 70.80 },' .
            '       { id: 6, label: \'6\', title: \'6. Fixed Roller (B2 Lower Rear)\', left: 34.30, top: 90.59 }' .
            '   ],' .
            '   hotspotsB3_1: [' .
            '       { id: 7, label: \'7\', title: \'7. Fixed Roller (B3 Upper Rear)\', left: 6.17, top: 33.49 },' .
            '       { id: 8, label: \'8\', title: \'8. Fixed Roller (B3 Upper Front)\', left: 60.95, top: 43.51 },' .
            '       { id: 9, label: \'9\', title: \'9. Fixed Roller (B3 Lower Rear)\', left: 9.45, top: 66.58 },' .
            '       { id: 10, label: \'10\', title: \'10. Fixed Roller (B3 Upper Rear)\', left: 62.87, top: 67.50 },' .
            '       { id: 11, label: \'11\', title: \'11. Fixed Roller (B3 Upper Front)\', left: 7.91, top: 97.17 },' .
            '       { id: 12, label: \'12\', title: \'12. Fixed Roller (B3 Lower Rear)\', left: 63.84, top: 96.64 }' .
            '   ],' .
            '   hotspotsB3_2: [' .
            '       { id: 13, label: \'13\', title: \'13. Side Roller (B3 Lower Middle)\', left: 6.44, top: 44.58 },' .
            '       { id: 14, label: \'14\', title: \'14. Side Roller (B3 Lower Outer Front)\', left: 57.98, top: 45.12 },' .
            '       { id: 15, label: \'15\', title: \'15. Tandem Roller (B3 Lower Front)\', left: 6.30, top: 91.83 },' .
            '       { id: 16, label: \'16\', title: \'16. Tandem Roller (B3 Lower Front)\', left: 57.70, top: 92.01 }' .
            '   ],' .
            '   init() {' .
            '       const b2 = localStorage.getItem(\'lms_ref_b2\'); if (b2) this.hotspotsB2 = JSON.parse(b2);' .
            '       const b31 = localStorage.getItem(\'lms_ref_b31\'); if (b31) this.hotspotsB3_1 = JSON.parse(b31);' .
            '       const b32 = localStorage.getItem(\'lms_ref_b32\'); if (b32) this.hotspotsB3_2 = JSON.parse(b32);' .
            '   },' .
            '   savePos() {' .
            '       localStorage.setItem(\'lms_ref_b2\', JSON.stringify(this.hotspotsB2));' .
            '       localStorage.setItem(\'lms_ref_b31\', JSON.stringify(this.hotspotsB3_1));' .
            '       localStorage.setItem(\'lms_ref_b32\', JSON.stringify(this.hotspotsB3_2));' .
            '       this.editMode = false;' .
            '       alert(\'Posisi Hotspot Lembar Referensi Detail berhasil disimpan!\');' .
            '   },' .
            '   onDrag(e) {' .
            '       if (!this.editMode || !this.dragId) return;' .
            '       const containers = Array.from(document.querySelectorAll(\'[data-detail-tab]\'));' .
            '       const activeEl = containers.find(el => el.offsetWidth > 0 && el.offsetHeight > 0);' .
            '       if (!activeEl) return;' .
            '       const rect = activeEl.getBoundingClientRect();' .
            '       if (!rect.width || !rect.height) return;' .
            '       let x = ((e.clientX - rect.left) / rect.width) * 100;' .
            '       let y = ((e.clientY - rect.top) / rect.height) * 100;' .
            '       x = Math.max(0, Math.min(100, Math.round(x * 100) / 100));' .
            '       y = Math.max(0, Math.min(100, Math.round(y * 100) / 100));' .
            '       let list = this.activeTab === 1 ? this.hotspotsB2 : (this.activeTab === 2 ? this.hotspotsB3_1 : this.hotspotsB3_2);' .
            '       const item = list.find(h => String(h.id) === String(this.dragId));' .
            '       if (item && !isNaN(x) && !isNaN(y)) { item.left = x; item.top = y; }' .
            '   }' .
            '}" @switch-detail-tab.window="activeTab = $event.detail.tab" @mousemove.window="onDrag($event)" @mouseup.window="dragId = null" class="my-6 border border-slate-200 rounded-xl bg-slate-50/50 p-4 shadow-sm">' .
            '  <!-- Header Toolbar -->' .
            '  <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 pb-3 mb-4">' .
            '    <div class="flex flex-wrap gap-2 text-[10px] font-bold text-slate-500">' .
            '      <button type="button" @click="activeTab = 1" :class="activeTab === 1 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none">' .
            '          Detail B2 (Roller 1-6)' .
            '      </button>' .
            '      <button type="button" @click="activeTab = 2" :class="activeTab === 2 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none">' .
            '          Detail B3 - Bagian 1 (Roller 7-12)' .
            '      </button>' .
            '      <button type="button" @click="activeTab = 3" :class="activeTab === 3 ? \'bg-blue-600 text-white shadow-xs\' : \'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200\'" class="px-3 py-1.5 rounded-lg transition focus:outline-none">' .
            '          Detail B3 - Bagian 2 (Roller 13-16)' .
            '      </button>' .
            '    </div>';

        $c_5_1_2 .= '    <div>' .
            '      <button type="button" x-show="!editMode" @click="editMode = true" class="px-2.5 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition flex items-center gap-1">' .
            '        <svg class="w-3.5 h-3.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>' .
            '        <span>Atur Posisi / Edit Hotspot Detail</span>' .
            '      </button>' .
            '      <div x-show="editMode" class="flex items-center gap-1.5" x-cloak>' .
            '        <button type="button" @click="editMode = false" class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold">Batal</button>' .
            '        <button type="button" @click="savePos()" class="px-2.5 py-1 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-bold shadow-xs flex items-center gap-1">' .
            '          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>' .
            '          <span>Simpan Posisi</span>' .
            '        </button>' .
            '      </div>' .
            '    </div>';

        $c_5_1_2 .= '  </div>' .
            
            '  <!-- Tab Contents -->' .
            '  <!-- Tab 1: reference_B2.png (B2 - Roller 1 to 6) -->' .
            '  <div x-show="activeTab === 1" data-detail-tab="1" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm max-w-xs w-full select-none" :class="editMode ? \'ring-2 ring-blue-500 cursor-crosshair\' : \'\'">' .
            '    <img src="/images/modules/TunnelRoller/reference_B2.png" class="w-full h-auto block select-none pointer-events-none" alt="Reference B2 Rollers" draggable="false">' .
            '    <template x-for="item in hotspotsB2" :key="item.id">' .
            '      <button type="button" :id="\'roller-hotspot-\' + item.id" class="absolute w-5 h-5 rounded-full border border-blue-500 bg-blue-600 text-white font-bold text-[10px] flex items-center justify-center shadow-md transition duration-150 -translate-x-1/2 -translate-y-1/2 focus:outline-none z-10" :style="`left: ${item.left}%; top: ${item.top}%; cursor: ${editMode ? \'grab\' : \'pointer\'};`" @mousedown="if(editMode) dragId = item.id" @click="if(!editMode) scrollToRollerRow(item.id)" :title="item.title">' .
            '        <span x-text="item.label"></span>' .
            '      </button>' .
            '    </template>' .
            '  </div>' .

            '  <!-- Tab 2: reference_B3.png (B3 - Roller 7 to 12) -->' .
            '  <div x-show="activeTab === 2" data-detail-tab="2" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm max-w-xs w-full select-none" :class="editMode ? \'ring-2 ring-blue-500 cursor-crosshair\' : \'\'">' .
            '    <img src="/images/modules/TunnelRoller/reference_B3.png" class="w-full h-auto block select-none pointer-events-none" alt="Reference B3 Rollers Part 1" draggable="false">' .
            '    <template x-for="item in hotspotsB3_1" :key="item.id">' .
            '      <button type="button" :id="\'roller-hotspot-\' + item.id" class="absolute w-5 h-5 rounded-full border border-blue-500 bg-blue-600 text-white font-bold text-[10px] flex items-center justify-center shadow-md transition duration-150 -translate-x-1/2 -translate-y-1/2 focus:outline-none z-10" :style="`left: ${item.left}%; top: ${item.top}%; cursor: ${editMode ? \'grab\' : \'pointer\'};`" @mousedown="if(editMode) dragId = item.id" @click="if(!editMode) scrollToRollerRow(item.id)" :title="item.title">' .
            '        <span x-text="item.label"></span>' .
            '      </button>' .
            '    </template>' .
            '  </div>' .

            '  <!-- Tab 3: reference_B3(2).png (B3 - Roller 13 to 16) -->' .
            '  <div x-show="activeTab === 3" data-detail-tab="3" x-transition.opacity class="relative mx-auto border border-slate-200 rounded-xl bg-white overflow-hidden shadow-sm max-w-sm w-full select-none" :class="editMode ? \'ring-2 ring-blue-500 cursor-crosshair\' : \'\'">' .
            '    <img src="/images/modules/TunnelRoller/reference_B3(2).png" class="w-full h-auto block select-none pointer-events-none" alt="Reference B3 Rollers Part 2" draggable="false">' .
            '    <template x-for="item in hotspotsB3_2" :key="item.id">' .
            '      <button type="button" :id="\'roller-hotspot-\' + item.id" class="absolute w-5 h-5 rounded-full border border-blue-500 bg-blue-600 text-white font-bold text-[10px] flex items-center justify-center shadow-md transition duration-150 -translate-x-1/2 -translate-y-1/2 focus:outline-none z-10" :style="`left: ${item.left}%; top: ${item.top}%; cursor: ${editMode ? \'grab\' : \'pointer\'};`" @mousedown="if(editMode) dragId = item.id" @click="if(!editMode) scrollToRollerRow(item.id)" :title="item.title">' .
            '        <span x-text="item.label"></span>' .
            '      </button>' .
            '    </template>' .
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
        $c_5_1_3 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.3. Cable carriage device</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Cable carriage device. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
            // Cable carriage device Parts List Table
            '<div class="overflow-x-auto my-6 border border-slate-100 rounded-xl shadow-xs">' .
            '<table class="min-w-full divide-y divide-slate-200 text-xs">' .
            '<thead><tr class="bg-slate-50 text-slate-700 font-bold"><th class="p-2.5 text-center w-16">No.</th><th class="p-2.5 text-left w-36">Part No.</th><th class="p-2.5 text-left">Part Name</th></tr></thead>' .
            '<tbody class="divide-y divide-slate-100 text-slate-600 bg-white">' .
            '<tr id="cable-row-1" class="transition duration-300"><td class="p-2.5 text-center font-bold">1</td><td class="p-2.5 font-mono">OCS100CM</td><td class="p-2.5">Scissor Cable Assembly</td></tr>' .
            '</tbody></table></div>';

        
// 5.1.4 Vertical lift column
        $c_5_1_4 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.4. Vertical lift column</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Vertical lift column. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_5 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.5. Wheel Bogie Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Wheel Bogie Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_6 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.6. Landing Stair</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Landing Stair. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_7 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.7. Cabin Rotation</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Cabin Rotation. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_8 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.8. Cabin Curtain Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Cabin Curtain Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_9 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.9. Auto Leveler Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Auto Leveler Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_10 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.10. Aircraft/Canopy Closure</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Aircraft/Canopy Closure. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_11 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.11. Swing Door and Window Assembly</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Swing Door and Window Assembly. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_12 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.12. Rubber Weathering</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Rubber Weathering. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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
        $c_5_1_13 = '<h4 class="font-bold text-slate-800 text-xs mb-2 mt-8 pt-8 border-t border-slate-200">5.1.13. Wire Rope Equalizer</h4>' .
            '<p class="text-xs text-slate-600 leading-relaxed mb-4">Berikut adalah gambar kerja (technical drawing) beserta daftar komponen penyusun Wire Rope Equalizer. <strong>Klik pada tombol nomor komponen berwarna biru di gambar</strong> untuk secara otomatis menyorot dan menggeser ke baris part number yang sesuai pada tabel di bawah.</p>' .
            
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

        

        $m1 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.1 Rotunda Assembly',
            'content' => $c_5_1_1,
            'order' => 1,
        ]);

        $diag1 = \App\Models\Diagram::create([
            'module_id' => $m1->id,
            'title' => 'Rotunda Technical Drawing',
            'image_path' => 'images/modules/technical_drawing.png',
        ]);

        $rotundaHotspots = [
            ['label' => '1', 'x_percent' => 29.31, 'y_percent' => 45.93, 'popup_title' => '1. Barrel Rotunda Curtain Assembly (Left side)'],
            ['label' => '3', 'x_percent' => 38.34, 'y_percent' => 56.00, 'popup_title' => '3. Guide Pipe Barrel'],
            ['label' => '3', 'x_percent' => 45.71, 'y_percent' => 66.48, 'popup_title' => '3. Guide Pipe Barrel'],
            ['label' => '4', 'x_percent' => 48.66, 'y_percent' => 50.62, 'popup_title' => '4. Tension Barrel Bearing'],
            ['label' => '5', 'x_percent' => 5.53, 'y_percent' => 69.38, 'popup_title' => '5. Slat Curtain Assy (L/R)'],
            ['label' => '6', 'x_percent' => 22.67, 'y_percent' => 57.52, 'popup_title' => '6. Tension Barrel'],
            ['label' => '7', 'x_percent' => 53.27, 'y_percent' => 56.00, 'popup_title' => '7. Guide Pipe Barrel Bearing'],
            ['label' => '8', 'x_percent' => 73.92, 'y_percent' => 6.21, 'popup_title' => '8. Roller Bearing Rotunda'],
            ['label' => '9', 'x_percent' => 59.72, 'y_percent' => 5.52, 'popup_title' => '9. Plate Curtain Upper'],
            ['label' => '9', 'x_percent' => 13.27, 'y_percent' => 46.76, 'popup_title' => '9. Plate Curtain Upper'],
            ['label' => '10', 'x_percent' => 19.72, 'y_percent' => 28.55, 'popup_title' => '10. Potentiometer Rotunda Assy'],
            ['label' => '11', 'x_percent' => 88.66, 'y_percent' => 30.62, 'popup_title' => '11. Hinge Pin'],
            ['label' => '12', 'x_percent' => 45.71, 'y_percent' => 55.59, 'popup_title' => '12. Plate Seat Curtain (L/R)'],
            ['label' => '13', 'x_percent' => 18.99, 'y_percent' => 45.66, 'popup_title' => '13. Worm Gear Assembly (L/R)'],
        ];

        foreach ($rotundaHotspots as $h) {
            $diag1->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        $m2 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.2 Tunnel Roller',
            'content' => $c_5_1_2,
            'order' => 2,
        ]);

        $diag2 = \App\Models\Diagram::create([
            'module_id' => $m2->id,
            'title' => 'Tunnel Roller Location Map',
            'image_path' => 'images/modules/TunnelRoller/tunnel_roller.png',
        ]);

        $tunnelRollerHotspots = [
            ['label' => '1', 'x_percent' => 42.85, 'y_percent' => 15.62, 'popup_title' => '1. Fixed Roller (B2 Tunnel A Upper Rear)'],
            ['label' => '2', 'x_percent' => 63.51, 'y_percent' => 34.23, 'popup_title' => '2. Side Roller (B2 Tunnel A Lower Outer Front)'],
            ['label' => '3', 'x_percent' => 55.38, 'y_percent' => 37.99, 'popup_title' => '3. Tandem Roller (B2 Tunnel A Lower Front)'],
            ['label' => '4', 'x_percent' => 71.46, 'y_percent' => 29.13, 'popup_title' => '4. Nosing Ramp'],
            ['label' => '5', 'x_percent' => 52.50, 'y_percent' => 12.76, 'popup_title' => '5. Fixed Roller (B2 Tunnel A Upper Front)'],
            ['label' => '6', 'x_percent' => 41.49, 'y_percent' => 43.09, 'popup_title' => '6. Fixed Roller (B2 Tunnel A Lower Rear)'],
            ['label' => '7', 'x_percent' => 30.14, 'y_percent' => 62.91, 'popup_title' => '7. Fixed Roller (B3 Tunnel A Upper Rear)'],
            ['label' => '8', 'x_percent' => 36.75, 'y_percent' => 59.46, 'popup_title' => '8. Fixed Roller (B3 Tunnel A Upper Front)'],
            ['label' => '9', 'x_percent' => 34.21, 'y_percent' => 87.84, 'popup_title' => '9. Fixed Roller (B3 Tunnel A Lower Rear)'],
            ['label' => '10', 'x_percent' => 54.36, 'y_percent' => 50.60, 'popup_title' => '10. Fixed Roller (B3 Tunnel B Upper Rear)'],
            ['label' => '11', 'x_percent' => 60.29, 'y_percent' => 46.55, 'popup_title' => '11. Fixed Roller (B3 Tunnel B Upper Front)'],
            ['label' => '12', 'x_percent' => 57.41, 'y_percent' => 77.03, 'popup_title' => '12. Fixed Roller (B3 Tunnel B Lower Rear)'],
            ['label' => '13', 'x_percent' => 44.88, 'y_percent' => 86.04, 'popup_title' => '13. Side Roller (B3 Tunnel A Lower Middle)'],
            ['label' => '14', 'x_percent' => 74.68, 'y_percent' => 67.87, 'popup_title' => '14. Side Roller (B3 Tunnel B Lower Outer Front)'],
            ['label' => '15', 'x_percent' => 50.80, 'y_percent' => 81.83, 'popup_title' => '15. Tandem Roller (B3 Tunnel A Lower Front)'],
            ['label' => '16', 'x_percent' => 69.43, 'y_percent' => 75.08, 'popup_title' => '16. Tandem Roller (B3 Tunnel B Lower Front)'],
            ['label' => '17', 'x_percent' => 60.97, 'y_percent' => 81.68, 'popup_title' => '17. Nosing Ramp'],
            ['label' => '18', 'x_percent' => 81.29, 'y_percent' => 65.62, 'popup_title' => '18. Nosing Ramp'],
        ];

        foreach ($tunnelRollerHotspots as $h) {
            $diag2->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.3 Cable carriage device
        $m3 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.3 Cable carriage device',
            'content' => $c_5_1_3,
            'order' => 3,
        ]);
        $diag3 = \App\Models\Diagram::create([
            'module_id' => $m3->id,
            'title' => 'Cable Carriage Device Technical Drawing',
            'image_path' => 'images/modules/5.1.3.cable.png',
        ]);
        $diag3->hotspots()->create([
            'label' => '1',
            'action_type' => 'scroll_row',
            'popup_title' => '1. Scissor Cable Assembly',
            'x_percent' => 61.05,
            'y_percent' => 59.88,
        ]);

        // 5.1.4 Vertical lift column
        $m4 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.4 Vertical lift column',
            'content' => $c_5_1_4,
            'order' => 4,
        ]);
        $diag4 = \App\Models\Diagram::create([
            'module_id' => $m4->id,
            'title' => 'Vertical Lift Column Technical Drawing',
            'image_path' => 'images/modules/5.1.4Vertical_lift_column.png',
        ]);
        $verticalLiftHotspots = [
            ['label' => '1', 'x_percent' => 90.97, 'y_percent' => 52.50, 'popup_title' => '1. Vertical Lift Column Assembly'],
            ['label' => '2', 'x_percent' => 58.47, 'y_percent' => 5.39, 'popup_title' => '2. Motor Cover'],
            ['label' => '3', 'x_percent' => 71.39, 'y_percent' => 22.50, 'popup_title' => '3. Horizontal Motor + Horizontal Motor Bracket + Chain Sprocket'],
            ['label' => '4', 'x_percent' => 58.33, 'y_percent' => 93.98, 'popup_title' => '4. Pad Teflon Bearing Comp.'],
            ['label' => '5', 'x_percent' => 13.47, 'y_percent' => 28.98, 'popup_title' => '5. Side Cover'],
            ['label' => '6', 'x_percent' => 59.72, 'y_percent' => 26.09, 'popup_title' => '6. Proximity Switch'],
            ['label' => '7', 'x_percent' => 58.47, 'y_percent' => 36.02, 'popup_title' => '7. Coupling system assy'],
            ['label' => '8', 'x_percent' => 58.47, 'y_percent' => 39.77, 'popup_title' => '8. Upper Column Flange'],
            ['label' => '9', 'x_percent' => 58.33, 'y_percent' => 51.25, 'popup_title' => '9. Bearing Thrust Assy /w Cup washer'],
            ['label' => '10', 'x_percent' => 58.47, 'y_percent' => 65.08, 'popup_title' => '10. Ball Screw and Nut Assembly'],
            ['label' => '11', 'x_percent' => 58.47, 'y_percent' => 81.95, 'popup_title' => '11. Nut Stopper'],
        ];
        foreach ($verticalLiftHotspots as $h) {
            $diag4->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.5 Wheel Bogie Assembly
        $m5 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.5 Wheel Bogie Assembly',
            'content' => $c_5_1_5,
            'order' => 5,
        ]);
        $diag5 = \App\Models\Diagram::create([
            'module_id' => $m5->id,
            'title' => 'Wheel Bogie Assembly Technical Drawing',
            'image_path' => 'images/modules/5.1.5.Wheel_Bogie_Assembly.png',
        ]);
        $bogieHotspots = [
            ['label' => '1', 'x_percent' => 31.25, 'y_percent' => 86.28, 'popup_title' => '1. Potentiometer Assy /w Cover'],
            ['label' => '2', 'x_percent' => 15.74, 'y_percent' => 71.98, 'popup_title' => '2. Boogie Frame'],
            ['label' => '3', 'x_percent' => 18.75, 'y_percent' => 40.10, 'popup_title' => '3. Thrust Bearing /w Clamp'],
            ['label' => '4', 'x_percent' => 37.50, 'y_percent' => 58.01, 'popup_title' => '4. Swiveling Column'],
            ['label' => '5', 'x_percent' => 15.74, 'y_percent' => 34.02, 'popup_title' => '5. Tyre Complete'],
            ['label' => '6', 'x_percent' => 61.81, 'y_percent' => 25.80, 'popup_title' => '6. Horizontal Motor'],
            ['label' => '7', 'x_percent' => 63.43, 'y_percent' => 42.89, 'popup_title' => '7. Carriage Frame Shaft'],
            ['label' => '8', 'x_percent' => 61.57, 'y_percent' => 48.48, 'popup_title' => '8. Carriage Frame'],
            ['label' => '9', 'x_percent' => 54.65, 'y_percent' => 64.75, 'popup_title' => '9. Drive System (Chain and Sprocket)'],
            ['label' => '10', 'x_percent' => 35.42, 'y_percent' => 1.48, 'popup_title' => '10. Chain Cover'],
            ['label' => '11', 'x_percent' => 82.18, 'y_percent' => 69.35, 'popup_title' => '11. Solid Tyre'],
            ['label' => '12', 'x_percent' => 86.81, 'y_percent' => 73.62, 'popup_title' => '12. Wheel Rim'],
            ['label' => '13', 'x_percent' => 66.20, 'y_percent' => 53.25, 'popup_title' => '13. Oil Seal'],
            ['label' => '14', 'x_percent' => 70.83, 'y_percent' => 53.57, 'popup_title' => '14. Bushing Oil Seal'],
            ['label' => '15', 'x_percent' => 86.57, 'y_percent' => 61.79, 'popup_title' => '15. Wheel Hub /w Roller Bearing'],
            ['label' => '16', 'x_percent' => 59.03, 'y_percent' => 94.66, 'popup_title' => '16. Wheel Cover'],
            ['label' => '17', 'x_percent' => 62.96, 'y_percent' => 97.95, 'popup_title' => '17. Hub Cap'],
            ['label' => '18', 'x_percent' => 52.78, 'y_percent' => 89.73, 'popup_title' => '18. Landing Gear'],
        ];
        foreach ($bogieHotspots as $h) {
            $diag5->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.6 Landing Stair
        $m6 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.6 Landing Stair',
            'content' => $c_5_1_6,
            'order' => 6,
        ]);
        $diag6 = \App\Models\Diagram::create([
            'module_id' => $m6->id,
            'title' => 'Landing Stair Technical Drawing',
            'image_path' => 'images/modules/5.1.6.Landing_Stair.png',
        ]);
        $stairHotspots = [
            ['label' => '1', 'x_percent' => 88.40, 'y_percent' => 10.76, 'popup_title' => '1. Door Closer'],
            ['label' => '2', 'x_percent' => 88.40, 'y_percent' => 17.11, 'popup_title' => '2. Service Door Assembly'],
            ['label' => '3', 'x_percent' => 47.00, 'y_percent' => 3.51, 'popup_title' => '3. Roof Ladder 1'],
            ['label' => '4', 'x_percent' => 88.40, 'y_percent' => 28.12, 'popup_title' => '4. Lock Unit & door handle'],
            ['label' => '5', 'x_percent' => 51.92, 'y_percent' => 3.47, 'popup_title' => '5. Roof Ladder 2'],
            ['label' => '6', 'x_percent' => 9.19, 'y_percent' => 90.14, 'popup_title' => '6. Castor Wheel'],
            ['label' => '7', 'x_percent' => 37.38, 'y_percent' => 14.67, 'popup_title' => '7. Hand Rail 2'],
            ['label' => '8', 'x_percent' => 57.57, 'y_percent' => 7.26, 'popup_title' => '8. Hand Rail 3'],
            ['label' => '9', 'x_percent' => 18.39, 'y_percent' => 48.03, 'popup_title' => '9. Hand Rail 1'],
            ['label' => '10', 'x_percent' => 26.38, 'y_percent' => 43.85, 'popup_title' => '10. Step Plate'],
        ];
        foreach ($stairHotspots as $h) {
            $diag6->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.7 Cabin Rotation
        $m7 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.7 Cabin Rotation',
            'content' => $c_5_1_7,
            'order' => 7,
        ]);
        $diag7 = \App\Models\Diagram::create([
            'module_id' => $m7->id,
            'title' => 'Cabin Rotation Technical Drawing',
            'image_path' => 'images/modules/5.1.7.Cabin_Rotation.png',
        ]);
        $rotationHotspots = [
            ['label' => '1', 'x_percent' => 16.67, 'y_percent' => 31.62, 'popup_title' => '1. Rotation Drive System'],
            ['label' => '2', 'x_percent' => 66.45, 'y_percent' => 55.41, 'popup_title' => '2. Bracket Mounting Motor'],
            ['label' => '3', 'x_percent' => 80.37, 'y_percent' => 84.62, 'popup_title' => '3. Drive Unit Cabin Rotation'],
            ['label' => '4', 'x_percent' => 89.47, 'y_percent' => 19.16, 'popup_title' => '4. Safety Door Shoe'],
        ];
        foreach ($rotationHotspots as $h) {
            $diag7->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.8 Cabin Curtain Assembly
        $m8 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.8 Cabin Curtain Assembly',
            'content' => $c_5_1_8,
            'order' => 8,
        ]);
        $diag8 = \App\Models\Diagram::create([
            'module_id' => $m8->id,
            'title' => 'Cabin Curtain Assembly Technical Drawing',
            'image_path' => 'images/modules/5.1.8.Cabin_Curtain_Assembly.png',
        ]);
        $curtainHotspots = [
            ['label' => '1', 'x_percent' => 70.44, 'y_percent' => 75.00, 'popup_title' => '1. Roller I Cabin Rotation Ass\'y'],
            ['label' => '2', 'x_percent' => 55.60, 'y_percent' => 97.31, 'popup_title' => '2. Roller Cabin Lateral'],
            ['label' => '3', 'x_percent' => 82.55, 'y_percent' => 73.44, 'popup_title' => '3. Roller Cabin'],
            ['label' => '4', 'x_percent' => 69.92, 'y_percent' => 9.46, 'popup_title' => '4. Slat Curtain (with Glass)'],
            ['label' => '5', 'x_percent' => 18.88, 'y_percent' => 57.73, 'popup_title' => '5. Slat Curtain (without glass)'],
            ['label' => '6', 'x_percent' => 55.21, 'y_percent' => 78.12, 'popup_title' => '6. Bearing Housing'],
            ['label' => '7', 'x_percent' => 32.16, 'y_percent' => 56.94, 'popup_title' => '7. Barrel Curtain'],
            ['label' => '8', 'x_percent' => 91.28, 'y_percent' => 16.15, 'popup_title' => '8. Cover Side Curtain R/L (Top)'],
            ['label' => '8', 'x_percent' => 91.28, 'y_percent' => 58.77, 'popup_title' => '8. Cover Side Curtain R/L (Bottom)'],
            ['label' => '9', 'x_percent' => 35.29, 'y_percent' => 2.26, 'popup_title' => '9. Worm Gear Assembly (Top)'],
            ['label' => '9', 'x_percent' => 64.84, 'y_percent' => 66.93, 'popup_title' => '9. Worm Gear Assembly (Bottom)'],
            ['label' => '10', 'x_percent' => 57.68, 'y_percent' => 2.26, 'popup_title' => '10. Roller (Top)'],
            ['label' => '10', 'x_percent' => 57.42, 'y_percent' => 70.40, 'popup_title' => '10. Roller (Bottom)'],
            ['label' => '11', 'x_percent' => 33.20, 'y_percent' => 67.10, 'popup_title' => '11. Plate Curtain Cabin'],
        ];
        foreach ($curtainHotspots as $h) {
            $diag8->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.9 Auto Leveler Assembly
        $m9 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.9 Auto Leveler Assembly',
            'content' => $c_5_1_9,
            'order' => 9,
        ]);
        $diag9 = \App\Models\Diagram::create([
            'module_id' => $m9->id,
            'title' => 'Auto Leveler Assembly Technical Drawing',
            'image_path' => 'images/modules/5.1.9.Auto_Leverel_Assembly.png',
        ]);
        $levelerHotspots = [
            ['label' => '1', 'x_percent' => 67.30, 'y_percent' => 76.64, 'popup_title' => '1. Autolevel Assembly'],
            ['label' => '2', 'x_percent' => 47.71, 'y_percent' => 24.89, 'popup_title' => '2. Actuator Motor 4"'],
        ];
        foreach ($levelerHotspots as $h) {
            $diag9->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.10 Aircraft/Canopy Closure
        $m10 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.10 Aircraft/Canopy Closure',
            'content' => $c_5_1_10,
            'order' => 10,
        ]);
        $diag10 = \App\Models\Diagram::create([
            'module_id' => $m10->id,
            'title' => 'Aircraft/Canopy Closure Technical Drawing',
            'image_path' => 'images/modules/5.1.10.Aircraft_Closure.png',
        ]);
        $closureHotspots = [
            ['label' => '1', 'x_percent' => 4.04, 'y_percent' => 31.25, 'popup_title' => '1. Pad Closure'],
            ['label' => '2', 'x_percent' => 9.93, 'y_percent' => 3.49, 'popup_title' => '2. Aircraft Closure Ass\'y'],
            ['label' => '3', 'x_percent' => 86.89, 'y_percent' => 29.50, 'popup_title' => '3. Canopy Actuator'],
            ['label' => '4', 'x_percent' => 37.38, 'y_percent' => 31.53, 'popup_title' => '4. Cover Aircraft Closure Right'],
            ['label' => '5', 'x_percent' => 41.30, 'y_percent' => 31.53, 'popup_title' => '5. Cover Aircraft closure Left'],
            ['label' => '6', 'x_percent' => 56.99, 'y_percent' => 97.52, 'popup_title' => '6. Closure Arm Ass\'y Right'],
            ['label' => '7', 'x_percent' => 60.78, 'y_percent' => 97.52, 'popup_title' => '7. Closure Arm Ass\'y Left'],
        ];
        foreach ($closureHotspots as $h) {
            $diag10->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.11 Swing Door and Window Assembly
        $m11 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.11 Swing Door and Window Assembly',
            'content' => $c_5_1_11,
            'order' => 11,
        ]);
        $diag11 = \App\Models\Diagram::create([
            'module_id' => $m11->id,
            'title' => 'Swing Door and Window Assembly Technical Drawing',
            'image_path' => 'images/modules/5.1.11.Swing_door.png',
        ]);
        $swingHotspots = [
            ['label' => '1', 'x_percent' => 79.29, 'y_percent' => 5.70, 'popup_title' => '1. Left Side Shield Glass'],
            ['label' => '2', 'x_percent' => 60.60, 'y_percent' => 25.87, 'popup_title' => '2. Front Shield Glass'],
            ['label' => '3', 'x_percent' => 59.38, 'y_percent' => 50.74, 'popup_title' => '3. Bumper'],
            ['label' => '4', 'x_percent' => 36.50, 'y_percent' => 32.70, 'popup_title' => '4. Right Side Glass'],
            ['label' => '5', 'x_percent' => 7.29, 'y_percent' => 62.36, 'popup_title' => '5. Door Leaf Assy'],
            ['label' => '6', 'x_percent' => 7.29, 'y_percent' => 57.86, 'popup_title' => '6. Lock System'],
            ['label' => '7', 'x_percent' => 84.07, 'y_percent' => 31.53, 'popup_title' => '7. Safety Rope'],
            ['label' => '8', 'x_percent' => 36.34, 'y_percent' => 75.60, 'popup_title' => '8. Door Handle'],
        ];
        foreach ($swingHotspots as $h) {
            $diag11->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.12 Rubber Weathering
        $m12 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.12 Rubber Weathering',
            'content' => $c_5_1_12,
            'order' => 12,
        ]);
        $diag12 = \App\Models\Diagram::create([
            'module_id' => $m12->id,
            'title' => 'Rubber Weathering Technical Drawing',
            'image_path' => 'images/modules/5.1.12.Rubber_Weathering.png',
        ]);
        $weatheringHotspots = [
            ['label' => '1', 'x_percent' => 14.52, 'y_percent' => 75.60, 'popup_title' => '1. Rigid Frame Weathering'],
            ['label' => '2', 'x_percent' => 8.27, 'y_percent' => 88.28, 'popup_title' => '2. Weathering Corner Upper'],
            ['label' => '3', 'x_percent' => 31.74, 'y_percent' => 95.82, 'popup_title' => '3. Rigid Frame Weathering'],
            ['label' => '4', 'x_percent' => 58.64, 'y_percent' => 95.36, 'popup_title' => '4. Weathering Corner Lower'],
            ['label' => '5', 'x_percent' => 49.69, 'y_percent' => 68.70, 'popup_title' => '5. Rigid Frame Weathering'],
            ['label' => '6', 'x_percent' => 8.21, 'y_percent' => 71.92, 'popup_title' => '6. Weathering Corner Upper'],
            ['label' => '7', 'x_percent' => 23.04, 'y_percent' => 56.11, 'popup_title' => '7. Rubber Black'],
            ['label' => '8', 'x_percent' => 70.04, 'y_percent' => 92.23, 'popup_title' => '8. Upper Rotunda Weathering'],
            ['label' => '9', 'x_percent' => 48.10, 'y_percent' => 24.13, 'popup_title' => '9. Inside Weathering'],
            ['label' => '9', 'x_percent' => 77.63, 'y_percent' => 71.28, 'popup_title' => '9. Inside Weathering'],
            ['label' => '10', 'x_percent' => 90.99, 'y_percent' => 52.25, 'popup_title' => '10. Inside Weathering'],
            ['label' => '11', 'x_percent' => 77.88, 'y_percent' => 23.67, 'popup_title' => '11. Upper Bubble Weathering'],
            ['label' => '12', 'x_percent' => 46.08, 'y_percent' => 16.68, 'popup_title' => '12. Inside Weathering'],
        ];
        foreach ($weatheringHotspots as $h) {
            $diag12->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.1.13 Wire Rope Equalizer
        $m13 = Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.1.13 Wire Rope Equalizer',
            'content' => $c_5_1_13,
            'order' => 13,
        ]);
        $diag13 = \App\Models\Diagram::create([
            'module_id' => $m13->id,
            'title' => 'Wire Rope Equalizer Technical Drawing',
            'image_path' => 'images/modules/5.1.13.Wire_Rope_Equalizer.png',
        ]);
        $equalizerHotspots = [
            ['label' => '1', 'x_percent' => 91.00, 'y_percent' => 39.00, 'popup_title' => '1. Wire Rope 1'],
            ['label' => '1', 'x_percent' => 38.30, 'y_percent' => 5.00, 'popup_title' => '1. Wire Rope 1'],
            ['label' => '2', 'x_percent' => 93.90, 'y_percent' => 39.00, 'popup_title' => '2. Wire Rope 2'],
            ['label' => '2', 'x_percent' => 65.90, 'y_percent' => 33.80, 'popup_title' => '2. Wire Rope 2'],
            ['label' => '3', 'x_percent' => 3.70, 'y_percent' => 80.50, 'popup_title' => '3. Drum Tension Ass\'y'],
            ['label' => '4', 'x_percent' => 44.00, 'y_percent' => 44.00, 'popup_title' => '4. Cable Sheave Ass\'y'],
            ['label' => '5', 'x_percent' => 35.10, 'y_percent' => 63.10, 'popup_title' => '5. Cable Equalizer ass\'y, Detail B'],
            ['label' => '6', 'x_percent' => 61.80, 'y_percent' => 38.20, 'popup_title' => '6. Wire Rope Anchorage'],
        ];
        foreach ($equalizerHotspots as $h) {
            $diag13->hotspots()->create([
                'label' => $h['label'],
                'action_type' => 'scroll_row',
                'popup_title' => $h['popup_title'],
                'x_percent' => $h['x_percent'],
                'y_percent' => $h['y_percent'],
            ]);
        }

        // 5.2 Electrical parts and others
        Module::create([
            'chapter_id' => $chapter->id,
            'title' => '5.2 Electrical Parts and Others',
            'content' => '<div class="p-6 bg-slate-50 rounded-2xl border border-slate-100 max-w-xl mt-4 space-y-6">' .
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
            'order' => 14,
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
            'title' => '5.3 Special Tools',
            'content' => $toolsContent,
            'order' => 15,
        ]);
    }
}
