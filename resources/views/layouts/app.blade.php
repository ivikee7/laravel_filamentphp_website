<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CRITICAL: Tells Vite to load and live-compile styles during "php artisan dev" --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Safe Null Coalescing for $page --}}
    <title>{{ $page?->seo_title ?? $page?->title ?? config('app.name') }}</title>

    @if(!empty($page?->seo_description))
        <meta name="description" content="{{ $page->seo_description }}">
    @endif

    {{-- Safe Keywords Processing --}}
    @if(!empty($page?->seo_keywords))
        @php
            $keywords = is_array($page->seo_keywords)
                ? $page->seo_keywords
                : json_decode($page->seo_keywords, true) ?? [];
        @endphp
        @if(count($keywords) > 0)
            <meta name="keywords" content="{{ implode(', ', $keywords) }}">
        @endif
    @endif

    <link rel="canonical" href="{{ $page->canonical_url ?? url()->current() }}">

    {{-- Meta Robots --}}
    @php
        $robots = [];
        $robots[] = ($page->is_indexable ?? true) ? 'index' : 'noindex';
        $robots[] = ($page->is_followable ?? true) ? 'follow' : 'nofollow';
        if (!empty($page?->robots_custom_tags)) {
            $robots[] = $page->robots_custom_tags;
        }
    @endphp
    <meta name="robots" content="{{ implode(', ', $robots) }}">

    {{-- OpenGraph Meta --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:title" content="{{ $page->og_title ?? $page->seo_title ?? $page->title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $page->og_description ?? $page->seo_description ?? '' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    @if(!empty($page?->og_image))
        <meta property="og:image" content="{{ asset('storage/' . $page->og_image) }}">
    @endif

    {{-- Twitter Meta --}}
    <meta name="twitter:card" content="{{ $page->twitter_card_type ?? 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $page->twitter_title ?? $page->og_title ?? $page->seo_title ?? $page->title ?? config('app.name') }}">
    <meta name="twitter:description" content="{{ $page->og_description ?? $page->seo_description ?? '' }}">
    @if(!empty($page?->og_image))
        <meta name="twitter:image" content="{{ asset('storage/' . $page->og_image) }}">
    @endif

    {{-- Custom Key-Value Meta Tags --}}
    @foreach($page->custom_meta_tags ?? [] as $name => $content)
        <meta name="{{ $name }}" content="{{ $content }}">
    @endforeach

    {{-- Header Scripts --}}
    @if(!empty($page?->header_scripts))
        {!! $page->header_scripts !!}
    @endif

    {{-- Structured JSON-LD Data --}}
    @if(!empty($page?->custom_json_ld))
        <script type="application/ld+json">
            {!! $page->custom_json_ld !!}
        </script>
    @endif
</head>
<body class="antialiased">

<x-section.top-bar />
<x-section.header />

<main>
    @if(isset($slot) && $slot->isNotEmpty())
        {{ $slot }}
    @else
        @yield('content')
    @endif
</main>

<x-section.footer />

{{-- Footer Scripts --}}
@if(!empty($page?->footer_scripts))
    {!! $page->footer_scripts !!}
@endif
</body>
</html>
