@props(['data'])

@php
    $height = match($data['height'] ?? 'md') {
        'sm' => 'h-6',
        'lg' => 'h-24',
        default => 'h-12',
    };
@endphp

<div class="{{ $height }} w-full" aria-hidden="true"></div>
