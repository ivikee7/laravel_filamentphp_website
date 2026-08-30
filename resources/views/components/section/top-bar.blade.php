<div class="border-b border-slate-200 dark:border-slate-800/80 bg-slate-100 dark:bg-[#050913] text-[11px] text-slate-600 dark:text-slate-400 select-none transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2 flex flex-wrap items-center justify-between gap-3">

        {{-- Top Bar Left Menu (Address, Phone, Email with theme-aware hover accents) --}}
        <div class="flex flex-wrap items-center gap-4">
            <x-navigation.menu
                menu="top-bar-left"
                layout="inline"
                class="gap-4 text-slate-600 dark:text-slate-400 [&_a]:inline-flex [&_a]:items-center [&_a]:gap-1.5 [&_a]:transition-colors hover:[&_a]:text-blue-600 dark:hover:[&_a]:text-blue-400 [&_span]:opacity-85"
            />
        </div>

        {{-- Top Bar Right Menu (Socials, Quick Links, Portal Auth) --}}
        <div class="flex items-center gap-3.5 sm:gap-4 ml-auto sm:ml-0">
            <x-navigation.menu
                menu="top-bar-right"
                layout="inline"
                class="gap-3 sm:gap-4 text-slate-600 dark:text-slate-400 [&_a]:transition-colors hover:[&_a]:text-slate-950 dark:hover:[&_a]:text-white"
            />

            <span class="text-slate-300 dark:text-slate-800 h-3.5 w-px bg-slate-300 dark:bg-slate-800 self-center hidden sm:inline-block"></span>

            {{-- Login CTA Pill --}}
            <a
                href="/admin"
                class="inline-flex items-center gap-1.5 font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white bg-white dark:bg-slate-900/90 hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-800/90 px-2.5 py-1 rounded-md transition-all duration-150 active:scale-95 shadow-xs"
            >
                <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span>Login</span>
            </a>
        </div>

    </div>
</div>
