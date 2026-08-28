@props(['blocks' => []])

@if(!empty($blocks) && is_iterable($blocks))
    @foreach($blocks as $block)
        @php
            $rawType = $block['type'] ?? '';
            $data = $block['data'] ?? [];
            $styles = $data['styles'] ?? [];

            // Convert snake_case (e.g., hero_section) to kebab-case (hero-section)
            $kebabType = str_replace('_', '-', $rawType);

            // Check view paths
            $viewName = null;
            if (view()->exists("components.blocks.{$kebabType}")) {
                $viewName = "components.blocks.{$kebabType}";
            } elseif (view()->exists("components.blocks.{$rawType}")) {
                $viewName = "components.blocks.{$rawType}";
            }
        @endphp

        @if($rawType === 'section')
            {{-- Root Section Canvas --}}
            @includeIf('components.blocks.section', [
                'data' => $data,
                'rows' => $data['rows'] ?? [],
                'styles' => $styles,
            ])
        @elseif($viewName)
            {{-- Standard Leaf Block --}}
            @include($viewName, [
                'data' => $data,
                'styles' => $styles,
                'block' => $data,
            ])
        @else
            <!-- Component view not found for: {{ $rawType }} (Tried: {{ $kebabType }}) -->
        @endif
    @endforeach
@endif
