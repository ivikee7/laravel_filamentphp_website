@props(['page' => null])
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Automated SEO Engine -->
    <x-seo.head :record="$page" />

    <!-- Theme Detection -->
    <script>
        (function () {
            const theme = localStorage.getItem('theme') || 'system';
            const isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', isDark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col justify-between">

<header class="w-full">
    @includeIf('components.section.top-bar')
    @includeIf('components.section.header')
</header>

<main class="flex-grow w-full">
    {{ $slot ?? '' }}
</main>

@includeIf('components.section.footer')

<!-- Footer Script Injection (from PageSettingsSchema) -->
@if(!empty($page?->setting['footer_scripts']))
    {!! $page->setting['footer_scripts'] !!}
@endif

</body>
</html>
