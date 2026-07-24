@section('topbar_title', __('Kalender Pembelajaran'))

<x-app-layout>
<div class="space-y-6 select-none" x-data="{
    activeFilter: 'all',
    selectedDayDate: '',
    selectedDayFormatted: '',
    selectedDayEvents: [],
    openModal(dateStr, formattedDate, eventsJson) {
        this.selectedDayDate = dateStr;
        this.selectedDayFormatted = formattedDate;
        try {
            this.selectedDayEvents = JSON.parse(eventsJson) || [];
        } catch(e) {
            this.selectedDayEvents = [];
        }
    },
    closeModal() {
        this.selectedDayEvents = [];
    },
    filterEvent(type) {
        if (this.activeFilter === 'all') return true;
        if (this.activeFilter === 'quiz') return type === 'quiz' || type === 'exam';
        if (this.activeFilter === 'practice') return type === 'practice';
        if (this.activeFilter === 'material') return type === 'material';
        return true;
    }
}">
    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-slate-900 p-6 md:p-8 text-white shadow-xl border border-slate-800">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full bg-blue-500/20 px-3 py-1 text-xs font-bold text-blue-400 border border-blue-500/30 mb-3">
                    <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ __('Kalender LMS Garbarata') }}
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">{{ __('Jadwal & Agenda Pembelajaran') }}</h1>
                <p class="mt-2 text-sm text-slate-300 max-w-2xl leading-relaxed">
                    {{ __('Pantau seluruh tenggat waktu quiz, ujian akhir, latihan mandiri, dan peluncuran modul materi dalam satu tampilan terpadu.') }}
                </p>
            </div>

            <!-- Header Quick Stats -->
            <div class="grid grid-cols-3 gap-3 shrink-0">
                <div class="rounded-xl bg-slate-800 p-4 border border-slate-700/80 text-center min-w-[95px] shadow-sm">
                    <span class="block text-2xl font-black text-white">{{ $totalMonthEvents }}</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-slate-300 mt-1 block">{{ __('Total Event') }}</span>
                </div>
                <div class="rounded-xl bg-slate-800 p-4 border border-amber-500/40 text-center min-w-[95px] shadow-sm">
                    <span class="block text-2xl font-black text-amber-400">{{ $quizCount }}</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300 mt-1 block">{{ __('Quiz/Ujian') }}</span>
                </div>
                <div class="rounded-xl bg-slate-800 p-4 border border-emerald-500/40 text-center min-w-[95px] shadow-sm">
                    <span class="block text-2xl font-black text-emerald-400">{{ $materialCount }}</span>
                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-300 mt-1 block">{{ __('Materi') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Controls & Filter Bar -->
    <div class="rounded-2xl border border-slate-200 bg-white p-4 md:p-6 shadow-sm space-y-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            
            <!-- Month Navigator -->
            <div class="flex items-center gap-3">
                <a href="{{ route('calendar.index', ['month' => $prevMonthDate->month, 'year' => $prevMonthDate->year]) }}" 
                   class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition shadow-2xs"
                   title="{{ __('Bulan Sebelumnya') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>

                <h2 class="text-lg md:text-xl font-bold text-slate-800 tracking-tight min-w-[180px] text-center">
                    {{ $currentMonthDate->translatedFormat('F Y') }}
                </h2>

                <a href="{{ route('calendar.index', ['month' => $nextMonthDate->month, 'year' => $nextMonthDate->year]) }}" 
                   class="inline-flex h-9 w-9 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition shadow-2xs"
                   title="{{ __('Bulan Selanjutnya') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>

                <a href="{{ route('calendar.index') }}" 
                   class="ml-2 px-3 py-1.5 rounded-lg border border-blue-200 bg-blue-50 text-xs font-bold text-blue-700 hover:bg-blue-100 transition">
                    {{ __('Hari Ini') }}
                </a>
            </div>

            <!-- Category Filter Pill Buttons -->
            <div class="flex flex-wrap items-center gap-1.5 bg-slate-100/80 p-1 rounded-xl border border-slate-200">
                <button type="button" @click="activeFilter = 'all'"
                        :class="activeFilter === 'all' ? 'bg-white text-slate-900 shadow-xs font-extrabold' : 'text-slate-600 font-semibold hover:text-slate-900'"
                        class="px-3 py-1.5 text-xs rounded-lg transition">
                    {{ __('Semua') }}
                </button>
                <button type="button" @click="activeFilter = 'quiz'"
                        :class="activeFilter === 'quiz' ? 'bg-white text-rose-700 shadow-xs font-extrabold' : 'text-slate-600 font-semibold hover:text-rose-600'"
                        class="px-3 py-1.5 text-xs rounded-lg transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                    {{ __('Quiz & Ujian') }}
                </button>
                <button type="button" @click="activeFilter = 'practice'"
                        :class="activeFilter === 'practice' ? 'bg-white text-blue-700 shadow-xs font-extrabold' : 'text-slate-600 font-semibold hover:text-blue-600'"
                        class="px-3 py-1.5 text-xs rounded-lg transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    {{ __('Latihan') }}
                </button>
                <button type="button" @click="activeFilter = 'material'"
                        :class="activeFilter === 'material' ? 'bg-white text-indigo-700 shadow-xs font-extrabold' : 'text-slate-600 font-semibold hover:text-indigo-600'"
                        class="px-3 py-1.5 text-xs rounded-lg transition flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                    {{ __('Materi Pembelajaran') }}
                </button>
            </div>
        </div>

        <!-- Monthly Grid View -->
        <div class="overflow-x-auto rounded-xl border border-slate-200">
            <table class="w-full min-w-[700px] border-collapse bg-white">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">
                        <th class="py-3 px-2 w-[14.28%] border-r border-slate-200 text-rose-600">{{ __('Sen') }}</th>
                        <th class="py-3 px-2 w-[14.28%] border-r border-slate-200">{{ __('Sel') }}</th>
                        <th class="py-3 px-2 w-[14.28%] border-r border-slate-200">{{ __('Rab') }}</th>
                        <th class="py-3 px-2 w-[14.28%] border-r border-slate-200">{{ __('Kam') }}</th>
                        <th class="py-3 px-2 w-[14.28%] border-r border-slate-200">{{ __('Jum') }}</th>
                        <th class="py-3 px-2 w-[14.28%] border-r border-slate-200 text-slate-700">{{ __('Sab') }}</th>
                        <th class="py-3 px-2 w-[14.28%] text-rose-500">{{ __('Min') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach($gridWeeks as $week)
                        <tr class="divide-x divide-slate-200 min-h-[110px]">
                            @foreach($week as $day)
                                @php
                                    $dayEvents = $events[$day['date_string']] ?? [];
                                    $dayEventsJson = json_encode($dayEvents);
                                    $formattedDate = \Carbon\Carbon::parse($day['date_string'])->translatedFormat('l, d F Y');
                                @endphp
                                <td class="p-1.5 align-top h-28 md:h-32 transition hover:bg-slate-50/80 group relative {{ !$day['is_current_month'] ? 'bg-slate-50/50 opacity-40' : '' }} {{ $day['is_today'] ? 'bg-slate-100/90 ring-2 ring-slate-800 ring-inset' : '' }}">
                                    <!-- Cell Date Number Header -->
                                    <div class="flex items-center justify-between p-1">
                                        @if($day['is_today'])
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-black bg-slate-900 text-white shadow-xs">
                                                <span>{{ $day['day_number'] }}</span>
                                                <span class="text-[9px] font-semibold text-slate-300 uppercase tracking-tighter">{{ __('Hari Ini') }}</span>
                                            </span>
                                        @else
                                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full text-xs font-bold {{ $day['is_current_month'] ? 'text-slate-800' : 'text-slate-400' }}">
                                                {{ $day['day_number'] }}
                                            </span>
                                        @endif

                                        @if(count($dayEvents) > 0)
                                            <button type="button" 
                                                    @click="openModal('{{ $day['date_string'] }}', '{{ $formattedDate }}', '{{ addslashes($dayEventsJson) }}')"
                                                    class="text-[10px] font-bold text-blue-600 hover:text-blue-800 hover:underline">
                                                {{ count($dayEvents) }} {{ __('event') }}
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Event Chips List inside Day Cell -->
                                    <div class="mt-1 space-y-1">
                                        @foreach(array_slice($dayEvents, 0, 2) as $event)
                                            <div x-show="filterEvent('{{ $event['type'] }}')"
                                                 @click="openModal('{{ $day['date_string'] }}', '{{ $formattedDate }}', '{{ addslashes($dayEventsJson) }}')"
                                                 class="cursor-pointer rounded-lg p-1.5 text-[10px] leading-tight font-semibold border transition shadow-2xs flex flex-col gap-0.5 hover:scale-[1.02] 
                                                        {{ $event['color'] === 'rose' ? 'bg-rose-50 border-rose-200 text-rose-900 hover:bg-rose-100' : '' }}
                                                        {{ $event['color'] === 'amber' ? 'bg-amber-50 border-amber-200 text-amber-900 hover:bg-amber-100' : '' }}
                                                        {{ $event['color'] === 'blue' ? 'bg-blue-50 border-blue-200 text-blue-900 hover:bg-blue-100' : '' }}
                                                        {{ $event['color'] === 'emerald' ? 'bg-emerald-50 border-emerald-200 text-emerald-900 hover:bg-emerald-100' : '' }}
                                                        {{ $event['color'] === 'indigo' ? 'bg-indigo-50 border-indigo-200 text-indigo-900 hover:bg-indigo-100' : '' }}">
                                                <div class="flex items-center justify-between gap-1">
                                                    <span class="font-extrabold truncate">{{ $event['badge_text'] }}</span>
                                                    <span class="text-[9px] opacity-75 shrink-0">{{ $event['time_str'] }}</span>
                                                </div>
                                                <span class="truncate font-medium opacity-90">{{ $event['title'] }}</span>
                                            </div>
                                        @endforeach

                                        @if(count($dayEvents) > 2)
                                            <button type="button" 
                                                    @click="openModal('{{ $day['date_string'] }}', '{{ $formattedDate }}', '{{ addslashes($dayEventsJson) }}')"
                                                    class="w-full text-center text-[9px] font-bold text-slate-500 hover:text-slate-800 py-0.5 rounded hover:bg-slate-200/60 transition">
                                                +{{ count($dayEvents) - 2 }} {{ __('lainnya') }}
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Event Detail Modal (Alpine.js) -->
    <div x-show="selectedDayEvents.length > 0" 
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto" 
         role="dialog" 
         aria-modal="true"
         style="display: none;">
        <div class="flex min-h-screen items-center justify-center px-4 py-10">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="closeModal()"></div>

            <!-- Modal Content Card -->
            <div class="relative z-10 w-full max-w-lg overflow-hidden rounded-2xl border border-slate-200 bg-white text-left shadow-2xl">
                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b border-slate-100 bg-slate-50/80 px-6 py-4">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ __('Agenda Pembelajaran') }}</span>
                        <h3 class="text-base font-extrabold text-slate-900 mt-0.5" x-text="selectedDayFormatted"></h3>
                    </div>
                    <button type="button" @click="closeModal()" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-200 hover:text-slate-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body: Events List -->
                <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                    <template x-for="event in selectedDayEvents" :key="event.id">
                        <div class="rounded-xl border p-4 transition space-y-3"
                             :class="{
                                 'border-rose-200 bg-rose-50/50': event.color === 'rose',
                                 'border-amber-200 bg-amber-50/50': event.color === 'amber',
                                 'border-blue-200 bg-blue-50/50': event.color === 'blue',
                                 'border-emerald-200 bg-emerald-50/50': event.color === 'emerald',
                                 'border-indigo-200 bg-indigo-50/50': event.color === 'indigo'
                             }">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <span class="inline-block px-2.5 py-0.5 rounded-md text-[10px] font-extrabold uppercase tracking-wide"
                                          :class="{
                                              'bg-rose-100 text-rose-700': event.color === 'rose',
                                              'bg-amber-100 text-amber-700': event.color === 'amber',
                                              'bg-blue-100 text-blue-700': event.color === 'blue',
                                              'bg-emerald-100 text-emerald-700': event.color === 'emerald',
                                              'bg-indigo-100 text-indigo-700': event.color === 'indigo'
                                          }"
                                          x-text="event.badge_text"></span>
                                    <h4 class="text-sm font-bold text-slate-900 mt-1.5" x-text="event.title"></h4>
                                </div>
                                <span class="text-xs font-semibold text-slate-500 bg-white/80 px-2 py-1 rounded-md border border-slate-200 shrink-0" x-text="event.time_str"></span>
                            </div>

                            <p class="text-xs text-slate-600 leading-relaxed" x-text="event.description"></p>

                            <div class="flex items-center justify-between text-xs text-slate-500 pt-1 border-t border-slate-200/60">
                                <span class="font-medium truncate max-w-[200px]" x-text="event.course_title"></span>

                                <a :href="event.action_url" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 transition shadow-2xs">
                                    <span x-text="event.action_label"></span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50 px-6 py-3 border-t border-slate-100 flex justify-end">
                    <button type="button" @click="closeModal()" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-100 transition">
                        {{ __('Tutup') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
