@props(['data'])

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 my-6">
    @foreach($data['stats'] ?? [] as $stat)
        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm text-center space-y-2">
            <div class="text-3xl sm:text-4xl font-extrabold text-[#006633] tracking-tight">
                {{ $stat['value'] ?? '' }}
            </div>
            <div class="font-bold text-slate-800 text-sm">
                {{ $stat['label'] ?? '' }}
            </div>
            @if(!empty($stat['description']))
                <p class="text-xs text-slate-500">
                    {{ $stat['description'] }}
                </p>
            @endif
        </div>
    @endforeach
</div>
