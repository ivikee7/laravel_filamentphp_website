@props(['data'])

@php
    $qaPairs = $data['qa_pairs'] ?? [];

    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($qaPairs)->map(function ($pair) {
            return [
                '@type' => 'Question',
                'name' => $pair['question'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $pair['answer'] ?? '',
                ],
            ];
        })->toArray(),
    ];
@endphp

@if(!empty($qaPairs))
    {{-- Visible Accordion UI --}}
    <div class="my-6 space-y-4">
        @foreach($qaPairs as $pair)
            @if(!empty($pair['question']) && !empty($pair['answer']))
                <details class="group border border-slate-200 rounded-2xl bg-white p-5 shadow-sm transition-all [&_summary::-webkit-details-marker]:hidden">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-slate-900 text-base">
                        <span>{{ $pair['question'] }}</span>
                        <span class="ml-4 transition-transform group-open:rotate-180 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </summary>
                    <div class="mt-3 text-slate-600 text-sm leading-relaxed border-t border-slate-100 pt-3">
                        {{ $pair['answer'] }}
                    </div>
                </details>
            @endif
        @endforeach
    </div>

    {{-- SEO FAQ Schema (JSON-LD) --}}
    <script type="application/ld+json">
        {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
@endif
