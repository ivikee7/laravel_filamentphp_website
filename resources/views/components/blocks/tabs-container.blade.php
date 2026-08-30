@props(['data' => []])

@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $tabs = $data['tabs'] ?? [];
@endphp

<div
    @if(!empty($styleData['id'])) id="{{ $styleData['id'] }}" @endif
x-data="{ activeTab: 0 }"
    class="w-full relative {{ $styleData['classes'] }}"
    @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
    {!! $styleData['revealAttrs'] !!}
>
    <!-- Tab Navigation Header -->
    <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-800 overflow-x-auto pb-px mb-6">
        @foreach($tabs as $idx => $tab)
            <button
                type="button"
                @click="activeTab = {{ $idx }}"
                class="px-4 py-2.5 text-sm font-bold transition-all border-b-2 whitespace-nowrap cursor-pointer"
                :class="activeTab === {{ $idx }} ? 'border-blue-600 text-blue-600 dark:text-blue-400' : 'border-transparent text-slate-500 hover:text-slate-900 dark:hover:text-slate-200'"
            >
                {{ $tab['tab_title'] ?? 'Tab ' . ($idx + 1) }}
            </button>
        @endforeach
    </div>

    <!-- Tab Panels -->
    @foreach($tabs as $idx => $tab)
        <div x-show="activeTab === {{ $idx }}" x-cloak class="w-full">
            @if(!empty($tab['blocks']))
                <x-blocks.dispatcher :blocks="$tab['blocks']" />
            @endif
        </div>
    @endforeach
</div>
