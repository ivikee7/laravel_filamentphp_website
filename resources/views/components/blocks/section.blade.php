@props(['data' => [], 'rows' => [], 'styles' => []])

<x-blocks.builder-block-wrapper :styles="$styles ?? []">
    <div class="w-full space-y-8">
        @foreach($rows as $row)
            @php
                $layout = $row['columns_layout'] ?? '1';
                $gap = $row['gap'] ?? 'gap-8';
                $align = $row['align_items'] ?? 'items-start';

                // Map grid layouts to Tailwind CSS grid classes
                $gridClass = match($layout) {
                    '2'   => 'grid grid-cols-1 md:grid-cols-2',
                    '3'   => 'grid grid-cols-1 md:grid-cols-3',
                    '4'   => 'grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4',
                    '1-2' => 'grid grid-cols-1 md:grid-cols-3 [&>*:nth-child(2)]:md:col-span-2',
                    '2-1' => 'grid grid-cols-1 md:grid-cols-3 [&>*:nth-child(1)]:md:col-span-2',
                    default => 'grid grid-cols-1',
                };
            @endphp

            <div class="{{ $gridClass }} {{ $gap }} {{ $align }} w-full">
                @foreach($row['columns'] ?? [] as $col)
                    <div class="w-full">
                        <x-blocks.dispatcher :blocks="$col['blocks'] ?? []" />
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</x-blocks.builder-block-wrapper>
