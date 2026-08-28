@props(['data' => [], 'styles' => []])

<x-blocks.builder-block-wrapper :styles="$styles ?? ($data['styles'] ?? [])">
    <div
        x-data="{ count: {{ $data['start_number'] ?? 0 }}, target: {{ $data['target_number'] ?? 100 }} }"
        x-intersect.once="let step = Math.ceil(target / 40); let timer = setInterval(() => { count += step; if (count >= target) { count = target; clearInterval(timer); } }, 30);"
        class="text-center p-6 bg-slate-900 border border-slate-800 rounded-2xl"
    >
        <div class="text-4xl md:text-5xl font-black text-blue-500">
            <span x-text="count">0</span>{{ $data['suffix'] ?? '+' }}
        </div>
        <h4 class="text-lg font-bold text-white mt-2">{{ $data['title'] ?? '' }}</h4>
        @if(!empty($data['description']))
            <p class="text-xs text-slate-400 mt-1">{{ $data['description'] }}</p>
        @endif
    </div>
</x-blocks.builder-block-wrapper>
