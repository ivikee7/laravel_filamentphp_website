@if($item->type === 'nolink' || $item->type === 'heading')
    {{-- Non-clickable heading or plain label (Address, static text) --}}
    <span class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 select-none">
        @if(!empty($item->left_icon))
            <span class="shrink-0 text-slate-500 dark:text-slate-400">
                {!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}
            </span>
        @endif

        <span>{{ $item->name }}</span>

        @if(!empty($item->right_icon))
            <span class="shrink-0 text-slate-500 dark:text-slate-400 text-xs">
                {!! str_starts_with($item->right_icon, '<svg') ? $item->right_icon : $item->right_icon !!}
            </span>
        @endif
    </span>
@else
    {{-- Active Clickable Link (Internal, External, Email, Phone) --}}
    <a
        href="{{ $item->resolved_url ?? ($item->url ?? '#') }}"
        target="{{ $item->target ?? '_self' }}"
        @if(($item->target ?? '') === '_blank') rel="noopener noreferrer" @endif
        class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80 rounded-xl transition-all duration-150 active:scale-95"
    >
        @if(!empty($item->left_icon))
            <span class="shrink-0 opacity-80 text-slate-600 dark:text-slate-400">
                {!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}
            </span>
        @endif

        <span>{{ $item->name }}</span>

        @if(!empty($item->right_icon))
            <span class="shrink-0 opacity-70 text-xs text-slate-500 dark:text-slate-400">
                {!! str_starts_with($item->right_icon, '<svg') ? $item->right_icon : $item->right_icon !!}
            </span>
        @endif
    </a>
@endif
