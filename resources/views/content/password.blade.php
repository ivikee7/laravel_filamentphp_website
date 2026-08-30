<x-layouts.app :page="$content">
    <div class="min-h-[60vh] flex items-center justify-center py-16 px-4">
        <div class="w-full max-w-md bg-white dark:bg-[#080e1a] border border-slate-200 dark:border-slate-800 rounded-3xl p-8 shadow-xl text-center space-y-6">

            <div class="w-14 h-14 mx-auto rounded-2xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200 dark:border-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>

            <div class="space-y-2">
                <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">Password Protected</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    This content is protected. Please enter the password to view <span class="font-semibold text-slate-900 dark:text-white">"{{ $content->title }}"</span>.
                </p>
            </div>

            <form action="{{ route('content.show', $content->slug) }}" method="POST" class="space-y-4">
                @csrf
                <div class="text-left">
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">
                        Access Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        autofocus
                        placeholder="Enter password..."
                        class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-xl text-sm text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent transition-all"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-600/25 transition-all cursor-pointer"
                >
                    Unlock Content
                </button>
            </form>

            <div>
                <a href="{{ route('content.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-900 dark:hover:text-slate-300 transition-colors">
                    &larr; Back to Directory
                </a>
            </div>

        </div>
    </div>
</x-layouts.app>
