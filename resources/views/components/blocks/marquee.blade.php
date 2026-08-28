@props(['data' => [], 'styles' => []])

@php
    $duration = match($data['speed'] ?? 'normal') {
        'slow' => '45s',
        'fast' => '12s',
        default => '25s',
    };

    $direction = ($data['direction'] ?? 'left') === 'right' ? 'reverse' : 'normal';
    $pause = ($data['pause_on_hover'] ?? true);
    $gapClass = $data['gap'] ?? 'gap-10';
    $items = $data['items'] ?? [];
    $uniqueId = 'marquee-' . uniqid();
@endphp

<x-blocks.builder-block-wrapper :styles="$styles ?? ($data['styles'] ?? [])">
    <style>
        @keyframes scrollMarquee-{{ $uniqueId }} {
            0% {
                transform: translate3d(0, 0, 0);
            }
            100% {
                transform: translate3d(-50%, 0, 0);
            }
        }

        .track-{{ $uniqueId }} {
            display: flex;
            width: max-content;
            animation: scrollMarquee-{{ $uniqueId }} {{ $duration }} linear infinite;
            animation-direction: {{ $direction }};
            will-change: transform;
        }

        @if($pause)
            .wrapper-{{ $uniqueId }}:hover .track-{{ $uniqueId }} {
            animation-play-state: paused;
        }
        @endif
    </style>

    {{-- Removed hardcoded bg-slate-950 and border classes to respect StyleHelper settings --}}
    <div class="wrapper-{{ $uniqueId }} relative w-full overflow-hidden whitespace-nowrap select-none">
        <div class="track-{{ $uniqueId }}">
            {{-- Loop Set 1 --}}
            <div class="flex shrink-0 items-center {{ $gapClass }} pr-10">
                @foreach($items as $item)
                    <div class="inline-flex items-center gap-3">
                        @if(!empty($item['badge']))
                            <span class="px-2.5 py-0.5 text-xs font-black uppercase tracking-wider rounded-full bg-blue-600 text-white shadow-sm">
                                {{ $item['badge'] }}
                            </span>
                        @endif

                        @if(!empty($item['url']))
                            <a href="{{ $item['url'] }}" class="text-sm font-bold tracking-wide hover:opacity-75 transition-opacity">
                                {{ $item['text'] ?? '' }}
                            </a>
                        @else
                            <span class="text-sm font-bold tracking-wide">
                                {{ $item['text'] ?? '' }}
                            </span>
                        @endif

                        <span class="opacity-50 font-extrabold ml-4">•</span>
                    </div>
                @endforeach
            </div>

            {{-- Loop Set 2 (Seamless Mirrored Duplicate) --}}
            <div class="flex shrink-0 items-center {{ $gapClass }} pr-10" aria-hidden="true">
                @foreach($items as $item)
                    <div class="inline-flex items-center gap-3">
                        @if(!empty($item['badge']))
                            <span class="px-2.5 py-0.5 text-xs font-black uppercase tracking-wider rounded-full bg-blue-600 text-white shadow-sm">
                                {{ $item['badge'] }}
                            </span>
                        @endif

                        @if(!empty($item['url']))
                            <a href="{{ $item['url'] }}" class="text-sm font-bold tracking-wide hover:opacity-75 transition-opacity">
                                {{ $item['text'] ?? '' }}
                            </a>
                        @else
                            <span class="text-sm font-bold tracking-wide">
                                {{ $item['text'] ?? '' }}
                            </span>
                        @endif

                        <span class="opacity-50 font-extrabold ml-4">•</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-blocks.builder-block-wrapper>
