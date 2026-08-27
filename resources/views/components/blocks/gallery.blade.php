@props(['data'])

@php
    $images = is_array($data['images'] ?? null) ? $data['images'] : [];
    $columns = $data['columns'] ?? 3;
@endphp

@if(!empty($images))
    <div class="grid grid-cols-1 md:grid-cols-{{ $columns }} gap-4 my-8">
        @foreach($images as $img)
            @php
                $path = is_array($img) ? ($img[0] ?? null) : $img;
            @endphp
            @if($path)
                <img
                    src="{{ asset('storage/' . $path) }}"
                    alt="Gallery image"
                    class="w-full h-48 object-cover rounded-xl shadow-sm hover:scale-105 transition-transform"
                >
            @endif
        @endforeach
    </div>
@endif
