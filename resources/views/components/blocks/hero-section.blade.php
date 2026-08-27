@props(['data'])

@php $bgImage = !empty($data['background_image']) ? asset('storage/' . $data['background_image']) : null; @endphp

<div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white shadow-xl my-6">
    @if($bgImage)
        <div class="absolute inset-0 bg-cover bg-center opacity-30 pointer-events-none" style="background-image: url('{{ $bgImage }}')"></div>
    @endif

    <div class="relative z-10 px-6 py-16 sm:px-12 sm:py-20 text-center max-w-3xl mx-auto space-y-6">
        @if(!empty($data['badge']))
            <span class="inline-flex items-center gap-2 bg-[#006633]/40 border border-[#006633]/60 text-emerald-300 text-xs font-semibold px-3.5 py-1.5 rounded-full uppercase tracking-wider">
                {{ $data['badge'] }}
            </span>
        @endif

        <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
            {{ $data['title'] ?? '' }}
        </h1>

        @if(!empty($data['subtitle']))
            <p class="text-slate-300 text-base sm:text-lg max-w-xl mx-auto leading-relaxed">
                {{ $data['subtitle'] }}
            </p>
        @endif

        @if(!empty($data['cta_text']) && !empty($data['cta_url']))
            <div class="pt-4">
                <a href="{{ $data['cta_url'] }}" class="inline-flex items-center gap-2 bg-[#006633] hover:bg-[#004d26] text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all">
                    {{ $data['cta_text'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        @endif
    </div>
</div>
