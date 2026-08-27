@extends('layouts.app')

@section('title', 'All Content')

@section('content')
    <div class="min-h-screen bg-slate-50 py-10 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <!-- Page Header & Search Bar -->
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 pb-8 border-b border-slate-200">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-[#006633]">Directory</span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-1">All Content</h1>
                    <p class="text-slate-500 text-sm mt-1">Explore our latest articles, guides, and updates.</p>
                </div>

                <!-- Search Form -->
                <form action="{{ route('content.index') }}" method="GET" class="flex items-center gap-2 w-full md:w-80">
                    <div class="relative w-full">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search articles..."
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm placeholder-slate-400 text-slate-800 focus:outline-none focus:ring-2 focus:ring-[#006633] focus:border-transparent transition-all shadow-sm"
                        >
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <button type="submit" class="bg-[#006633] hover:bg-[#004d26] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shrink-0 shadow-sm cursor-pointer">
                        Search
                    </button>

                    @if(request()->filled('search'))
                        <a href="{{ route('content.index') }}" class="px-3 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium rounded-xl transition-all shrink-0">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            <!-- Content Grid -->
            @if($contents->isEmpty())
                <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-sm max-w-lg mx-auto my-12">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">No content found</h3>
                    <p class="text-slate-500 text-sm mt-1">Try adjusting your search query or clear filters.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($contents as $item)
                        <article class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-slate-300 transition-all duration-200 flex flex-col justify-between overflow-hidden group">

                            <!-- Featured Image Preview -->
                            @if(!empty($item->image))
                                <div class="h-48 w-full bg-slate-100 overflow-hidden">
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                            @endif

                            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                <div>
                                    @if($item->is_frontpage)
                                        <span class="inline-block bg-emerald-50 text-[#006633] border border-emerald-200 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md mb-3">
                                        Featured
                                    </span>
                                    @endif

                                    <h2 class="text-xl font-bold text-slate-900 group-hover:text-[#006633] transition-colors leading-snug">
                                        <a href="{{ route('content.show', $item->slug) }}">
                                            {{ $item->title }}
                                        </a>
                                    </h2>

                                    <p class="text-slate-600 text-sm mt-3 leading-relaxed line-clamp-3">
                                        {{ Str::limit(strip_tags($item->description ?? $item->body), 140) }}
                                    </p>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 font-medium">
                                    <span>{{ $item->created_at->format('M d, Y') }}</span>
                                    <a href="{{ route('content.show', $item->slug) }}" class="inline-flex items-center gap-1 text-[#006633] font-semibold hover:text-[#004d26] transition-colors">
                                        Read Article
                                        <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                        </article>
                    @endforeach
                </div>

                <!-- Pagination Links -->
                <div class="pt-8">
                    {{ $contents->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection
