@props(['data' => [], 'styles' => []])

<x-blocks.builder-block-wrapper :styles="$styles ?? ($data['styles'] ?? [])">
    <div class="p-6 bg-slate-900/60 border border-slate-800 rounded-2xl hover:border-slate-700 transition">
        <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center font-bold text-lg mb-4">
            ★
        </div>
        <h3 class="text-lg font-bold text-white mb-2">{{ $data['title'] ?? '' }}</h3>
        <p class="text-sm text-slate-400 leading-relaxed">{{ $data['description'] ?? '' }}</p>
        @if(!empty($data['link_url']))
            <a href="{{ $data['link_url'] }}" class="inline-block mt-4 text-xs font-semibold text-blue-400 hover:text-blue-300">
                {{ $data['link_text'] ?? 'Learn more →' }}
            </a>
        @endif
    </div>
</x-blocks.builder-block-wrapper>
