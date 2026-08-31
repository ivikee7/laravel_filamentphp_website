<x-layouts.app :page="$content">
    @php
        $rawContent = $content->content ?? $content->blocks ?? $content->body ?? '';
        if (is_string($rawContent) && (str_starts_with(trim($rawContent), '[') || str_starts_with(trim($rawContent), '{'))) {
            $decoded = json_decode($rawContent, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $rawContent = $decoded;
            }
        }

        $blocks = is_array($rawContent) ? $rawContent : [];
        $htmlBody = is_string($rawContent) ? $rawContent : ($content->body ?? $content->description ?? '');
    @endphp

    <div class="w-full min-h-[70vh] bg-white dark:bg-[#030717] text-slate-900 dark:text-slate-100 transition-colors duration-300">

        <!-- Page Builder Sections Canvas (Full Width Fluid) -->
        @if(!empty($blocks) && count($blocks) > 0)
            <div class="w-full">
                <x-blocks.dispatcher :blocks="$blocks" />
            </div>
        @elseif(!empty($htmlBody))
            <!-- Regular Article Fallback (Boxed) -->
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-8">
                    {{ $content->title }}
                </h1>
                <div class="prose prose-slate dark:prose-invert max-w-none">
                    {!! is_string($htmlBody) && (str_contains($htmlBody, '#') || str_contains($htmlBody, '**')) ? \Illuminate\Support\Str::markdown($htmlBody) : $htmlBody !!}
                </div>
            </div>
        @endif

    </div>
</x-layouts.app>
