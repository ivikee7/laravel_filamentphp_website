@props(['data'])

@php
    $items = $data['items'] ?? [];
@endphp

@if(!empty($items))
    <div x-data="{ activeTab: 0 }" class="my-6 border border-slate-200 rounded-2xl bg-white shadow-sm overflow-hidden">
        {{-- Tab Headers --}}
        <div class="flex flex-wrap border-b border-slate-200 bg-slate-50/50 p-1">
            @foreach($items as $index => $item)
                <button
                    type="button"
                    @click="activeTab = {{ $index }}"
                    :class="activeTab === {{ $index }}
                        ? 'bg-white text-slate-900 shadow-sm border-b-2 border-[#006633] font-semibold'
                        : 'text-slate-600 hover:text-slate-900 font-medium'"
                    class="px-5 py-3 text-sm transition-all rounded-lg focus:outline-none"
                >
                    {{ $item['label'] ?? 'Tab ' . ($index + 1) }}
                </button>
            @endforeach
        </div>

        {{-- Tab Contents --}}
        <div class="p-6">
            @foreach($items as $index => $item)
                <div
                    x-show="activeTab === {{ $index }}"
                    x-cloak
                    class="prose prose-slate max-w-none
                        [&>p]:text-slate-700 [&>p]:leading-relaxed [&>p]:mb-4
                        [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mb-4 [&>ul]:space-y-2
                        [&>strong]:font-semibold [&>strong]:text-slate-900"
                >
                    {!! $item['content'] ?? '' !!}
                </div>
            @endforeach
        </div>
    </div>
@endif
