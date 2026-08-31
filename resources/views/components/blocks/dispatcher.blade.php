@props(['blocks' => []])

@if(!empty($blocks))
    <div class="w-full space-y-3">
        @foreach($blocks as $block)
            @php
                $rawType = $block['type'] ?? ($block['data']['type'] ?? null);
                $data = $block['data'] ?? $block;

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
                @endif
            @endif
        @endforeach
    </div>
@endif
