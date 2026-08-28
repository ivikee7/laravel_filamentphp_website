@props(['data' => [], 'styles' => []])

<x-blocks.builder-block-wrapper :styles="$styles ?? ($data['styles'] ?? [])">
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 text-center shadow-lg group hover:border-blue-500/50 transition">
        @if(!empty($data['photo']))
            <img src="{{ asset('storage/' . $data['photo']) }}" alt="{{ $data['name'] ?? '' }}" class="w-28 h-28 mx-auto rounded-full object-cover border-2 border-slate-700 shadow-md mb-4 group-hover:scale-105 transition" />
        @endif
        <h4 class="text-xl font-bold text-white">{{ $data['name'] ?? '' }}</h4>
        <p class="text-sm font-semibold text-blue-400 mt-0.5">{{ $data['role'] ?? '' }}</p>
        @if(!empty($data['department']))
            <span class="inline-block text-[11px] uppercase tracking-wider text-slate-400 mt-1">{{ $data['department'] }}</span>
        @endif
        @if(!empty($data['bio']))
            <p class="text-xs text-slate-400 mt-3 leading-relaxed">{{ $data['bio'] }}</p>
        @endif
    </div>
</x-blocks.builder-block-wrapper>
