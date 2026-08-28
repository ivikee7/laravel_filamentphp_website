<x-layouts.app :page="$page">
    <div class="w-full">
        @if(empty($page->content))
            <div class="py-20 text-center text-slate-500">
                <p class="text-xl font-bold">No blocks found in content.</p>
                <p class="text-sm">Please add blocks in Filament and save the page.</p>
            </div>
        @else
            <x-blocks.dispatcher :blocks="$page->content" />
        @endif
    </div>
</x-layouts.app>
