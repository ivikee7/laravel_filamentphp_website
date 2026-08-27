@props(['data'])

<div class="flex flex-wrap items-center gap-3 my-4">
    @foreach($data['buttons'] ?? [] as $btn)
        @php
            $style = match($btn['style'] ?? 'primary') {
                'secondary' => 'bg-slate-800 text-white hover:bg-slate-700 shadow-sm',
                'outline'   => 'border-2 border-slate-300 text-slate-700 hover:border-slate-800 hover:bg-slate-50',
                default     => 'bg-[#006633] text-white hover:bg-[#004d26] shadow-md',
            };
            $target = !empty($btn['open_in_new_tab']) ? '_blank' : '_self';
        @endphp

        <a
            href="{{ $btn['url'] ?? '#' }}"
            target="{{ $target }}"
            class="inline-flex items-center justify-center font-semibold px-5 py-2.5 rounded-xl text-sm transition-all {{ $style }}"
        >
            {{ $btn['label'] ?? 'Click' }}
        </a>
    @endforeach
</div>
