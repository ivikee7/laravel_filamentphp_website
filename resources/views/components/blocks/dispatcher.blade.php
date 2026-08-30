@props(['blocks' => []])

@if(!empty($blocks))
    <div class="w-full space-y-8">
        @foreach($blocks as $block)
            @php
                // 1. Resolve Block Type
                $rawType = $block['type'] ?? ($block['data']['type'] ?? null);
                $data = $block['data'] ?? $block;

                // If the block is just a plain string or raw HTML/Markdown
                if (is_string($block)) {
                    $rawType = 'rich-text';
                    $data = ['content' => $block];
                }

                $viewSlug = str_replace('_', '-', (string) $rawType);
                $viewSnake = str_replace('-', '_', (string) $rawType);
            @endphp

            @if(!empty($rawType))
                @if(view()->exists("components.blocks.{$viewSlug}"))
                    @include("components.blocks.{$viewSlug}", ['data' => $data, 'block' => $block])
                @elseif(view()->exists("components.blocks.{$viewSnake}"))
                    @include("components.blocks.{$viewSnake}", ['data' => $data, 'block' => $block])
                @elseif(view()->exists("blocks.{$viewSlug}"))
                    @include("blocks.{$viewSlug}", ['data' => $data, 'block' => $block])
                @else
                    {{-- Automatic Fallback: If no custom block view exists, render its content cleanly --}}
                    @php
                        $bodyText = $data['content'] ?? $data['body'] ?? $data['text'] ?? (is_string($data) ? $data : '');
                        if (is_string($bodyText) && (str_contains($bodyText, '#') || str_contains($bodyText, '**'))) {
                            $bodyText = \Illuminate\Support\Str::markdown($bodyText);
                        }
                    @endphp

                    @if(!empty($bodyText))
                        <div class="prose prose-slate dark:prose-invert max-w-none text-slate-800 dark:text-slate-200">
                            {!! $bodyText !!}
                        </div>
                    @elseif(app()->environment('local'))
                        {{-- Helpful Debug Box only visible during local testing --}}
                        <div class="p-3 bg-amber-50 dark:bg-amber-950/40 border border-amber-300 dark:border-amber-800 text-amber-800 dark:text-amber-200 rounded-lg text-xs font-mono">
                            ⚠️ Missing view: <code>components.blocks.{{ $viewSlug }}</code> for block type: <strong>{{ $rawType }}</strong>
                        </div>
                    @endif
                @endif
            @elseif(is_array($data) && (!empty($data['content']) || !empty($data['body'])))
                {{-- If no explicit type but has content/body key --}}
                @php
                    $fallbackText = $data['content'] ?? $data['body'];
                    if (is_string($fallbackText) && (str_contains($fallbackText, '#') || str_contains($fallbackText, '**'))) {
                        $fallbackText = \Illuminate\Support\Str::markdown($fallbackText);
                    }
                @endphp
                <div class="prose prose-slate dark:prose-invert max-w-none text-slate-800 dark:text-slate-200">
                    {!! $fallbackText !!}
                </div>
            @endif
        @endforeach
    </div>
@endif
