<header class="w-full bg-white/95 dark:bg-[#080e1a]/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800/80 text-slate-800 dark:text-slate-200 sticky top-0 z-40 transition-colors duration-300" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-6">

        <!-- Brand Logo (Left) -->
        <a href="/" class="flex items-center gap-2.5 group shrink-0">
            <span class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center font-black text-white text-base shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform">
                SR
            </span>
            <div class="flex flex-col">
                <span class="text-lg font-black text-slate-900 dark:text-white tracking-tight leading-none group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">SRCS Patna</span>
                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium tracking-wide uppercase">Excellence in Education</span>
            </div>
        </a>

        <!-- Desktop Navigation & 3-Mode Theme Switcher -->
        <div class="hidden md:flex items-center justify-end flex-1 gap-4">
            <x-navigation.menu
                menu="main-menu"
                layout="horizontal"
                class="justify-end gap-1.5 [&_a]:text-slate-600 dark:[&_a]:text-slate-300 [&_a]:hover:text-slate-900 dark:[&_a]:hover:text-white [&_a]:hover:bg-slate-100 dark:[&_a]:hover:bg-slate-800/80"
            />

            <!-- Desktop Theme Dropdown -->
            <div
                x-data="{ open: false }"
                @click.away="open = false"
                class="relative ml-2 pl-2 border-l border-slate-200 dark:border-slate-800"
            >
                <!-- Trigger Button -->
                <button
                    type="button"
                    @click="open = !open"
                    class="p-2 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 active:scale-95 transition-all shadow-sm focus:outline-none cursor-pointer flex items-center gap-1"
                    aria-label="Select Theme Mode"
                >
                    <!-- Sun Icon (Light Mode) -->
                    <template x-if="$store.theme.current === 'light'">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </template>

                    <!-- Moon Icon (Dark Mode) -->
                    <template x-if="$store.theme.current === 'dark'">
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </template>

                    <!-- Monitor Icon (System Default) -->
                    <template x-if="$store.theme.current === 'system'">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </template>

                    <svg class="w-3 h-3 text-slate-400 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Options Popover Menu -->
                <div
                    x-show="open"
                    x-cloak
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-36 rounded-2xl bg-white dark:bg-[#090e1a] border border-slate-200 dark:border-slate-800 shadow-2xl p-1.5 z-50 text-xs font-medium space-y-0.5"
                >
                    <button
                        type="button"
                        @click="$store.theme.set('light'); open = false"
                        :class="$store.theme.current === 'light' ? 'bg-blue-50 text-blue-600 dark:bg-slate-800 dark:text-blue-400 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/60'"
                        class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer text-left"
                    >
                        <svg class="w-3.5 h-3.5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Light</span>
                    </button>

                    <button
                        type="button"
                        @click="$store.theme.set('dark'); open = false"
                        :class="$store.theme.current === 'dark' ? 'bg-blue-50 text-blue-600 dark:bg-slate-800 dark:text-blue-400 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/60'"
                        class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer text-left"
                    >
                        <svg class="w-3.5 h-3.5 text-blue-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <span>Dark</span>
                    </button>

                    <button
                        type="button"
                        @click="$store.theme.set('system'); open = false"
                        :class="$store.theme.current === 'system' ? 'bg-blue-50 text-blue-600 dark:bg-slate-800 dark:text-blue-400 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/60'"
                        class="w-full flex items-center gap-2 px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer text-left"
                    >
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>System</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Controls: Inline 3-Mode Toggle & Hamburger -->
        <div class="flex md:hidden items-center gap-2">
            <!-- Tap to Cycle Modes on Mobile -->
            <button
                type="button"
                @click="
                    const modes = ['system', 'light', 'dark'];
                    const next = modes[(modes.indexOf($store.theme.current) + 1) % modes.length];
                    $store.theme.set(next);
                "
                class="p-2 rounded-lg bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 focus:outline-none"
                aria-label="Cycle theme mode"
            >
                <template x-if="$store.theme.current === 'light'">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </template>
                <template x-if="$store.theme.current === 'dark'">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </template>
                <template x-if="$store.theme.current === 'system'">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </template>
            </button>

            <!-- Hamburger Button -->
            <button
                type="button"
                @click="mobileOpen = !mobileOpen"
                class="p-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800/80 focus:outline-none"
                aria-label="Toggle Navigation Menu"
            >
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Drawer Dropdown -->
    <div
        x-show="mobileOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-3"
        class="md:hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-[#080e1a] px-4 pt-3 pb-6 space-y-4"
    >
        <x-navigation.menu
            menu="main-menu"
            layout="vertical"
            class="space-y-1.5 [&_a]:text-slate-600 dark:[&_a]:text-slate-300 [&_a]:hover:text-slate-900 dark:[&_a]:hover:text-white"
        />
    </div>
</header>
