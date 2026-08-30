<x-layouts.app>
    <div class="w-full min-h-[70vh] py-10 lg:py-14 bg-slate-50 dark:bg-[#030717] transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full space-y-8">

            <!-- Page Header & Search -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 pb-6 border-b border-slate-200 dark:border-slate-800">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-500">Directory</span>
                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight mt-1">All Content</h1>
                </div>

                <!-- Search Bar -->
                <form action="{{ route('content.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-96">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('tag')) <input type="hidden" name="tag" value="{{ request('tag') }}"> @endif

                    <div class="relative w-full">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search content..."
                            class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl text-sm placeholder-slate-400 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all shadow-xs"
                        >
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-all shadow-md shrink-0 cursor-pointer">
                        Search
                    </button>

                    @if(request()->anyFilled(['search', 'category', 'tag']))
                        <a href="{{ route('content.index') }}" class="bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-medium px-3.5 py-2.5 rounded-xl transition-all shrink-0">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Category Filter Pills -->
            @if($categories->isNotEmpty())
                <div class="flex flex-wrap items-center gap-2">
                    <a
                        href="{{ route('content.index', array_filter(['search' => request('search'), 'tag' => request('tag')])) }}"
                        class="px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ !request('category') ? 'bg-blue-600 text-white shadow-md' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-slate-300 text-slate-600 dark:text-slate-300' }}"
                    >
                        All Categories
                    </a>
                    @foreach($categories as $cat)
                        <a
                            href="{{ route('content.index', array_filter(['category' => $cat->slug, 'search' => request('search'), 'tag' => request('tag')])) }}"
                            class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold transition-all {{ request('category') === $cat->slug ? 'bg-blue-600 text-white shadow-md' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-slate-300 text-slate-700 dark:text-slate-300' }}"
                        >
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $cat->color }};"></span>
                            <span>{{ $cat->name }}</span>
                            <span class="opacity-60 text-[10px]">({{ $cat->contents_count }})</span>
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Content Grid -->
            @if($contents->isEmpty())
                <div class="bg-white dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-3xl p-12 text-center max-w-lg mx-auto my-8 shadow-sm">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">No entries found</h3>
                    <p class="text-slate-500 text-sm mt-1">Try adjusting your filters or search terms.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($contents as $item)
                        @php
                            // Check meta.description first, then standard description/body, and lastly block builder
                            $meta = is_array($item->meta) ? $item->meta : (json_decode($item->meta ?? '', true) ?? []);
                            $rawExcerpt = $meta['description'] ?? $item->description ?? $item->body ?? '';

                            if (empty($rawExcerpt) && is_array($item->content ?? null)) {
                                foreach ($item->content as $block) {
                                    $blockData = $block['data'] ?? $block;
                                    if (!empty($blockData['description'])) { $rawExcerpt = $blockData['description']; break; }
                                    if (!empty($blockData['content'])) { $rawExcerpt = $blockData['content']; break; }
                                    if (!empty($blockData['body'])) { $rawExcerpt = $blockData['body']; break; }
                                    if (!empty($blockData['subtitle'])) { $rawExcerpt = $blockData['subtitle']; break; }
                                }
                            }
                            $cleanExcerpt = trim(strip_tags(html_entity_decode($rawExcerpt)));
                        @endphp

                        <article class="bg-white dark:bg-[#080e1a] border border-slate-200 dark:border-slate-800/80 rounded-2xl shadow-sm dark:shadow-xl hover:shadow-md hover:border-slate-300 dark:hover:border-slate-700 flex flex-col justify-between overflow-hidden group hover:-translate-y-1 transition-all duration-200">

                            @if(!empty($item->image))
                                <div class="h-48 w-full bg-slate-100 dark:bg-slate-950 overflow-hidden relative">
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @if($item->category)
                                        <div class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[11px] font-extrabold text-white shadow-md backdrop-blur-md" style="background-color: {{ $item->category->color }}ee;">
                                            {{ $item->category->name }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="h-2 w-full" style="background-color: {{ $item->category?->color ?? '#2563eb' }};"></div>
                            @endif

                            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                <div class="space-y-2.5">
                                    @if($item->category && empty($item->image))
                                        <span class="inline-block text-[11px] font-bold px-2.5 py-0.5 rounded-md text-white shadow-xs" style="background-color: {{ $item->category->color }};">
                                            {{ $item->category->name }}
                                        </span>
                                    @endif

                                    <h2 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors leading-snug">
                                        <a href="{{ route('content.show', $item->slug) }}">
                                            {{ $item->title }}
                                        </a>
                                    </h2>

                                    @if(!empty($cleanExcerpt))
                                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                            {{ Str::limit($cleanExcerpt, 130) }}
                                        </p>
                                    @endif
                                </div>

                                <div class="space-y-3 pt-4 border-t border-slate-100 dark:border-slate-800/80">
                                    @if($item->tags->isNotEmpty())
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($item->tags as $tag)
                                                <a href="{{ route('content.index', ['tag' => $tag->slug]) }}" class="text-[10px] font-semibold bg-slate-100 dark:bg-slate-800/80 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-400 hover:text-blue-600 px-2 py-0.5 rounded transition-colors">
                                                    #{{ $tag->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 font-medium">
                                        <span>{{ $item->created_at->format('M d, Y') }}</span>
                                        <a href="{{ route('content.show', $item->slug) }}" class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                                            Read More &rarr;
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </article>
                    @endforeach
                </div>

                <div class="pt-6">
                    {{ $contents->links() }}
                </div>
            @endif

        </div>
    </div>
</x-layouts.app>
