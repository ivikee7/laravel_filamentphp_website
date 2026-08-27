@props(['data'])

@php
    $layoutMap = [
        '1'     => 'grid-cols-1',
        '2'     => 'grid-cols-1 md:grid-cols-2',
        '3'     => 'grid-cols-1 md:grid-cols-3',
        '4'     => 'grid-cols-1 md:grid-cols-4',
        '1-2'   => 'grid-cols-1 md:grid-cols-3 [&>:nth-child(2)]:md:col-span-2',
        '2-1'   => 'grid-cols-1 md:grid-cols-3 [&>:nth-child(1)]:md:col-span-2',
        '1-2-1' => 'grid-cols-1 md:grid-cols-4 [&>:nth-child(2)]:md:col-span-2',
    ];

    $radius = $data['border_radius'] ?? 'rounded-none';
    $shadow = $data['shadow'] ?? 'shadow-none';
    $borderWidth = $data['border_width'] ?? 'border-0';
    $hover = $data['hover_effect'] ?? 'hover:none';

    $bgType = $data['bg_type'] ?? 'transparent';
    $bgStyle = '';
    if ($bgType === 'color' && !empty($data['bg_color'])) {
        $bgStyle = 'background-color: ' . $data['bg_color'] . ';';
    } elseif ($bgType === 'gradient' && !empty($data['bg_gradient'])) {
        $bgStyle = 'background: ' . $data['bg_gradient'] . ';';
    }
@endphp

<div
    class="w-full p-4 transition-all duration-300 {{ $radius }} {{ $shadow }} {{ $borderWidth }} {{ $hover }}"
    style="{{ $bgStyle }} {{ !empty($data['border_color']) ? 'border-color: ' . $data['border_color'] . ';' : '' }}"
>
    @foreach($data['rows'] ?? [] as $row)
        @php
            $gridClass = $layoutMap[$row['columns_layout'] ?? '1'] ?? 'grid-cols-1';
        @endphp
        <div class="grid {{ $gridClass }} gap-4">
            @foreach($row['columns'] ?? [] as $col)
                <div class="space-y-4">
                    @foreach($col['blocks'] ?? [] as $nestedBlock)
                        <x-blocks.dispatcher :block="$nestedBlock" />
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach
</div>
