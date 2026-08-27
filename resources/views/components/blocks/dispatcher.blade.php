@props(['block'])

@php
    $type = $block['type'] ?? null;
    $data = $block['data'] ?? [];
@endphp

@if($type)
    <x-dynamic-component :component="'blocks.' . Str::kebab($type)" :data="$data" />
@endif
