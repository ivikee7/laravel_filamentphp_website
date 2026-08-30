<x-layouts.app :page="$content">
    @php
        $rawStyles = $content->styles ?? [];
        $styleData = \App\Filament\Schemas\StyleHelper::compileStyles($rawStyles);

        $rawContent = $content->content ?? $content->blocks ?? $content->body ?? '';
        if (is_string($rawContent) && (str_starts_with(trim($rawContent), '[') || str_starts_with(trim($rawContent), '{'))) {
            $decoded = json_decode($rawContent, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $rawContent = $decoded;
            }
        }

        $blocks = is_array($rawContent) ? $rawContent : [];
        $htmlBody = is_string($rawContent) ? $rawContent : ($content->body ?? $content->description ?? '');

        if (!empty($htmlBody) && is_string($htmlBody)) {
            if (preg_match('/^#{1,6}\s+|^\*|\*\*|___/m', $htmlBody)) {
                $htmlBody = \Illuminate\Support\Str::markdown($htmlBody);
            }
        }
    @endphp

    <div class="w-full min-h-[70vh] py-10 bg-white dark:bg-[#030717] text-slate-900 dark:text-slate-100 transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
                <a href="{{ route('content.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">&larr; Back to Directory</a>
                @if($content->category)
                    <span>/</span>
                    <span class="text-blue-600 dark:text-blue-400">{{ $content->category->name }}</span>
                @endif
            </div>

            <!-- Page Title -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                {{ $content->title }}
            </h1>

            <!-- Content Area (Forced Visible Text) -->
            <main class="w-full opacity-100! visible! text-slate-900 dark:text-slate-100">
                @if(!empty($blocks) && count($blocks) > 0)
                    <div class="w-full space-y-6">
                        <x-blocks.dispatcher :blocks="$blocks" />
                    </div>
                @elseif(!empty($htmlBody))
                    <div class="prose prose-slate dark:prose-invert max-w-none text-slate-900 dark:text-slate-100 prose-headings:text-slate-950 dark:prose-headings:text-white prose-p:text-slate-800 dark:prose-p:text-slate-200">
                        {!! $htmlBody !!}
                    </div>
                @endif
            </main>

        </div>
    </div>
</x-layouts.app>
