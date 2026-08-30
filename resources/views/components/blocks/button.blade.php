@props(['data' => []])
@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $style = $data['style'] ?? 'btn-primary';
    $size = match($data['size'] ?? 'btn-md') {
        'btn-sm' => 'px-3.5 py-1.5 text-xs',
        'btn-lg' => 'px-6 py-3.5 text-base',
        default  => 'px-4.5 py-2.5 text-sm',
    };
    $customBg = !empty($data['custom_bg']) ? "background-color: {$data['custom_bg']};" : '';
@endphp

<div class="{{ $styleData['classes'] }}" @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif>
    <a
        href="{{ $data['url'] ?? '#' }}"
        target="{{ $data['target'] ?? '_self' }}"
        class="inline-flex items-center justify-center font-bold rounded-xl transition-all active:scale-95 shadow-xs {{ $size }} {{ $style }}"
        @if(!empty($customBg)) style="{{ $customBg }}" @endif
    >
        {{ $data['label'] ?? 'Click Here' }}
    </a>
</div>
