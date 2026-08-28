@props(['data' => [], 'styles' => []])

<x-blocks.builder-block-wrapper :styles="$styles ?? ($data['styles'] ?? [])">
    <div class="flex items-center justify-between p-4 bg-slate-900 border border-slate-800 rounded-xl hover:border-blue-500/40 transition">
        <div class="flex items-center gap-3.5">
            <div class="w-10 h-10 rounded-lg bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-sm">
                PDF
            </div>
            <div>
                <h5 class="text-sm font-bold text-white">{{ $data['resource_title'] ?? '' }}</h5>
                <p class="text-xs text-slate-400">{{ $data['file_meta'] ?? 'Downloadable Document' }}</p>
            </div>
        </div>
        @if(!empty($data['file_asset']))
            <a href="{{ asset('storage/' . $data['file_asset']) }}" download class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xs rounded-lg transition">
                {{ $data['cta_label'] ?? 'Download' }}
            </a>
        @endif
    </div>
</x-blocks.builder-block-wrapper>
