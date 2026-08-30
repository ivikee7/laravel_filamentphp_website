@props([
    'menu'     => null,
    'location' => null,
    'layout'   => 'horizontal', // 'horizontal', 'vertical', 'inline'
    'class'    => '',
])

@php
    $targetMenu = $menu ?? $location;
    $resolvedMenu = $targetMenu ? \App\Models\Menu::resolve($targetMenu) : null;

    $items = collect();
    if ($resolvedMenu) {
        $items = $resolvedMenu->rootItems->isNotEmpty()
            ? $resolvedMenu->rootItems
            : ($resolvedMenu->menuItems ?? collect());
    }
@endphp

@if($items->isNotEmpty())
    @if($layout === 'horizontal')
        {{-- Horizontal Header Navbar with Dropdowns --}}
        <nav class="flex items-center gap-1.5 {{ $class }}">
            @foreach($items as $item)
                @php $hasChildren = $item->children && $item->children->isNotEmpty(); @endphp

                @if(!$hasChildren)
                    @if($item->type === 'nolink' || $item->type === 'heading')
                        <span class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 select-none">
                            @if(!empty($item->left_icon))
                                <span class="shrink-0 text-slate-500 dark:text-slate-400">{!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}</span>
                            @endif
                            <span>{{ $item->name }}</span>
                        </span>
                    @else
                        <a
                            href="{{ $item->resolved_url ?? ($item->url ?? '#') }}"
                            target="{{ $item->target ?? '_self' }}"
                            @if(($item->target ?? '') === '_blank') rel="noopener noreferrer" @endif
                            class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-semibold rounded-xl text-slate-700 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80 active:scale-95 transition-all duration-150"
                        >
                            @if(!empty($item->left_icon))
                                <span class="shrink-0 opacity-80">{!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}</span>
                            @endif
                            <span>{{ $item->name }}</span>
                            @if(!empty($item->right_icon))
                                <span class="shrink-0 opacity-70 text-xs">{!! str_starts_with($item->right_icon, '<svg') ? $item->right_icon : $item->right_icon !!}</span>
                            @endif
                        </a>
                    @endif
                @else
                    {{-- Multi-level Dropdown Container --}}
                    <div
                        x-data="{ open: false }"
                        @mouseenter="open = true"
                        @mouseleave="open = false"
                        @click.away="open = false"
                        class="relative inline-block"
                    >
                        <button
                            type="button"
                            @click="open = !open"
                            :aria-expanded="open"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-semibold rounded-xl text-slate-700 dark:text-slate-200 hover:text-slate-950 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80 transition-all duration-150 cursor-pointer focus:outline-none"
                        >
                            @if(!empty($item->left_icon))
                                <span class="shrink-0 opacity-80">{!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}</span>
                            @endif
                            <span>{{ $item->name }}</span>
                            <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform duration-200" :class="{ 'rotate-180 text-slate-950 dark:text-white': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute top-full left-0 mt-1.5 w-60 rounded-2xl bg-white dark:bg-[#090e1a] border border-slate-200 dark:border-slate-800 shadow-2xl p-1.5 z-50 divide-y divide-slate-100 dark:divide-slate-800/60 backdrop-blur-xl"
                        >
                            <div class="py-1 space-y-0.5">
                                @foreach($item->children as $child)
                                    @if($child->type === 'heading' || $child->type === 'nolink')
                                        <div class="px-3.5 py-1.5 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 select-none">
                                            {{ $child->name }}
                                        </div>
                                    @else
                                        <a
                                            href="{{ $child->resolved_url ?? ($child->url ?? '#') }}"
                                            target="{{ $child->target ?? '_self' }}"
                                            @if(($child->target ?? '') === '_blank') rel="noopener noreferrer" @endif
                                            class="flex items-center justify-between px-3.5 py-2 text-sm font-medium rounded-xl text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/90 transition-all duration-150"
                                        >
                                            <span class="inline-flex items-center gap-2">
                                                @if(!empty($child->left_icon))
                                                    <span class="shrink-0 opacity-75">{!! str_starts_with($child->left_icon, '<svg') ? $child->left_icon : $child->left_icon !!}</span>
                                                @endif
                                                <span>{{ $child->name }}</span>
                                            </span>
                                            @if(!empty($child->right_icon))
                                                <span class="shrink-0 text-xs opacity-60">{!! str_starts_with($child->right_icon, '<svg') ? $child->right_icon : $child->right_icon !!}</span>
                                            @endif
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </nav>

    @elseif($layout === 'vertical')
        {{-- Vertical Sidebar / Reach Out / Footer Stack --}}
        <nav class="flex flex-col space-y-2 {{ $class }}">
            @foreach($items as $item)
                @php $hasChildren = $item->children && $item->children->isNotEmpty(); @endphp

                @if($item->type === 'heading')
                    <div class="px-3 pt-3 pb-1 text-[11px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 select-none">
                        {{ $item->name }}
                    </div>
                @elseif($item->type === 'nolink')
                    {{-- Address / Plain contact details in vertical stacks --}}
                    <div class="flex items-start gap-2.5 text-xs text-slate-600 dark:text-slate-400 leading-snug py-1">
                        @if(!empty($item->left_icon))
                            <span class="shrink-0 text-slate-500 dark:text-slate-400 mt-0.5">{!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}</span>
                        @endif
                        <span>{{ $item->name }}</span>
                    </div>
                @elseif(!$hasChildren)
                    <a
                        href="{{ $item->resolved_url ?? ($item->url ?? '#') }}"
                        target="{{ $item->target ?? '_self' }}"
                        @if(($item->target ?? '') === '_blank') rel="noopener noreferrer" @endif
                        class="flex items-center gap-2.5 text-xs text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-white transition-colors duration-150 py-1"
                    >
                        @if(!empty($item->left_icon))
                            <span class="shrink-0 text-slate-500 dark:text-slate-400">{!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}</span>
                        @endif
                        <span>{{ $item->name }}</span>
                    </a>
                @else
                    {{-- Expandable Accordion Item in Vertical Menu --}}
                    <div x-data="{ open: false }" class="w-full">
                        <button
                            type="button"
                            @click="open = !open"
                            class="w-full flex items-center justify-between px-3 py-2 text-sm font-semibold rounded-xl text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800/80 transition-colors cursor-pointer focus:outline-none"
                        >
                            <span class="inline-flex items-center gap-2">
                                @if(!empty($item->left_icon))
                                    <span class="shrink-0 opacity-80">{!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}</span>
                                @endif
                                <span>{{ $item->name }}</span>
                            </span>
                            <svg class="w-4 h-4 text-slate-500 dark:text-slate-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak class="pl-4 py-1 space-y-1 border-l border-slate-200 dark:border-slate-800 ml-3">
                            @foreach($item->children as $child)
                                <a
                                    href="{{ $child->resolved_url ?? ($child->url ?? '#') }}"
                                    target="{{ $child->target ?? '_self' }}"
                                    @if(($child->target ?? '') === '_blank') rel="noopener noreferrer" @endif
                                    class="block px-3 py-1.5 text-xs font-medium rounded-lg text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/50 transition-colors"
                                >
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </nav>

    @elseif($layout === 'inline')
        {{-- Flat Inline Row (Top bar, Footer legal) --}}
        <div class="flex flex-wrap items-center gap-4 text-xs font-medium text-slate-600 dark:text-slate-400 {{ $class }}">
            @foreach($items as $item)
                @if($item->type === 'nolink')
                    <span class="inline-flex items-center gap-1.5">
                        @if(!empty($item->left_icon))
                            <span class="shrink-0">{!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}</span>
                        @endif
                        <span>{{ $item->name }}</span>
                    </span>
                @elseif($item->type !== 'heading')
                    <a
                        href="{{ $item->resolved_url ?? ($item->url ?? '#') }}"
                        target="{{ $item->target ?? '_self' }}"
                        @if(($item->target ?? '') === '_blank') rel="noopener noreferrer" @endif
                        class="inline-flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-white transition-colors"
                    >
                        @if(!empty($item->left_icon))
                            <span class="shrink-0">{!! str_starts_with($item->left_icon, '<svg') ? $item->left_icon : $item->left_icon !!}</span>
                        @endif
                        <span>{{ $item->name }}</span>
                        @if(!empty($item->right_icon))
                            <span class="shrink-0 text-[10px]">{!! str_starts_with($item->right_icon, '<svg') ? $item->right_icon : $item->right_icon !!}</span>
                        @endif
                    </a>
                @endif
            @endforeach
        </div>
    @endif
@endif
