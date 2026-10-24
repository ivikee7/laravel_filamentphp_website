<x-filament-panels::page>
    <div class="space-y-6">
        <div class="p-4 bg-white dark:bg-gray-800 border-2 border-gray-900 dark:border-gray-700 shadow-xl">
            <h3 class="text-lg font-black uppercase tracking-wider text-gray-900 dark:text-white">
                Threat & Error Intelligence Hub
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Real-time monitoring of application exceptions, security rule violations, blocked payloads, and visitor IP footprints.
            </p>
        </div>

        <!-- Render the Filament Table -->
        {{ $this->table }}
    </div>
</x-filament-panels::page>
