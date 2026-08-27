@props(['data'])

@php
    $pt = $data['padding_top'] ?? 'pt-8';
    $pb = $data['padding_bottom'] ?? 'pb-8';
    $px = $data['padding_left'] ?? 'px-4';
    $maxWidth = ($data['max_width'] ?? 'max-w-7xl') . ' mx-auto';
    $hideOn = implode(' ', $data['hide_on'] ?? []);

    // Background Compiler
    $bgType = $data['bg_type'] ?? 'transparent';
    $bgStyle = '';
    if ($bgType === 'color' && !empty($data['bg_color'])) {
        $bgStyle = 'background-color: ' . $data['bg_color'] . ';';
    } elseif ($bgType === 'gradient' && !empty($data['bg_gradient'])) {
        $bgStyle = 'background: ' . $data['bg_gradient'] . ';';
    } elseif ($bgType === 'image' && !empty($data['bg_image'])) {
        $bgStyle = 'background-image: url(' . asset('storage/' . $data['bg_image']) . '); background-size: cover; background-position: center;';
    }

    $layoutMap = [
        '1'     => 'grid-cols-1',
        '2'     => 'grid-cols-1 md:grid-cols-2',
        '3'     => 'grid-cols-1 md:grid-cols-3',
        '4'     => 'grid-cols-1 md:grid-cols-4',
        '1-2'   => 'grid-cols-1 md:grid-cols-3 [&>:nth-child(2)]:md:col-span-2',
        '2-1'   => 'grid-cols-1 md:grid-cols-3 [&>:nth-child(1)]:md:col-span-2',
        '1-2-1' => 'grid-cols-1 md:grid-cols-4 [&>:nth-child(2)]:md:col-span-2',
    ];
@endphp

<section
    class="relative {{ $pt }} {{ $pb }} {{ $hideOn }}"
    style="{{ $bgStyle }}"
>
    {{-- Optional Background Overlay --}}
    @if($bgType === 'image' && !empty($data['bg_overlay_color']))
        <div
            class="absolute inset-0 {{ $data['bg_overlay_opacity'] ?? 'opacity-0' }} transition-opacity"
            style="background-color: {{ $data['bg_overlay_color'] }};"
        ></div>
    @endif

    <div class="relative {{ $maxWidth }} {{ $px }} space-y-8">
        @foreach($data['rows'] ?? [] as $row)
            @php
                $gridClass = $layoutMap[$row['columns_layout'] ?? '1'] ?? 'grid-cols-1';
                $gapClass = $row['gap'] ?? 'gap-8';
                $alignClass = $row['align_items'] ?? 'items-start';
            @endphp

            <div class="grid {{ $gridClass }} {{ $gapClass }} {{ $alignClass }}">
                @foreach($row['columns'] ?? [] as $col)
                    @php
                        $colBgType = $col['bg_type'] ?? 'transparent';
                        $colBgStyle = '';
                        if ($colBgType === 'color' && !empty($col['bg_color'])) {
                            $colBgStyle = 'background-color: ' . $col['bg_color'] . ';';
                        } elseif ($colBgType === 'gradient' && !empty($col['bg_gradient'])) {
                            $colBgStyle = 'background: ' . $col['bg_gradient'] . ';';
                        }

                        $colRadius = $col['border_radius'] ?? 'rounded-none';
                        $colShadow = $col['shadow'] ?? 'shadow-none';
                        $colBorderWidth = $col['border_width'] ?? 'border-0';
                        $colHover = $col['hover_effect'] ?? 'hover:none';
                        $colMarginTop = $col['margin_top'] ?? 'mt-0';
                        $colMarginBottom = $col['margin_bottom'] ?? 'mb-0';
                    @endphp

                    <div
                        class="{{ $colRadius }} {{ $colShadow }} {{ $colBorderWidth }} {{ $colHover }} {{ $colMarginTop }} {{ $colMarginBottom }} p-4 transition-all duration-300 space-y-4"
                        style="{{ $colBgStyle }} {{ !empty($col['border_color']) ? 'border-color: ' . $col['border_color'] . ';' : '' }}"
                    >
                        @foreach($col['blocks'] ?? [] as $nestedBlock)
                            <x-blocks.dispatcher :block="$nestedBlock" />
                        @endforeach
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>
