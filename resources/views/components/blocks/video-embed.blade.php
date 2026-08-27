@props(['data'])

@php
    $url = $data['url'] ?? '';
    // Handle YouTube/Vimeo embed conversion logic
    if (str_contains($url, 'youtube.com/watch?v=')) {
        $url = str_replace('youtube.com/watch?v=', 'youtube.com/embed/', $url);
    } elseif (str_contains($url, 'youtu.be/')) {
        $url = str_replace('youtu.be/', 'youtube.com/embed/', $url);
    }
@endphp

<div class="my-6 aspect-video rounded-2xl overflow-hidden shadow-md border border-slate-200 bg-slate-900">
    <iframe
        src="{{ $url }}"
        class="w-full h-full border-0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
    ></iframe>
</div>
