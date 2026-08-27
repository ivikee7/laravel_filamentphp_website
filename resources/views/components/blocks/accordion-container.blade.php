@props(['data'])

<div class="w-full space-y-3" x-data="{ active: null }">
    @foreach($data['items'] ?? [] as $index => $item)
        <div class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm">
            <button
                type="button"
                @click="active = (active === {{ $index }} ? null : {{ $index }})"
                class="w-full text-left px-5 py-4 font-semibold text-gray-800 flex justify-between items-center"
            >
                <span>{{ $item['title'] ?? 'Accordion Item' }}</span>
                <span x-show="active !== {{ $index }}">+</span>
                <span x-show="active === {{ $index }}">-</span>
            </button>
            <div x-show="active === {{ $index }}" x-collapse class="p-5 border-t border-gray-100 space-y-4">
                @foreach($item['blocks'] ?? [] as $nestedBlock)
                    <x-blocks.dispatcher :block="$nestedBlock" />
                @endforeach
            </div>
        </div>
    @endforeach
</div>
