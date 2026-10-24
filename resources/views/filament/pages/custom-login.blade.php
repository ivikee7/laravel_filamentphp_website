<x-filament-panels::page.simple>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-6">
        <div class="w-full max-w-md space-y-6 bg-white dark:bg-gray-800 p-8 sm:p-10 shadow-2xl border-2 border-gray-900 dark:border-gray-700 rounded-none">

            <!-- Top Header with Home Button -->
            <div class="flex items-center justify-end">
                <a href="{{ url('/') }}"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-mono uppercase tracking-wider bg-white hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 border-2 border-gray-900 dark:border-gray-600 transition rounded-none font-bold"
                   title="Return to Home">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    HOME
                </a>
            </div>

            <!-- Title Header -->
            <div>
                <h2 class="text-2xl font-black tracking-tight text-gray-900 dark:text-white uppercase">
                    WELCOME BACK, ADMIN
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Please sign in to access your control panel.
                </p>
            </div>

            <!-- Form Wrapper with Boxy Button -->
            <form wire:submit="authenticate" class="space-y-6">
                {{ $this->form }}

                <div class="pt-2">
                    <x-filament::button type="submit" class="w-full rounded-none font-bold uppercase tracking-wider py-3">
                        SIGN IN TO DASHBOARD
                    </x-filament::button>
                </div>
            </form>

            <div class="text-center text-xs text-gray-400 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 font-mono uppercase tracking-wider">
                PROTECTED BY ENTERPRISE SECURITY.
            </div>
        </div>
    </div>
</x-filament-panels::page.simple>
