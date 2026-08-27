<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 text-center">
        @if(!empty($data['title']))
            <h3 class="text-lg font-semibold text-slate-600 mb-8">{{ $data['title'] }}</h3>
        @endif

        @if(!empty($data['logos']))
            <div class="flex flex-wrap items-center justify-center gap-8">
                @foreach($data['logos'] as $logo)
                    <img
                        src="{{ asset('storage/' . $logo) }}"
                        alt="Logo"
                        class="h-12 object-contain grayscale hover:grayscale-0 transition-all"
                    >
                @endforeach
            </div>
        @endif
    </div>
</div>
