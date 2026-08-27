@props(['data'])

<div x-data="{ active: null }" class="space-y-3 my-6">
    @foreach($data['items'] ?? [] as $index => $item)
        <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm">
            <button
                @click="active = (active === {{ $index }} ? null : {{ $index }})"
                class="w-full flex items-center justify-between p-5 text-left font-semibold text-slate-800 hover:bg-slate-50 transition-colors cursor-pointer text-sm sm:text-base"
            >
                <span>{{ $item['title'] ?? '' }}</span>
                <svg :class="active === {{ $index }} ? 'rotate-180' : ''" class="w-5 h-5 text-slate-400 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="active === {{ $index }}" x-cloak class="p-5 pt-0 text-sm text-slate-600 border-t border-slate-100">
                <div class="rich-text-block pt-3">
                    {!! Str::markdown($item['content'] ?? '') !!}
                </div>
            </div>
        </div>
    @endforeach
</div>
