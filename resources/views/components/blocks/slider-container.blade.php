@props(['data' => []])

@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $slides = $data['slides'] ?? [];
    $slidesPerView = (int) ($data['slides_per_view'] ?? 1);
    $gap = $data['slider_gap'] ?? 'gap-6';
    $autoplaySpeed = (int) ($data['autoplay_speed'] ?? 5000);
    $showArrows = filter_var($data['show_arrows'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $showDots = filter_var($data['show_dots'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $loop = filter_var($data['loop'] ?? true, FILTER_VALIDATE_BOOLEAN);
    $totalSlides = count($slides);

    // Responsive Slide Width Calculation
    $slideWidthStyle = match($slidesPerView) {
        2 => 'flex: 0 0 100%; @media (min-width: 768px) { flex: 0 0 calc(50% - 0.75rem); }',
        3 => 'flex: 0 0 100%; @media (min-width: 640px) { flex: 0 0 calc(50% - 0.75rem); } @media (min-width: 1024px) { flex: 0 0 calc(33.333% - 1rem); }',
        4 => 'flex: 0 0 100%; @media (min-width: 640px) { flex: 0 0 calc(50% - 0.75rem); } @media (min-width: 1024px) { flex: 0 0 calc(25% - 1.125rem); }',
        default => 'flex: 0 0 100%; width: 100%;',
    };
@endphp

@if($totalSlides > 0)
    <div
        @if(!empty($styleData['id'])) id="{{ $styleData['id'] }}" @endif
    class="w-full relative my-6 group {{ $styleData['classes'] }}"
        @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
        {!! $styleData['revealAttrs'] !!}
        x-data="{
            current: 0,
            total: {{ $totalSlides }},
            perView: {{ $slidesPerView }},
            loop: {{ $loop ? 'true' : 'false' }},
            speed: {{ $autoplaySpeed }},
            timer: null,
            next() {
                let max = Math.max(0, this.total - (window.innerWidth >= 1024 ? this.perView : 1));
                if (this.current >= max) {
                    this.current = this.loop ? 0 : max;
                } else {
                    this.current++;
                }
            },
            prev() {
                let max = Math.max(0, this.total - (window.innerWidth >= 1024 ? this.perView : 1));
                if (this.current <= 0) {
                    this.current = this.loop ? max : 0;
                } else {
                    this.current--;
                }
            },
            init() {
                if (this.speed > 0) {
                    this.timer = setInterval(() => this.next(), this.speed);
                }
            }
        }"
        @mouseenter="if (timer) clearInterval(timer)"
        @mouseleave="if (speed > 0) timer = setInterval(() => next(), speed)"
    >
        {{-- Mask Overlay --}}
        @if(!empty($styleData['overlay']['active']))
            <div
                class="absolute inset-0 pointer-events-none z-0 {{ $styleData['overlay']['opacity'] }}"
                style="background-color: {{ $styleData['overlay']['color'] }};"
            ></div>
        @endif

        <!-- Carousel Track Viewport -->
        <div class="relative z-10 w-full overflow-hidden rounded-2xl">
            <div
                class="flex transition-transform duration-500 ease-out {{ $gap }}"
                :style="`transform: translateX(-${current * 100}%)`"
            >
                @foreach($slides as $slide)
                    @php
                        $blocks = $slide['blocks'] ?? [];
                    @endphp
                    <div class="shrink-0 w-full min-w-full">
                        @if(!empty($blocks))
                            <x-blocks.dispatcher :blocks="$blocks" />
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Arrows -->
        @if($showArrows && $totalSlides > 1)
            <button
                type="button"
                @click="prev()"
                aria-label="Previous"
                class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/90 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 flex items-center justify-center shadow-lg backdrop-blur-md opacity-0 group-hover:opacity-100 hover:scale-110 active:scale-95 transition-all cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <button
                type="button"
                @click="next()"
                aria-label="Next"
                class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full bg-white/90 dark:bg-slate-900/90 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-100 flex items-center justify-center shadow-lg backdrop-blur-md opacity-0 group-hover:opacity-100 hover:scale-110 active:scale-95 transition-all cursor-pointer"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        @endif

        <!-- Dots -->
        @if($showDots && $totalSlides > 1)
            <div class="relative z-20 flex items-center justify-center gap-2 pt-4">
                @foreach($slides as $index => $slide)
                    <button
                        type="button"
                        @click="current = {{ $index }}"
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="current === {{ $index }} ? 'w-8 bg-blue-600' : 'w-2 bg-slate-300 dark:bg-slate-700'"
                    ></button>
                @endforeach
            </div>
        @endif
    </div>
@endif
