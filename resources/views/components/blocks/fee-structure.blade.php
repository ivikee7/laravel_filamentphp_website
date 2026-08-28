@props(['data' => [], 'styles' => []])

<x-blocks.builder-block-wrapper :styles="$styles ?? ($data['styles'] ?? [])">
    <div class="w-full bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="px-6 py-4 bg-slate-800/80 border-b border-slate-700">
            <h3 class="text-lg font-bold text-white">{{ $data['grade_category'] ?? 'Fee Structure' }}</h3>
        </div>
        <div class="divide-y divide-slate-800">
            @foreach($data['breakdown'] ?? [] as $item)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h5 class="text-sm font-semibold text-white">{{ $item['fee_head'] ?? '' }}</h5>
                        <p class="text-xs text-slate-400">{{ $item['frequency'] ?? '' }}</p>
                    </div>
                    <span class="text-base font-black text-emerald-400">{{ $item['amount'] ?? '' }}</span>
                </div>
            @endforeach
        </div>
        @if(!empty($data['note']))
            <div class="px-6 py-3 bg-slate-950/60 border-t border-slate-800 text-xs text-slate-500">
                {{ $data['note'] }}
            </div>
        @endif
    </div>
</x-blocks.builder-block-wrapper>
