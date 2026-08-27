@extends('layouts.app')

@section('title', 'Home - Welcome')

@section('content')
    <div class="min-h-screen bg-slate-50 py-10 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">

            <!-- Hero Section -->
            <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white shadow-xl">
                <!-- Background Glow Effect -->
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#006633]/30 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 px-6 py-16 sm:px-12 sm:py-24 text-center max-w-4xl mx-auto space-y-6">
                <span class="inline-flex items-center gap-2 bg-[#006633]/30 border border-[#006633]/50 text-emerald-400 text-xs font-semibold px-3.5 py-1.5 rounded-full uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Welcome to Our Platform
                </span>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-balance leading-tight">
                        Discover Practical Insights & Featured Content
                    </h1>

                    <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                        Explore our latest stories, in-depth articles, and parent-first resources curated to support your decision-making.
                    </p>

                    <div class="pt-4 flex flex-wrap justify-center gap-4">
                        <a href="{{ route('content.index') }}" class="inline-flex items-center gap-2 bg-[#006633] hover:bg-[#004d26] text-white font-semibold px-7 py-3.5 rounded-xl shadow-lg shadow-[#006633]/25 transition-all cursor-pointer">
                            Browse All Content
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Featured Frontpage Items Section -->
            <div class="space-y-8">
                <div class="flex items-end justify-between border-b border-slate-200 pb-4">
                    <div>
                        <span class="text-xs font-semibold uppercase tracking-wider text-[#006633]">Highlights</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Featured Content</h2>
                    </div>

                    <a href="{{ route('content.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-semibold text-[#006633] hover:text-[#004d26] transition-colors">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                @if($latestContent->isEmpty())
                    <div class="bg-white rounded-2xl p-12 text-center border border-slate-200 shadow-sm max-w-md mx-auto">
                        <p class="text-slate-500 font-medium">No frontpage items available right now.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($latestContent as $item)
                            <article class="bg-white rounded-2xl shadow-sm border border-slate-200 hover:border-slate-300 transition-all duration-200 flex flex-col justify-between overflow-hidden group">

                                <!-- Optional Thumbnail Preview -->
                                @if(!empty($item->image))
                                    <div class="h-48 w-full bg-slate-100 overflow-hidden">
                                        <img src="{{ asset($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                @endif

                                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                        <span class="inline-block bg-emerald-50 text-[#006633] border border-emerald-200 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md">
                                            Featured
                                        </span>
                                            <time class="text-xs text-slate-400 font-medium">
                                                {{ $item->created_at->format('M d, Y') }}
                                            </time>
                                        </div>

                                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-[#006633] transition-colors leading-snug">
                                            <a href="{{ route('content.show', $item->slug) }}">
                                                {{ $item->title }}
                                            </a>
                                        </h3>

                                        <p class="text-slate-600 text-sm mt-3 leading-relaxed line-clamp-3">
                                            {{ Str::limit(strip_tags($item->description ?? $item->body), 120) }}
                                        </p>
                                    </div>

                                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                                        <a href="{{ route('content.show', $item->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#006633] hover:text-[#004d26] transition-colors">
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
                @endif
            </div>

            <!-- Bottom Callout Section -->
            <div class="bg-gradient-to-r from-emerald-900 to-slate-900 rounded-3xl p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <h3 class="text-2xl font-bold">Looking for specific information?</h3>
                    <p class="text-emerald-200/80 text-sm">Explore our directory to filter topics and search articles directly.</p>
                </div>
                <a href="{{ route('content.index') }}" class="bg-white text-slate-900 hover:bg-slate-100 font-semibold px-6 py-3 rounded-xl text-sm transition-all shrink-0">
                    Search Directory
                </a>
            </div>

        </div>
    </div>
@endsection
