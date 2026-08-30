@props(['data' => []])

@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $rows = $data['rows'] ?? [];
@endphp

<section
    @if(!empty($styleData['id'])) id="{{ $styleData['id'] }}" @endif
class="w-full relative {{ $styleData['classes'] }}"
    @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
    {!! $styleData['revealAttrs'] !!}
>
    {{-- Mask Overlay --}}
    @if($styleData['overlay']['active'])
        <div
            class="absolute inset-0 pointer-events-none {{ $styleData['overlay']['opacity'] }}"
            style="background-color: {{ $styleData['overlay']['color'] }};"
        ></div>
    @endif

    <div class="relative z-10 w-full space-y-8">
        @foreach($rows as $row)
            @php
                $rowData = $row['data'] ?? $row;
                $layout = $rowData['columns_layout'] ?? '1';
                $gap = $rowData['gap'] ?? 'gap-6';
                $align = $rowData['align_items'] ?? 'items-start';
                $columns = $rowData['columns'] ?? [];

                // 1. Determine the outer grid template
                $gridClass = match($layout) {
                    '2'     => 'grid grid-cols-1 md:grid-cols-2',
                    '3'     => 'grid grid-cols-1 md:grid-cols-3',
                    '4'     => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
                    '1-2'   => 'grid grid-cols-1 md:grid-cols-12', // 4 cols (33%) + 8 cols (67%)
                    '2-1'   => 'grid grid-cols-1 md:grid-cols-12', // 8 cols (67%) + 4 cols (33%)
                    default => 'grid grid-cols-1',
                };
            @endphp

            <div class="w-full {{ $gridClass }} {{ $gap }} {{ $align }}">
                @foreach($columns as $index => $col)
                    @php
                        $colData = $col['data'] ?? $col;
                        $colStyle = \App\Filament\Schemas\StyleHelper::compileStyles($colData['styles'] ?? []);
                        $blocks = $colData['blocks'] ?? [];

                        // 2. Set column span based on preset
                        $spanClass = match($layout) {
                            '1-2'   => $index === 0 ? 'md:col-span-4' : 'md:col-span-8',
                            '2-1'   => $index === 0 ? 'md:col-span-8' : 'md:col-span-4',
                            default => 'col-span-1',
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
        @endforeach
    </div>
</section>
