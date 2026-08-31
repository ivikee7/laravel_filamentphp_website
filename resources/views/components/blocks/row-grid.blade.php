@props(['data' => []])

@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $layout = (string) ($data['columns_layout'] ?? '2');
    $gap = $data['gap'] ?? 'gap-6';
    $align = $data['align_items'] ?? 'items-start';
    $columns = $data['columns'] ?? [];

    // Outer Grid Container Mapping
    $gridClass = match($layout) {
        '2'       => 'grid grid-cols-1 md:grid-cols-2',
        '3'       => 'grid grid-cols-1 md:grid-cols-3',
        '4'       => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        '5'       => 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5',
        '6'       => 'grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6',

        // 12-Column Grid Base for Asymmetric Splits
        '1-2', '2-1', '1-3', '3-1', '2-3', '3-2',
        '1-2-1', '2-1-1', '1-1-2', '1-4-1',
        '2-1-1-1', '1-1-1-2' => 'grid grid-cols-1 md:grid-cols-12',

        default   => 'grid grid-cols-1',
    };
@endphp

<div
    @if(!empty($styleData['id'])) id="{{ $styleData['id'] }}" @endif
class="w-full relative my-6 {{ $gridClass }} {{ $gap }} {{ $align }} {{ $styleData['classes'] }}"
    @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
    {!! $styleData['revealAttrs'] !!}
>
    {{-- Mask Overlay for Background Image or Pattern --}}
    @if($styleData['overlay']['active'])
        <div
            class="absolute inset-0 pointer-events-none {{ $styleData['overlay']['opacity'] }}"
            style="background-color: {{ $styleData['overlay']['color'] }};"
        ></div>
    @endif

    @foreach($columns as $index => $col)
        @php
            $colData = $col['data'] ?? $col;
            $colStyle = \App\Filament\Schemas\StyleHelper::compileStyles($colData['styles'] ?? []);
            $blocks = $colData['blocks'] ?? [];

            // Child Column Span Mapping
            $spanClass = match($layout) {
                // 2-Column Asymmetric
                '1-2'     => $index === 0 ? 'md:col-span-4' : 'md:col-span-8',
                '2-1'     => $index === 0 ? 'md:col-span-8' : 'md:col-span-4',
                '1-3'     => $index === 0 ? 'md:col-span-3' : 'md:col-span-9',
                '3-1'     => $index === 0 ? 'md:col-span-9' : 'md:col-span-3',
                '2-3'     => $index === 0 ? 'md:col-span-5' : 'md:col-span-7',
                '3-2'     => $index === 0 ? 'md:col-span-7' : 'md:col-span-5',

                // 3-Column Asymmetric
                '1-2-1'   => $index === 1 ? 'md:col-span-6' : 'md:col-span-3',
                '2-1-1'   => $index === 0 ? 'md:col-span-6' : 'md:col-span-3',
                '1-1-2'   => $index === 2 ? 'md:col-span-6' : 'md:col-span-3',
                '1-4-1'   => $index === 1 ? 'md:col-span-8' : 'md:col-span-2',

                // 4-Column Asymmetric
                '2-1-1-1' => $index === 0 ? 'md:col-span-6 lg:col-span-5' : 'md:col-span-2 lg:col-span-2',
                '1-1-1-2' => $index === 3 ? 'md:col-span-6 lg:col-span-5' : 'md:col-span-2 lg:col-span-2',

                default   => 'col-span-1',
            };
        @endphp

        <div
            class="w-full min-w-0 {{ $spanClass }} {{ $colStyle['classes'] }}"
            @if(!empty($colStyle['inlineCss'])) style="{{ $colStyle['inlineCss'] }}" @endif
        >
            @if(!empty($blocks))
                <x-blocks.dispatcher :blocks="$blocks" />
            @endif
        </div>
    @endforeach
</div>
