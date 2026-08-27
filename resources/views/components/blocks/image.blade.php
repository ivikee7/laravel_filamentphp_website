@props(['data'])

@php
    $imagePath = is_array($data['url'] ?? null) ? ($data['url'][0] ?? null) : ($data['url'] ?? null);

    $aspectRatioMap = [
        '1:1'   => 'aspect-square',
        '16:9'  => 'aspect-video',
        '4:3'   => 'aspect-4-3',
        'auto'  => 'aspect-auto',
    ];

    $aspectClass = $aspectRatioMap[$data['aspect_ratio'] ?? 'auto'] ?? 'aspect-auto';
@endphp

@if($imagePath)
    <figure class="my-4 w-full">
        <div class="overflow-hidden rounded-2xl bg-slate-100 shadow-sm">
            <img
                src="{{ asset('storage/' . $imagePath) }}"
                alt="{{ $data['alt'] ?? '' }}"
                class="w-full h-full object-cover {{ $aspectClass }}"
                loading="lazy"
            >
        </div>
        @if(!empty($data['caption']))
            <figcaption class="text-center text-xs text-slate-500 mt-2">
                {{ $data['caption'] }}
            </figcaption>
        @endif
    </figure>
@endif
