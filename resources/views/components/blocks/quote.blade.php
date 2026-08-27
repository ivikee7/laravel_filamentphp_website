@props(['data'])

<blockquote class="my-6 border-l-4 border-[#006633] bg-slate-50 p-6 rounded-r-2xl space-y-3">
    <p class="text-base sm:text-lg italic text-slate-700 font-serif leading-relaxed">
        &ldquo;{{ $data['text'] ?? '' }}&rdquo;
    </p>
    @if(!empty($data['author']))
        <footer class="text-xs font-semibold text-slate-500 flex items-center gap-2">
            &mdash;
            @if(!empty($data['cite']))
                <a href="{{ $data['cite'] }}" target="_blank" rel="noopener noreferrer" class="text-[#006633] hover:underline">
                    {{ $data['author'] }}
                </a>
            @else
                <span>{{ $data['author'] }}</span>
            @endif
        </footer>
    @endif
</blockquote>
