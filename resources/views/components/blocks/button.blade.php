@props(['data'])
<div class="inline-block">
    <a
        href="{{ $data['url'] ?? '#' }}"
        target="{{ $data['target'] ?? '_self' }}"
        class="px-6 py-3 rounded-xl font-semibold transition-all shadow-sm hover:opacity-90 inline-flex items-center gap-2 {{ $data['size'] ?? 'btn-md' }} {{ $data['style'] ?? 'btn-primary' }}"
        style="{{ !empty($data['custom_bg']) ? 'background-color:' . $data['custom_bg'] . ';' : '' }}"
    >
        {{ $data['label'] ?? 'Click Here' }}
    </a>
</div>
