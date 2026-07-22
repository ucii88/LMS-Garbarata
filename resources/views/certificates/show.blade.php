@section('topbar_title', 'Sertifikat — ' . $certificate->course->title)

<x-app-layout>
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Action Buttons --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('courses.chapters.show', [$certificate->course, $certificate->course->chapters->first()]) }}"
           class="text-sm font-bold text-slate-500 hover:text-blue-600 transition">
            ← Kembali ke Course
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak</span>
            </button>
            <a href="{{ request()->url() }}?download=1"
               class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Unduh PDF</span>
            </a>
        </div>
    </div>

    {{-- Certificate Card — matches PDF design exactly --}}
    <div id="certificate-card" style="
        position: relative;
        background: #fffdf5;
        overflow: hidden;
        aspect-ratio: 297 / 210;
        width: 100%;
        font-family: 'Georgia', 'DejaVu Serif', serif;
        color: #1e293b;
    ">
        {{-- Orange banners top & bottom --}}
        <div style="position:absolute;top:0;left:0;right:0;height:3.8%;background:#d97706;"></div>
        <div style="position:absolute;bottom:0;left:0;right:0;height:3.8%;background:#d97706;"></div>

        {{-- Gold stripes --}}
        <div style="position:absolute;top:3.1%;left:0;right:0;height:0.7%;background:#fbbf24;"></div>
        <div style="position:absolute;bottom:3.1%;left:0;right:0;height:0.7%;background:#fbbf24;"></div>

        {{-- Outer dark-gold border --}}
        <div style="position:absolute;top:5.2%;left:3.4%;right:3.4%;bottom:5.2%;border:2.5px solid #b45309;"></div>

        {{-- Inner light-gold border --}}
        <div style="position:absolute;top:6.7%;left:4.4%;right:4.4%;bottom:6.7%;border:1px solid #fcd34d;"></div>

        {{-- Corner brackets --}}
        {{-- TL --}}
        <div style="position:absolute;top:3.8%;left:2.4%;width:4%;height:6%;border-top:3.5px solid #92400e;border-left:3.5px solid #92400e;"></div>
        {{-- TR --}}
        <div style="position:absolute;top:3.8%;right:2.4%;width:4%;height:6%;border-top:3.5px solid #92400e;border-right:3.5px solid #92400e;"></div>
        {{-- BL --}}
        <div style="position:absolute;bottom:3.8%;left:2.4%;width:4%;height:6%;border-bottom:3.5px solid #92400e;border-left:3.5px solid #92400e;"></div>
        {{-- BR --}}
        <div style="position:absolute;bottom:3.8%;right:2.4%;width:4%;height:6%;border-bottom:3.5px solid #92400e;border-right:3.5px solid #92400e;"></div>

        {{-- Content --}}
        <div style="
            position:absolute;top:4.8%;left:5%;right:5%;bottom:4.8%;
            display:flex;flex-direction:column;align-items:center;justify-content:center;
            text-align:center;padding:1% 8%;gap:0;
        ">
            {{-- Org Name --}}
            <div style="font-family:'Arial',sans-serif;font-size:1.05vw;color:#b45309;letter-spacing:0.35em;text-transform:uppercase;margin-bottom:0.3%;font-weight:600;">
                Garbarata Training Center
            </div>

            {{-- Title --}}
            <div style="font-family:'Arial',sans-serif;font-size:1.5vw;font-weight:bold;letter-spacing:0.4em;color:#92400e;text-transform:uppercase;margin-bottom:1%;">
                Sertifikat Kelulusan
            </div>

            {{-- Stars --}}
            <div style="font-size:2vw;color:#d97706;letter-spacing:0.4em;margin-bottom:1%;">
                &#9733; &#9733; &#9733;
            </div>

            {{-- Given label --}}
            <div style="font-family:'Arial',sans-serif;font-size:0.9vw;color:#64748b;margin-bottom:0.6%;">
                Diberikan kepada:
            </div>

            {{-- Recipient name --}}
            <div style="font-size:3.5vw;font-weight:bold;color:#1e293b;line-height:1.1;margin-bottom:0.8%;">
                {{ $certificate->user->name }}
            </div>

            {{-- Divider --}}
            <div style="width:20%;height:2px;background:#d97706;margin:0 auto 1.2%;"></div>

            {{-- Completion text --}}
            <div style="font-family:'Arial',sans-serif;font-size:0.9vw;color:#475569;margin-bottom:0.5%;">
                Telah berhasil menyelesaikan dan lulus semua evaluasi dalam kursus:
            </div>

            {{-- Course name --}}
            <div style="font-size:1.5vw;font-weight:bold;color:#1e293b;margin-bottom:0.5%;">
                {{ $certificate->course->title }}
            </div>

            {{-- Score --}}
            <div style="font-family:'Arial',sans-serif;font-size:0.9vw;color:#475569;margin-bottom:1.8%;">
                dengan nilai rata-rata
                <span style="font-weight:bold;color:#059669;font-size:1.1vw;">{{ number_format($certificate->total_score, 1) }}</span>
                dari 100
            </div>

            {{-- Meta: date & code --}}
            <div style="display:flex;width:55%;margin:0 auto 1.5%;gap:0;">
                <div style="flex:1;text-align:center;padding:0 2%;border-right:1px solid #e2e8f0;">
                    <div style="font-family:'Arial',sans-serif;font-size:0.7vw;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.3%;">
                        Tanggal Diterbitkan
                    </div>
                    <div style="font-family:'Arial',sans-serif;font-size:0.95vw;font-weight:bold;color:#334155;">
                        {{ $certificate->issued_at->locale('id')->translatedFormat('d F Y') }}
                    </div>
                </div>
                <div style="flex:1;text-align:center;padding:0 2%;">
                    <div style="font-family:'Arial',sans-serif;font-size:0.7vw;color:#94a3b8;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:0.3%;">
                        Kode Verifikasi
                    </div>
                    <div style="font-family:'Courier New',monospace;font-size:0.9vw;font-weight:bold;color:#334155;letter-spacing:0.15em;">
                        {{ $certificate->certificate_code }}
                    </div>
                </div>
            </div>

            {{-- Signatures --}}
            <div style="display:flex;width:65%;margin:0 auto;gap:0;">
                <div style="flex:1;text-align:center;padding:0 4%;">
                    <div style="height:3vw;"></div>
                    <div style="border-bottom:1.5px solid #cbd5e1;width:70%;margin:0 auto 0.4%;"></div>
                    <div style="font-family:'Arial',sans-serif;font-size:0.75vw;color:#64748b;">Instruktur</div>
                </div>
                <div style="flex:1;text-align:center;padding:0 4%;">
                    <div style="height:3vw;"></div>
                    <div style="border-bottom:1.5px solid #cbd5e1;width:70%;margin:0 auto 0.4%;"></div>
                    <div style="font-family:'Arial',sans-serif;font-size:0.75vw;color:#64748b;">Garbarata Training Center</div>
                </div>
            </div>
        </div>
    </div>

    <p class="text-center text-sm text-slate-400">
        Kode unik ini dapat digunakan untuk memverifikasi keaslian sertifikat.
    </p>

</div>

<style>
@media print {
    /* Hide everything except the certificate */
    body > * { display: none !important; }
    #certificate-card {
        display: block !important;
        position: fixed;
        top: 0; left: 0;
        width: 100vw;
        height: 100vh;
        margin: 0;
        aspect-ratio: auto;
    }
}
</style>
</x-app-layout>
