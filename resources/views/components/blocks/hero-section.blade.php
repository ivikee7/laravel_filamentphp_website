@props(['data' => [], 'styles' => []])

@php
    $headline = $data['headline'] ?? $headline ?? '';
    $subheadline = $data['subheadline'] ?? $subheadline ?? '';
    $badge = $data['badge'] ?? $badge ?? '';
    $primaryCtaLabel = $data['primary_cta_label'] ?? 'Get Started';
    $primaryCtaUrl = $data['primary_cta_url'] ?? '#';
    $heroImage = $data['hero_image'] ?? null;
@endphp

<x-blocks.builder-block-wrapper :styles="$styles ?? ($data['styles'] ?? [])">
    <div class="py-16 md:py-24 text-center max-w-4xl mx-auto px-4">
        @if($badge)
            <span class="inline-block px-3 py-1 mb-4 text-xs font-semibold tracking-wider uppercase bg-blue-100 text-blue-800 rounded-full">
                {{ $badge }}
            </span>
        @endif

        <h1 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tight leading-tight">
            {{ $headline }}
        </h1>

        @if($subheadline)
            <p class="mt-4 text-lg md:text-xl text-slate-600 leading-relaxed max-w-2xl mx-auto">
                {{ $subheadline }}
            </p>
        @endif

        @if($primaryCtaLabel)
            <div class="mt-8 flex justify-center gap-4">
                <a href="{{ $primaryCtaUrl }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition">
                    {{ $primaryCtaLabel }}
                </a>
            </div>
        @endif
    </div>
</x-blocks.builder-block-wrapper>
