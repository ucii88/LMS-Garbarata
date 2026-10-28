<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @if(auth()->user()->isInstruktur())
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" x-data="signatureEditor()">
                    <div class="max-w-xl space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ __('Tanda Tangan Digital') }}</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ __('Your digital signature will be used on certificates for courses you teach. You can draw your signature using your mouse or touchscreen, or upload an image.') }}</p>
                        </div>
                        @if($signature)
                            <img src="{{ $signature->signature_url }}" alt="{{ __('Tanda tangan saat ini') }}" class="max-h-20 max-w-xs object-contain border rounded-lg p-2">
                        @endif
                        <canvas id="profile-signature-pad" class="w-full h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-crosshair touch-none"></canvas>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" id="profile-signature-clear" class="px-3 py-2 text-sm border rounded-lg">{{ __('Hapus') }}</button>
                            <button type="button" @click="save()" :disabled="saving" class="px-3 py-2 text-sm bg-blue-600 text-white rounded-lg disabled:opacity-50">
                                <span x-text="saving ? '{{ __('Menyimpan...') }}' : '{{ __('Simpan Tanda Tangan') }}'"></span>
                            </button>
                        </div>
                        <form action="{{ route('profile.signature.upload') }}" method="POST" enctype="multipart/form-data" class="flex flex-wrap items-center gap-3">
                            @csrf
                            <div class="flex items-center gap-0">
                                <input type="file" name="signature_file" id="edit_signature_file" accept="image/png,image/jpeg" required class="sr-only"
                                       onchange="document.getElementById('edit_signature_filename_display').textContent = this.files[0] ? this.files[0].name : '{{ __('Tidak ada file yang dipilih') }}';">
                                <label for="edit_signature_file" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-l-lg border border-r-0 border-gray-300 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold cursor-pointer transition select-none">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                    {{ __('Pilih File') }}
                                </label>
                                <div id="edit_signature_filename_display" class="py-2 px-3 text-xs text-gray-500 border border-gray-300 rounded-r-lg bg-gray-50 min-w-[160px] truncate select-none">
                                    {{ __('Tidak ada file yang dipilih') }}
                                </div>
                            </div>
                            <button type="submit" class="px-3.5 py-2 text-xs font-bold border border-blue-600 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg transition">{{ __('Unggah Tanda Tangan') }}</button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    @if(auth()->user()->isInstruktur())
        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
            <script>
                function signatureEditor() {
                    return {
                        saving: false,
                        pad: null,
                        init() {
                            const canvas = document.getElementById('profile-signature-pad');
                            const resize = () => {
                                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                                const rect = canvas.getBoundingClientRect();
                                canvas.width = rect.width * ratio;
                                canvas.height = rect.height * ratio;
                                canvas.getContext('2d').scale(ratio, ratio);
                                this.pad.clear();
                            };
                            this.pad = new SignaturePad(canvas, { backgroundColor: '#ffffff', penColor: '#111827' });
                            resize();
                            window.addEventListener('resize', resize);
                            document.getElementById('profile-signature-clear').addEventListener('click', () => this.pad.clear());
                        },
                        async save() {
                            if (this.pad.isEmpty()) {
                                alert('{{ __("Silakan gambar tanda tangan terlebih dahulu.") }}');
                                return;
                            }
                            this.saving = true;
                            try {
                                const response = await fetch('{{ route("profile.signature.save") }}', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                    body: JSON.stringify({ signature_data: this.pad.toDataURL('image/png') })
                                });
                                const result = await response.json();
                                if (!response.ok || !result.success) throw new Error(result.message || '{{ __("Gagal menyimpan tanda tangan.") }}');
                                window.location.reload();
                            } catch (error) {
                                alert(error.message);
                                this.saving = false;
                            }
                        }
                    };
                }
            </script>
        @endpush
    @endif
</x-app-layout>
