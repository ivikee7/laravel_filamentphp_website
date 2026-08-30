@props(['data' => []])
@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $type = $data['type'] ?? 'info';
    $theme = match($type) {
        'success' => 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-300 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200',
        'warning' => 'bg-amber-50 dark:bg-amber-950/40 border-amber-300 dark:border-amber-800 text-amber-900 dark:text-amber-200',
        'danger'  => 'bg-rose-50 dark:bg-rose-950/40 border-rose-300 dark:border-rose-800 text-rose-900 dark:text-rose-200',
        default   => 'bg-blue-50 dark:bg-blue-950/40 border-blue-300 dark:border-blue-800 text-blue-900 dark:text-blue-200',
    };
@endphp

<div class="border rounded-2xl p-5 {{ $theme }} {{ $styleData['classes'] }}" @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif>
    @if(!empty($data['title']))
        <h4 class="font-bold text-base mb-1 tracking-tight">{{ $data['title'] }}</h4>
    @endif
    <p class="text-sm leading-relaxed opacity-90">{{ $data['message'] ?? '' }}</p>
</div>
