<x-layouts.app :page="$page">
    @php
        $rawStyles = $page->styles ?? [];
        $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($rawStyles);

        $blocks = is_array($page->content ?? null)
            ? $page->content
            : (is_array($page->blocks ?? null) ? $page->blocks : []);

        $htmlBody = is_string($page->content ?? null)
            ? $page->content
            : ($page->body ?? $page->description ?? '');
    @endphp

    <div
        @if(!empty($styleData['id'])) id="{{ $styleData['id'] }}" @endif
    class="w-full relative transition-all duration-300 {{ $styleData['classes'] }}"
        @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
        {!! $styleData['revealAttrs'] !!}
    >
        {{-- Background Mask Layer for Pattern/Image Backgrounds --}}
        @if($styleData['overlay']['active'])
            <div
                class="absolute inset-0 pointer-events-none {{ $styleData['overlay']['opacity'] }}"
                style="background-color: {{ $styleData['overlay']['color'] }};"
            ></div>
        @endif

        <div class="relative z-10 w-full">
            @if(!empty($blocks) && count($blocks) > 0)
                <x-blocks.dispatcher :blocks="$blocks" />
            @elseif(!empty($htmlBody))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 prose prose-slate dark:prose-invert max-w-none text-slate-800 dark:text-slate-200">
                    {!! $htmlBody !!}
                </div>
            @else
                <div class="max-w-xl mx-auto text-center py-24 px-4">
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white">Welcome</h1>
                    <p class="text-slate-500 mt-2 text-sm">Add sections and blocks in the Filament Page Builder to customize this home page.</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
