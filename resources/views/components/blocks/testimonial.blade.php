<div class="max-w-4xl mx-auto my-8 p-8 bg-white border border-slate-200 rounded-3xl shadow-sm">
    <p class="text-base text-slate-700 italic font-serif leading-relaxed">
        &ldquo;{{ $data['quote'] ?? '' }}&rdquo;
    </p>

    <div class="flex items-center gap-4 mt-6">
        @if (!empty($data['author_avatar']))
            <img
                src="{{ asset('storage/' . $data['author_avatar']) }}"
                alt="{{ $data['author_name'] ?? 'Author' }}"
                class="w-12 h-12 rounded-full object-cover border border-slate-100 shadow-sm"
            >
        @endif

        <div>
            <div class="font-bold text-slate-900 text-sm">
                {{ $data['author_name'] ?? '' }}
            </div>
            @if (!empty($data['author_title']))
                <div class="text-xs text-slate-500 font-medium">
                    {{ $data['author_title'] }}
                </div>
            @endif
        </div>
    </div>
</div>
