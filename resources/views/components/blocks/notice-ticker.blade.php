@props(['data' => [], 'block' => []])

@php
    $text = $data['notice_text']
        ?? $data['text']
        ?? $data['content']
        ?? (is_string($data) ? $data : '');

    $urgency = $data['urgency_level'] ?? 'info';
    $actionLabel = $data['action_label'] ?? null;
    $actionUrl = $data['action_url'] ?? null;

    // Compile design tab styles if available
    $rawStyles = $data['styles'] ?? [];
    $styleData = class_exists(\App\Filament\Schemas\StyleHelper::class)
        ? \App\Filament\Schemas\StyleHelper::compileStyles($rawStyles)
        : ['classes' => '', 'inlineCss' => '', 'revealAttrs' => ''];

    // Urgency configuration mapping
    $themes = [
        'info' => [
            'border' => 'border-blue-300 dark:border-blue-800/60',
            'bg'     => 'bg-blue-50/80 dark:bg-blue-950/30',
            'badge'  => 'bg-blue-600 text-white',
            'dot'    => 'bg-blue-500',
            'label'  => 'Notice',
        ],
        'success' => [
            'border' => 'border-emerald-300 dark:border-emerald-800/60',
            'bg'     => 'bg-emerald-50/80 dark:bg-emerald-950/30',
            'badge'  => 'bg-emerald-600 text-white',
            'dot'    => 'bg-emerald-500',
            'label'  => 'Admissions',
        ],
        'warning' => [
            'border' => 'border-amber-300 dark:border-amber-800/60',
            'bg'     => 'bg-amber-50/80 dark:bg-amber-950/30',
            'badge'  => 'bg-amber-500 text-slate-950',
            'dot'    => 'bg-amber-500',
            'label'  => 'Important',
        ],
        'danger' => [
            'border' => 'border-rose-300 dark:border-rose-800/60',
            'bg'     => 'bg-rose-50/80 dark:bg-rose-950/30',
            'badge'  => 'bg-rose-600 text-white',
            'dot'    => 'bg-rose-500',
            'label'  => 'Urgent Alert',
        ],
    ];

    $theme = $themes[$urgency] ?? $themes['info'];
@endphp

@if(!empty(trim((string) $text)))
    <div
        class="w-full my-6 border rounded-xl p-2 sm:p-2.5 flex items-center gap-3 overflow-hidden shadow-xs transition-all {{ $theme['bg'] }} {{ $theme['border'] }} {{ $styleData['classes'] ?? '' }}"
        @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
        {!! $styleData['revealAttrs'] ?? '' !!}
    >
        <!-- Urgency Badge -->
        <div class="shrink-0 flex items-center gap-1.5 px-3 py-1 font-black text-xs uppercase tracking-wider rounded-lg shadow-xs {{ $theme['badge'] }}">
            <svg class="w-3.5 h-3.5 animate-pulse shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
            </svg>
            <span>{{ $theme['label'] }}</span>
        </div>

        <!-- Animated Ticker Marquee -->
        <div class="relative w-full overflow-hidden whitespace-nowrap mask-[linear-gradient(to_right,transparent,black_3%,black_97%,transparent)]">
            <div class="inline-flex gap-8 animate-ticker hover:[animation-play-state:paused] text-xs sm:text-sm font-semibold text-slate-800 dark:text-slate-200 cursor-pointer">

                {{-- Repeating node sequence for infinite continuous scrolling --}}
                @for ($i = 0; $i < 3; $i++)
                    <div class="inline-flex items-center gap-2 shrink-0">
                        <span class="w-2 h-2 rounded-full {{ $theme['dot'] }}"></span>
                        <span>{{ $text }}</span>
                    </div>
                @endfor

            </div>
        </div>

        <!-- Optional Action CTA Link -->
        @if(!empty($actionUrl) && !empty($actionLabel))
            <a
                href="{{ $actionUrl }}"
                class="shrink-0 hidden md:inline-flex items-center gap-1 px-3 py-1 text-xs font-bold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg hover:border-slate-300 dark:hover:border-slate-700 text-slate-800 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 transition-colors shadow-xs"
            >
                <span>{{ $actionLabel }}</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        @endif
    </div>

    <style>
        @keyframes ticker-scroll {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-33.333%); }
        }
        .animate-ticker {
            display: inline-flex;
            animation: ticker-scroll 22s linear infinite;
        }
    </style>
@endif
