<x-app-layout>
    @php
        $nextChapter = $chapters->where('order', '>', $chapter->order)->first();
        if (isset($modules) && (!auth()->check() || !auth()->user()->isInstruktur())) {
            $modules = $modules->map(function($m) {
                if (isset($m->content)) {
                    $m->content = preg_replace('/@if\(auth\(\)->check\(\) && auth\(\)->user\(\)->isInstruktur\(\)\).*?@endif/s', '', $m->content);
                    $m->content = preg_replace('/<button[^>]*@click="editMode\s*=\s*true"[^>]*>.*?<\/button>/s', '', $m->content);
                    $m->content = preg_replace('/<div x-show="editMode"[^>]*>.*?<\/div>/s', '', $m->content);
                }
                return $m;
            });
        }
    @endphp

    <style>
        /* Force text inside study rooms to be 14px instead of 12px due to database HTML having hardcoded class="text-xs" */
        .prose p.text-xs,
        .prose span.text-xs,
        .prose div.text-xs,
        .prose .text-xs {
            font-size: 0.875rem !important;
            line-height: 1.5rem !important;
        }
    </style>

    @include('courses.partials.tts-engine')
    @include('courses.partials.module-diagram-script')


    @if($chapter->order == 1)
        @include('courses.partials.chapters.chapter-1')
    @elseif($chapter->order == 3)
        @include('courses.partials.chapters.chapter-3')
    @elseif($chapter->order == 2)
        @include('courses.partials.chapters.chapter-2')
    @elseif($chapter->order == 4)
        @include('courses.partials.chapters.chapter-4')
    @elseif($chapter->order == 5)
        @include('courses.partials.chapters.chapter-5')
    @elseif($chapter->order == 6)
        @include('courses.partials.chapters.chapter-6')
    @elseif($chapter->order == 7)
        @include('courses.partials.chapters.chapter-7')
    @else
        @include('courses.partials.chapters.default-chapter')
    @endif





    {{-- Global progress listener and dynamic unlocker for all chapters --}}
    <script>
        (function() {
            // Set up fetch interceptor immediately to catch any initial load requests from Alpine init()
            const originalFetch = window.fetch;
            window.fetch = function (input, init) {
                const url = typeof input === 'string' ? input : (input instanceof URL ? input.href : (input && input.url ? input.url : ''));
                const match = url.match(/\/courses\/\d+\/chapters\/\d+\/modules\/(\d+)\/complete/);
                if (match && match[1]) {
                    const moduleId = Number(match[1]);
                    if (window.registerModuleCompletion) {
                        window.registerModuleCompletion(moduleId);
                    } else {
                        if (!window.pendingModuleCompletions) {
                            window.pendingModuleCompletions = [];
                        }
                        window.pendingModuleCompletions.push(moduleId);
                    }
                }
                return originalFetch.apply(this, arguments);
            };
        })();

        document.addEventListener('DOMContentLoaded', function () {
            const totalModuleIds = @js($modules->pluck('id')->values()->toArray());
            let completedModuleIds = new Set(@js($learningProgress ? $learningProgress['completedModules']->intersect($modules->pluck('id'))->values()->toArray() : []));
            const hasQuiz = @js($chapterQuiz ? true : false);
            const isQuizPassed = @js($chapterQuizAttempt?->is_passed ? true : false);

            function checkAndUnlockNextChapter() {
                const allCompleted = totalModuleIds.every(id => completedModuleIds.has(id));
                if (allCompleted) {
                    if (!hasQuiz || isQuizPassed) {
                        const descEl = document.getElementById('next-chapter-desc');
                        const actionEl = document.getElementById('next-chapter-action');
                        if (descEl) {
                            descEl.innerText = @js(__('Hebat! Anda telah menyelesaikan seluruh materi dan quiz pada bab ini. Silakan lanjut ke bab berikutnya.'));
                        }
                        if (actionEl) {
                            @if($nextChapter)
                            actionEl.innerHTML = `
                                <a href="{{ route('courses.chapters.show', [$course->id, $nextChapter->id]) }}"
                                   class="inline-flex items-center justify-center gap-2 px-5 py-3 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md hover:shadow-lg transition-all duration-150 whitespace-nowrap">
                                    {{ __('Lanjut ke Bab') }} {{ $nextChapter->order }} &rarr;
                                </a>
                            `;
                            @endif
                        }
                    }
                }
            }

            // Register completion helper
            window.registerModuleCompletion = function (moduleId) {
                if (!moduleId || isNaN(moduleId)) return;
                completedModuleIds.add(Number(moduleId));
                checkAndUnlockNextChapter();
            };

            window.markModuleCompleteDirectly = function (moduleId) {
                if (!moduleId || isNaN(moduleId)) return;
                const idNum = Number(moduleId);
                
                const completeUrlTemplate = @js(route('courses.modules.complete', [$course->id, $chapter->id, '__MODULE__']));
                const csrfToken = @js(csrf_token());

                fetch(completeUrlTemplate.replace('__MODULE__', idNum), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                }).then(res => {
                    if (res.ok) {
                        window.registerModuleCompletion(idNum);
                    }
                });
            };

            window.setupDetailsTracker = function (moduleId, containerId) {
                if (!moduleId) return;
                const container = document.getElementById(containerId);
                if (!container) return;

                setTimeout(() => {
                    const detailsElements = container.querySelectorAll('details');
                    if (detailsElements.length === 0) {
                        window.markModuleCompleteDirectly(moduleId);
                        return;
                    }

                    let openedIds = new Set();
                    detailsElements.forEach((details, index) => {
                        const id = details.id || `details-${moduleId}-${index}`;
                        details.id = id;

                        if (details.open) {
                            openedIds.add(id);
                        }

                        details.addEventListener('toggle', function onToggle() {
                            if (details.open) {
                                openedIds.add(id);
                                if (openedIds.size === detailsElements.length) {
                                    window.markModuleCompleteDirectly(moduleId);
                                }
                            }
                        });
                    });
                }, 150);
            };

            // Process any completions that happened before DOMContentLoaded
            if (window.pendingModuleCompletions) {
                window.pendingModuleCompletions.forEach(id => {
                    window.registerModuleCompletion(id);
                });
                delete window.pendingModuleCompletions;
            }

            // Run initial check on load
            checkAndUnlockNextChapter();
        });
    </script>
</x-app-layout>
