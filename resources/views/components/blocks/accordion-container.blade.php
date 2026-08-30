@props(['data' => []])

@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $items = $data['items'] ?? [];
@endphp

<div
    @if(!empty($styleData['id'])) id="{{ $styleData['id'] }}" @endif
class="w-full relative {{ $styleData['classes'] }}"
    @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
    {!! $styleData['revealAttrs'] !!}
>
    <div class="space-y-3 w-full">
        @foreach($items as $item)
            <div
                x-data="{ open: false }"
                class="border border-slate-200 dark:border-slate-800 rounded-xl overflow-hidden bg-white dark:bg-[#080e1a] shadow-xs"
            >
                <button
                    type="button"
                    @click="open = !open"
                    class="w-full flex items-center justify-between p-4 text-left font-bold text-slate-900 dark:text-slate-100 hover:text-blue-600 dark:hover:text-blue-400 transition-colors focus:outline-none cursor-pointer"
                >
                    <span>{{ $item['title'] ?? 'Accordion Item' }}</span>
                    <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="{ 'rotate-180 text-blue-600': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="open" x-cloak class="p-4 pt-2 border-t border-slate-100 dark:border-slate-800/80">
                    @if(!empty($item['blocks']))
                        <x-blocks.dispatcher :blocks="$item['blocks']" />
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
