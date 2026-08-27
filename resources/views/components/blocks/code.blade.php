@props(['data'])

<div class="my-4 rounded-2xl overflow-hidden bg-slate-900 border border-slate-800 shadow-md">
    <div class="flex items-center justify-between px-4 py-2 bg-slate-800/60 text-slate-400 text-xs font-mono border-b border-slate-800">
        <span>{{ strtoupper($data['language'] ?? 'code') }}</span>
        <button onclick="navigator.clipboard.writeText(this.parentElement.nextElementSibling.innerText)" class="hover:text-white transition-colors cursor-pointer">
            Copy
        </button>
    </div>
    <pre class="p-4 text-xs sm:text-sm text-emerald-400 font-mono overflow-x-auto leading-relaxed"><code>{{ $data['content'] ?? '' }}</code></pre>
</div>
