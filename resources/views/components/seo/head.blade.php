@props(['record' => null])

@php
    $meta = $record?->meta ?? [];
    $setting = $record?->setting ?? [];

    $title = !empty($meta['seo_title']) ? $meta['seo_title'] : ($record?->title ?? config('app.name', 'SRCS Patna'));
    $description = !empty($meta['seo_description']) ? $meta['seo_description'] : ($record?->description ?? 'Explore latest updates and content.');
    $canonicalUrl = !empty($meta['canonical_url']) ? $meta['canonical_url'] : url()->current();

    $keywords = is_array($meta['seo_keywords'] ?? null)
        ? implode(', ', $meta['seo_keywords'])
        : ($meta['seo_keywords'] ?? '');

    $robots = [];
    $robots[] = ($meta['is_indexable'] ?? true) ? 'index' : 'noindex';
    $robots[] = ($meta['is_followable'] ?? true) ? 'follow' : 'nofollow';
    if (!empty($meta['robots_custom_tags'])) {
        $robots[] = $meta['robots_custom_tags'];
    }
    $robotsString = implode(', ', $robots);

    $ogTitle = !empty($meta['og_title']) ? $meta['og_title'] : $title;
    $ogDesc = !empty($meta['og_description']) ? $meta['og_description'] : $description;
    $ogImage = !empty($meta['og_image'])
        ? asset('storage/' . $meta['og_image'])
        : (!empty($record?->image) ? asset($record->image) : asset('images/og-default.jpg'));
    $twitterCard = $meta['twitter_card_type'] ?? 'summary_large_image';
    $twitterTitle = !empty($meta['twitter_title']) ? $meta['twitter_title'] : $ogTitle;

    $schemaType = $meta['schema_type'] ?? 'Article';

    $defaultSchema = json_encode([
        '@context' => 'https://schema.org',
        '@type' => $schemaType,
        'headline' => $title,
        'description' => $description,
        'image' => $ogImage,
        'url' => url()->current(),
        'datePublished' => $record?->created_at?->toIso8601String(),
        'dateModified' => $record?->updated_at?->toIso8601String(),
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
@endphp

    <!-- Primary Meta Tags -->
<title>{{ $title }}</title>
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $description }}">
@if(!empty($keywords))
    <meta name="keywords" content="{{ $keywords }}">
@endif
<meta name="robots" content="{{ $robotsString }}">
<link rel="canonical" href="{{ $canonicalUrl }}">

<!-- Open Graph / Facebook / LinkedIn -->
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDesc }}">
<meta property="og:image" content="{{ $ogImage }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ $twitterTitle }}">
<meta name="twitter:description" content="{{ $ogDesc }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<!-- Custom Head Scripts -->
@if(!empty($setting['header_scripts']))
    {!! $setting['header_scripts'] !!}
@endif

<!-- Custom Meta Key-Values -->
@if(!empty($setting['custom_meta_tags']) && is_array($setting['custom_meta_tags']))
    @foreach($setting['custom_meta_tags'] as $name => $contentValue)
        <meta name="{{ $name }}" content="{{ $contentValue }}">
    @endforeach
@endif

<!-- Structured Data JSON-LD -->
<script type="application/ld+json">
    {!! !empty($meta['custom_json_ld']) ? $meta['custom_json_ld'] : $defaultSchema !!}
</script>
