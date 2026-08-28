@props(['styles' => []])

@php
    $compiled = \App\Filament\Schemas\StyleHelper::compileStyles($styles ?? []);
@endphp

<section
    @if($compiled['id']) id="{{ $compiled['id'] }}" @endif
{!! $compiled['revealAttrs'] !!}
class="relative overflow-hidden transition-all {{ $compiled['classes'] }}"
    @if($compiled['inlineCss']) style="{{ $compiled['inlineCss'] }}" @endif
>
    {{-- Mask Overlay for Background Images --}}
    @if($compiled['overlay']['active'])
        <div
            class="absolute inset-0 pointer-events-none {{ $compiled['overlay']['opacity'] }}"
            style="background-color: {{ $compiled['overlay']['color'] }};"
        ></div>
    @endif

    {{-- Block Inner Content --}}
    <div class="relative z-10 w-full">
        {{ $slot }}
    </div>
</section>
