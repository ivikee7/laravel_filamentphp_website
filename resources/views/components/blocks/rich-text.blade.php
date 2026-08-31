@props(['data' => []])

@php
    $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($data['styles'] ?? []);
    $content = $data['content'] ?? $data['body'] ?? (is_string($data) ? $data : '');
    if (is_string($content) && (str_contains($content, '#') || str_contains($content, '**') || str_contains($content, '---'))) {
        $content = \Illuminate\Support\Str::markdown($content);
    }
@endphp

@if(!empty($content))
    <div
        @if(!empty($styleData['id'])) id="{{ $styleData['id'] }}" @endif
    class="prose prose-slate dark:prose-invert max-w-none
               text-slate-900 dark:text-slate-100
               prose-p:text-slate-800 dark:prose-p:text-slate-200
               prose-headings:text-slate-950 dark:prose-headings:text-white
               prose-headings:font-bold
               prose-strong:text-slate-950 dark:prose-strong:text-white
               prose-li:text-slate-800 dark:prose-li:text-slate-200
               prose-a:text-blue-600 dark:prose-a:text-blue-400
               leading-relaxed {{ $styleData['classes'] }}"
        @if(!empty($styleData['inlineCss'])) style="{{ $styleData['inlineCss'] }}" @endif
        {!! $styleData['revealAttrs'] !!}
    >
        {!! $content !!}
    </div>
@endif
