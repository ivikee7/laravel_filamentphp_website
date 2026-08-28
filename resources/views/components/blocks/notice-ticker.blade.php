@props(['data' => [], 'styles' => []])

@php
    $urgency = $data['urgency_level'] ?? 'info';
    $colorClasses = match($urgency) {
        'success' => 'bg-emerald-500/10 border-emerald-500/30 text-emerald-400',
        'warning' => 'bg-amber-500/10 border-amber-500/30 text-amber-400',
        'danger'  => 'bg-rose-500/10 border-rose-500/30 text-rose-400',
        default   => 'bg-blue-500/10 border-blue-500/30 text-blue-400',
    };
@endphp

<x-blocks.builder-block-wrapper :styles="$styles ?? ($data['styles'] ?? [])">
    <div class="flex items-center justify-between gap-4 p-4 rounded-xl border {{ $colorClasses }}">
        <div class="flex items-center gap-3">
            <span class="px-2.5 py-0.5 rounded text-xs font-bold uppercase tracking-wider bg-current/20">Notice</span>
            <p class="text-sm font-semibold text-slate-100">{{ $data['notice_text'] ?? '' }}</p>
        </div>
        @if(!empty($data['action_url']))
            <a href="{{ $data['action_url'] }}" class="text-xs font-bold underline hover:opacity-80 shrink-0">
                {{ $data['action_label'] ?? 'Details →' }}
            </a>
        @endif
    </div>
</x-blocks.builder-block-wrapper>
