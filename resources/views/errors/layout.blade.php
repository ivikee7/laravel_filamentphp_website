<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Error') - {{ config('app.name', 'Website') }}</title>

    <script>
        (function () {
            const theme = localStorage.getItem('theme') || 'system';
            const isDark = theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
            document.documentElement.classList.toggle('dark', isDark);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col justify-between bg-slate-50 dark:bg-[#030717] text-slate-800 dark:text-slate-100 transition-colors duration-300">

<header class="w-full">
    @includeIf('components.section.top-bar')
    @includeIf('components.section.header')
</header>

<main class="flex-grow flex items-center justify-center px-4 py-16 sm:py-24">
    <div class="max-w-xl w-full text-center space-y-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800/60 shadow-md">
            @yield('icon')
        </div>

        <div class="space-y-2">
            <h1 class="text-6xl sm:text-7xl font-black tracking-tight text-slate-900 dark:text-white">
                @yield('code')
            </h1>
            <h2 class="text-2xl font-bold tracking-tight text-slate-800 dark:text-slate-100">
                @yield('title')
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base max-w-md mx-auto leading-relaxed">
                @yield('message')
            </p>
        </div>

        <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="px-6 py-3 rounded-xl font-bold text-sm bg-blue-600 hover:bg-blue-700 text-white shadow-md transition-all active:scale-95">
                Back to Home
            </a>
            <button onclick="window.history.back()" class="px-6 py-3 rounded-xl font-bold text-sm bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all shadow-xs">
                Go Back
            </button>
        </div>
    </div>
</main>

@includeIf('components.section.footer')

</body>
</html>
