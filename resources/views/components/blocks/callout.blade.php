@props(['data'])

@php
    $type = $data['type'] ?? 'info';
    $styles = match($type) {
        'success' => 'bg-emerald-50 border-emerald-300 text-emerald-900',
        'warning' => 'bg-amber-50 border-amber-300 text-amber-900',
        'danger'  => 'bg-rose-50 border-rose-300 text-rose-900',
        default   => 'bg-sky-50 border-sky-300 text-sky-900',
    };
@endphp

<div class="p-4 rounded-xl border-l-4 {{ $styles }} my-4 shadow-sm text-sm leading-relaxed">
    {{ $data['message'] ?? '' }}
</div>
