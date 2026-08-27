@props(['data'])

@php
    $level = $data['level'] ?? 'h2';
    $alignment = $data['alignment'] ?? 'text-center';
    $fontWeight = $data['font_weight'] ?? 'font-bold';
    $marginTop = $data['margin_top'] ?? 'mt-0';
    $marginBottom = $data['margin_bottom'] ?? 'mb-0';
    $radius = $data['border_radius'] ?? 'rounded-none';
    $shadow = $data['shadow'] ?? 'shadow-none';
    $borderWidth = $data['border_width'] ?? 'border-0';
    $hover = $data['hover_effect'] ?? 'hover:none';

    $style = implode('; ', array_filter([
        !empty($data['text_color']) ? 'color: ' . $data['text_color'] : null,
        !empty($data['custom_font_size']) ? 'font-size: ' . $data['custom_font_size'] : null,
        !empty($data['letter_spacing']) ? 'letter-spacing: ' . $data['letter_spacing'] : null,
        !empty($data['border_color']) ? 'border-color: ' . $data['border_color'] : null,
    ]));
@endphp

<{{ $level }}
    class="{{ $alignment }} {{ $fontWeight }} {{ $marginTop }} {{ $marginBottom }} {{ $radius }} {{ $shadow }} {{ $borderWidth }} {{ $hover }} transition-all duration-300"
style="{{ $style }}"
>
{{ $data['content'] ?? '' }}
</{{ $level }}>
