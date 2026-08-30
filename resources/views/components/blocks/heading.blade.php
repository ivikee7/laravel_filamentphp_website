@props(['data' => []])
@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $level = $data['level'] ?? 'h2';
    $align = $data['alignment'] ?? 'text-left';
    $weight = $data['font_weight'] ?? 'font-bold';
    $text = $data['content'] ?? '';
@endphp

<div
    @if(!empty($styleData['id'])) id="{{ $styleData['id'] }}" @endif
class="{{ $styleData['classes'] }}"
    @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
>
    <{{ $level }} class="{{ $align }} {{ $weight }} tracking-tight text-slate-900 dark:text-white leading-tight">
    {{ $text }}
</{{ $level }}>
</div>
