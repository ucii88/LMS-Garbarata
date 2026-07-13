@section('topbar_title', 'Sertifikat — ' . $certificate->course->title)

<x-app-layout>
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Print Button --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('courses.chapters.show', [$certificate->course, $certificate->course->chapters->first()]) }}"
           class="text-xs font-bold text-slate-500 hover:text-blue-600 transition">
            ← Kembali ke Course
        </a>
        <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition">
            🖨 Cetak Sertifikat
        </button>
    </div>

    {{-- Sertifikat --}}
    <div id="certificate-card"
         class="bg-white rounded-3xl shadow-2xl border-8 border-double border-amber-300 overflow-hidden print:shadow-none print:rounded-none print:border-0">

        {{-- Top Banner --}}
        <div class="h-3 bg-gradient-to-r from-amber-400 via-yellow-300 to-amber-400"></div>

        <div class="px-10 py-10 text-center space-y-5">
            {{-- Logo / Icon --}}
            <div class="flex justify-center mb-2">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg">
                    <span class="text-4xl">🏆</span>
                </div>
            </div>

            <div>
                <p class="text-xs font-bold tracking-[0.25em] text-amber-600 uppercase">Sertifikat Kelulusan</p>
                <p class="text-xs text-slate-400 mt-1">Diberikan kepada:</p>
            </div>

            <h1 class="text-4xl font-bold text-slate-800 font-serif">{{ $certificate->user->name }}</h1>

            <div class="w-24 h-0.5 bg-amber-300 mx-auto"></div>

            <div class="space-y-2">
                <p class="text-sm text-slate-600">
                    Telah berhasil menyelesaikan dan lulus semua evaluasi dalam course:
                </p>
                <h2 class="text-xl font-bold text-slate-800">{{ $certificate->course->title }}</h2>
                <p class="text-sm text-slate-500">
                    dengan nilai rata-rata <span class="font-bold text-emerald-600">{{ number_format($certificate->total_score, 1) }}</span> dari 100
                </p>
            </div>

            <div class="flex justify-center gap-8 pt-4">
                <div class="text-center">
                    <p class="text-xs text-slate-400">Tanggal Diterbitkan</p>
                    <p class="text-sm font-semibold text-slate-700">{{ $certificate->issued_at->format('d F Y') }}</p>
                </div>
                <div class="w-px bg-slate-200"></div>
                <div class="text-center">
                    <p class="text-xs text-slate-400">Kode Verifikasi</p>
                    <p class="text-sm font-bold text-slate-700 tracking-wider font-mono">{{ $certificate->certificate_code }}</p>
                </div>
            </div>

            {{-- Tanda tangan area --}}
            <div class="flex justify-around pt-8 pb-2">
                <div class="text-center">
                    <div class="w-32 border-b-2 border-slate-300 mb-1"></div>
                    <p class="text-xs text-slate-500">Instruktur</p>
                </div>
                <div class="text-center">
                    <div class="w-32 border-b-2 border-slate-300 mb-1"></div>
                    <p class="text-xs text-slate-500">Garbarata Training Center</p>
                </div>
            </div>
        </div>

        {{-- Bottom banner --}}
        <div class="h-3 bg-gradient-to-r from-amber-400 via-yellow-300 to-amber-400"></div>
    </div>

    <p class="text-center text-xs text-slate-400">
        Kode unik ini dapat digunakan untuk memverifikasi keaslian sertifikat.
    </p>

</div>

<style>
@media print {
    body * { visibility: hidden; }
    #certificate-card, #certificate-card * { visibility: visible; }
    #certificate-card {
        position: fixed;
        top: 0; left: 0;
        width: 100%;
        border: none !important;
    }
}
</style>
</x-app-layout>
