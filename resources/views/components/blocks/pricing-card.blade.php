@props(['data'])
<div class="border border-gray-200 dark:border-gray-800 rounded-2xl p-6 bg-white dark:bg-gray-900 shadow-sm flex flex-col justify-between">
    <div>
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['plan_name'] ?? 'Plan' }}</h3>
        <div class="mt-4 flex items-baseline gap-1">
            <span class="text-4xl font-extrabold text-gray-900 dark:text-white">{{ $data['price'] ?? '$0' }}</span>
            <span class="text-sm text-gray-500">{{ $data['billing_cycle'] ?? '' }}</span>
        </div>
        <ul class="mt-6 space-y-3">
            @foreach($data['features'] ?? [] as $item)
                <li class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <span class="{{ ($item['is_included'] ?? '1') === '1' ? 'text-green-500' : 'text-gray-300' }}">✓</span>
                    {{ $item['feature_text'] ?? '' }}
                </li>
            @endforeach
        </ul>
    </div>
    <a href="{{ $data['button_url'] ?? '#' }}" class="mt-8 block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition">
        {{ $data['button_text'] ?? 'Choose Plan' }}
    </a>
</div>
