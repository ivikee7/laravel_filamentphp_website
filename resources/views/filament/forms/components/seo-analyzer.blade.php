<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="highLevelSeoEngine()"
        x-init="initEngine()"
        class="space-y-6 p-4 sm:p-6 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl text-gray-900 dark:text-gray-100 shadow-sm transition-colors duration-200 font-sans"
    >
        <!-- 1. Executive Performance KPI Dashboard -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            <!-- SEO Score Card -->
            <div class="p-4 bg-gray-50 dark:bg-gray-800/60 rounded-xl border border-gray-200 dark:border-gray-700/60 flex items-center justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold block">SEO Score</span>
                    <h4 class="text-2xl sm:text-3xl font-black mt-0.5 truncate" :class="seoScoreColorClass" x-text="seoScorePercent + '/100'">0/100</h4>
                    <span class="text-[11px] font-semibold block truncate" :class="seoScoreColorClass" x-text="seoScoreRating">Evaluating...</span>
                </div>
                <div class="relative shrink-0 w-12 h-12 flex items-center justify-center">
                    <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-gray-200 dark:text-gray-700" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path :class="seoStrokeColorClass" stroke-dasharray="100, 100" :stroke-dashoffset="100 - seoScorePercent" stroke-width="3.5" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                </div>
            </div>

            <!-- Readability Card -->
            <div class="p-4 bg-gray-50 dark:bg-gray-800/60 rounded-xl border border-gray-200 dark:border-gray-700/60 flex items-center justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold block">Readability</span>
                    <h4 class="text-2xl sm:text-3xl font-black mt-0.5 truncate" :class="readabilityColorClass" x-text="fleschScore + '/100'">0/100</h4>
                    <span class="text-[11px] font-medium text-gray-500 dark:text-gray-400 block truncate" x-text="readabilityRating">Evaluating...</span>
                </div>
                <div class="w-3.5 h-3.5 rounded-full shrink-0" :class="readabilityBadge"></div>
            </div>

            <!-- Focus Keyword Card -->
            <div class="p-4 bg-gray-50 dark:bg-gray-800/60 rounded-xl border border-gray-200 dark:border-gray-700/60 flex flex-col justify-between gap-2">
                <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">Focus Keyword</span>
                <div class="min-w-0">
                    <p class="text-sm font-extrabold text-blue-600 dark:text-blue-400 truncate" x-text="focusKeyword ? '&ldquo;' + focusKeyword + '&rdquo;' : 'None Defined'"></p>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 mt-0.5" x-text="keywordDensity + '% density (' + keywordMatches + 'x)'"></p>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 h-1.5 rounded-full overflow-hidden">
                    <div class="h-full transition-all duration-500" :class="keywordDensityColor" :style="'width: ' + Math.min(100, keywordDensity * 35) + '%'"></div>
                </div>
            </div>

            <!-- Page Content Card -->
            <div class="p-4 bg-gray-50 dark:bg-gray-800/60 rounded-xl border border-gray-200 dark:border-gray-700/60 flex flex-col justify-between gap-2">
                <span class="text-[10px] uppercase tracking-wider text-gray-500 dark:text-gray-400 font-bold">Page Content</span>
                <div class="grid grid-cols-3 gap-2 text-center mt-1">
                    <div class="min-w-0">
                        <span class="text-base sm:text-lg font-black text-gray-900 dark:text-white block truncate" x-text="metrics.words">0</span>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase font-semibold">Words</p>
                    </div>
                    <div class="min-w-0 border-x border-gray-200 dark:border-gray-700/80 px-1">
                        <span class="text-base sm:text-lg font-black text-gray-900 dark:text-white block truncate" x-text="metrics.headings">0</span>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase font-semibold">Headings</p>
                    </div>
                    <div class="min-w-0">
                        <span class="text-base sm:text-lg font-black text-gray-900 dark:text-white block truncate" x-text="metrics.readingTime + 'm'">0m</span>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase font-semibold">Read Time</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Snippet Preview Simulation -->
        <div x-data="{ previewTab: 'google' }" class="p-4 sm:p-5 bg-gray-50 dark:bg-gray-800/40 rounded-xl border border-gray-200 dark:border-gray-800 space-y-3">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 border-b border-gray-200 dark:border-gray-800 pb-3">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-gray-700 dark:text-gray-300">Snippet Preview</span>
                    <span class="text-[11px] font-mono text-gray-500 truncate max-w-xs" x-text="getFullLiveUrl()"></span>

                    <!-- Visit Live Page Icon Button -->
                    <template x-if="slug">
                        <a
                            :href="getFullLiveUrl()"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center gap-1 text-[11px] font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-800/60 px-2.5 py-0.5 rounded-md transition-all hover:shadow-xs group"
                            title="Visit Web Page in New Tab"
                        >
                            <span>Visit Page</span>
                            <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </template>
                </div>
                <div class="flex gap-1 p-1 bg-white dark:bg-gray-900 rounded-lg border border-gray-200 dark:border-gray-800 text-xs">
                    <button type="button" @click="previewTab = 'google'" class="px-2.5 py-1 rounded font-semibold transition-all cursor-pointer" :class="previewTab === 'google' ? 'bg-blue-600 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'">Google</button>
                    <button type="button" @click="previewTab = 'social'" class="px-2.5 py-1 rounded font-semibold transition-all cursor-pointer" :class="previewTab === 'social' ? 'bg-blue-600 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'">Social</button>
                    <button type="button" @click="previewTab = 'twitter'" class="px-2.5 py-1 rounded font-semibold transition-all cursor-pointer" :class="previewTab === 'twitter' ? 'bg-blue-600 text-white shadow-xs' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'">Twitter</button>
                </div>
            </div>

            <!-- Google View -->
            <div x-show="previewTab === 'google'" class="p-4 bg-white dark:bg-[#202124] rounded-lg border border-gray-200 dark:border-gray-700/80 font-sans max-w-2xl shadow-xs">
                <div class="text-xs text-gray-600 dark:text-[#bdc1c6] truncate flex items-center justify-between gap-1.5">
                    <div class="flex items-center gap-1.5 truncate">
                        <span class="w-4 h-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-[9px] text-gray-700 dark:text-gray-300 font-bold shrink-0">G</span>
                        <span class="truncate" x-text="previewDomain + ' › ' + (slug || 'your-slug')"></span>
                    </div>

                    <!-- Direct Icon Link -->
                    <template x-if="slug">
                        <a
                            :href="getFullLiveUrl()"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors p-0.5 rounded shrink-0"
                            title="Open in new tab"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                        </a>
                    </template>
                </div>

                <h3 class="text-base sm:text-lg font-medium leading-snug truncate mt-1">
                    <a
                        :href="slug ? getFullLiveUrl() : '#'"
                        :target="slug ? '_blank' : '_self'"
                        class="text-blue-700 dark:text-[#8ab4f8] hover:underline"
                        x-text="previewTitle"
                    ></a>
                </h3>
                <p class="text-xs text-gray-600 dark:text-[#bdc1c6] mt-1 line-clamp-2 leading-relaxed" x-text="previewDescription"></p>
            </div>

            <!-- OpenGraph / Social Preview -->
            <div x-show="previewTab === 'social'" x-cloak class="border border-gray-200 dark:border-gray-700/60 rounded-xl overflow-hidden max-w-md bg-white dark:bg-gray-950 shadow-xs">
                <div class="h-44 bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden relative">
                    <template x-if="ogImage">
                        <img :src="ogImage" x-on:error="ogImage = ''" alt="OG Preview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!ogImage">
                        <div class="text-center p-4">
                            <svg class="w-8 h-8 mx-auto text-gray-400 dark:text-gray-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 font-mono">No Social Image Set (1200×630)</span>
                        </div>
                    </template>
                </div>
                <div class="p-3 bg-gray-50 dark:bg-[#242526] border-t border-gray-200 dark:border-gray-800">
                    <span class="text-[10px] uppercase text-gray-500 dark:text-gray-400 tracking-wider block" x-text="previewDomain"></span>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate mt-0.5" x-text="ogTitle || previewTitle"></h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 mt-0.5" x-text="ogDesc || previewDescription"></p>
                </div>
            </div>

            <!-- Twitter Card Preview -->
            <div x-show="previewTab === 'twitter'" x-cloak class="border border-gray-200 dark:border-gray-700/60 rounded-2xl overflow-hidden max-w-md bg-white dark:bg-black shadow-xs">
                <div class="h-44 bg-gray-100 dark:bg-gray-900 flex items-center justify-center overflow-hidden relative">
                    <template x-if="ogImage">
                        <img :src="ogImage" x-on:error="ogImage = ''" alt="Twitter Preview" class="w-full h-full object-cover">
                    </template>
                    <template x-if="!ogImage">
                        <div class="text-center p-4">
                            <svg class="w-8 h-8 mx-auto text-gray-400 dark:text-gray-600 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-[11px] text-gray-500 dark:text-gray-400 font-mono">Large Twitter Banner</span>
                        </div>
                    </template>
                </div>
                <div class="p-3 bg-white dark:bg-black border-t border-gray-200 dark:border-gray-900">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 truncate" x-text="ogTitle || previewTitle"></h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-1 mt-0.5" x-text="ogDesc || previewDescription"></p>
                </div>
            </div>
        </div>

        <!-- 3. Audit Checks Matrix -->
        <div x-data="{ activeFilter: 'all' }" class="space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-200 dark:border-gray-800 pb-3">
                <div class="flex flex-wrap gap-1.5 text-xs font-semibold">
                    <button type="button" @click="activeFilter = 'all'" class="px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer" :class="activeFilter === 'all' ? 'bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'">All</button>
                    <button type="button" @click="activeFilter = 'onpage'" class="px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer" :class="activeFilter === 'onpage' ? 'bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'">On-Page</button>
                    <button type="button" @click="activeFilter = 'content'" class="px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer" :class="activeFilter === 'content' ? 'bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'">Content</button>
                    <button type="button" @click="activeFilter = 'technical'" class="px-2.5 py-1.5 rounded-lg transition-colors cursor-pointer" :class="activeFilter === 'technical' ? 'bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white'">Technical</button>
                </div>

                <div class="flex items-center gap-2 text-xs font-bold">
                    <span class="px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20" x-text="auditStats.passed + ' Passed'"></span>
                    <span class="px-2 py-0.5 rounded-md bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20" x-text="auditStats.warnings + ' Warnings'"></span>
                    <span class="px-2 py-0.5 rounded-md bg-rose-50 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20" x-text="auditStats.failed + ' Errors'"></span>
                </div>
            </div>

            <!-- Audits Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <template x-for="audit in filteredAudits(activeFilter)" :key="audit.id">
                    <div
                        class="p-3.5 rounded-xl border flex items-start gap-3 transition-colors"
                        :class="{
                            'bg-emerald-50/50 dark:bg-emerald-950/15 border-emerald-200 dark:border-emerald-800/40': audit.status === 'good',
                            'bg-amber-50/50 dark:bg-amber-950/15 border-amber-200 dark:border-amber-800/40': audit.status === 'warning',
                            'bg-rose-50/50 dark:bg-rose-950/15 border-rose-200 dark:border-rose-800/40': audit.status === 'error'
                        }"
                    >
                        <span
                            class="w-2.5 h-2.5 rounded-full mt-1.5 shrink-0"
                            :class="{
                                'bg-emerald-500 dark:bg-emerald-400 shadow-[0_0_6px_rgba(52,211,153,0.8)]': audit.status === 'good',
                                'bg-amber-500 dark:bg-amber-400 shadow-[0_0_6px_rgba(251,191,36,0.8)]': audit.status === 'warning',
                                'bg-rose-500 dark:bg-rose-400 shadow-[0_0_6px_rgba(251,113,133,0.8)]': audit.status === 'error'
                            }"
                        ></span>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-xs font-bold text-gray-900 dark:text-gray-100" x-text="audit.title"></p>
                                <span class="text-[10px] uppercase font-mono px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400" x-text="audit.category"></span>
                            </div>
                            <p class="text-[11px] text-gray-600 dark:text-gray-400 mt-0.5 leading-relaxed" x-text="audit.message"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function highLevelSeoEngine() {
            return {
                urlTemplate: @js($field->getLiveUrlTemplate()),
                serverState: @js($field->getEvaluationPayload()),

                seoScorePercent: 0,
                seoScoreRating: 'Evaluating...',
                seoScoreColorClass: 'text-amber-500',
                seoStrokeColorClass: 'text-amber-500',

                fleschScore: 0,
                readabilityRating: 'Calculating...',
                readabilityBadge: 'bg-amber-500',
                readabilityColorClass: 'text-amber-500',

                focusKeyword: '',
                keywordDensity: 0,
                keywordMatches: 0,
                keywordDensityColor: 'bg-amber-500',

                previewTitle: '',
                previewDescription: '',
                previewDomain: window.location.hostname || 'example.com',
                previewUrl: window.location.origin,
                slug: '',
                ogTitle: '',
                ogDesc: '',
                ogImage: '',

                metrics: { words: 0, readingTime: 0, headings: 0 },
                auditStats: { passed: 0, warnings: 0, failed: 0 },
                allAudits: [],

                initEngine() {
                    // 1. Immediately hydrate from exact backend PHP computation
                    if (this.serverState && Object.keys(this.serverState).length > 0) {
                        this.applyState(this.serverState);
                    }

                    // 2. Listen to live form updates only when editing
                    if (this.$wire && this.$wire.data && Object.keys(this.$wire.data).length > 0) {
                        this.$watch('$wire.data', () => this.runEngine(), { deep: true });
                        this.runEngine();
                    }
                },

                applyState(state) {
                    this.seoScorePercent = state.score || 0;
                    this.seoScoreRating = state.scoreRating || 'Evaluating...';
                    this.seoScoreColorClass = state.scoreColor || 'text-amber-500';
                    this.seoStrokeColorClass = state.strokeColor || 'text-amber-500';

                    this.fleschScore = state.fleschScore || 0;
                    this.readabilityRating = state.readabilityRating || 'Calculating...';
                    this.readabilityBadge = state.readabilityBadge || 'bg-amber-500';
                    this.readabilityColorClass = state.readabilityColor || 'text-amber-500';

                    this.focusKeyword = state.focusKeyword || '';
                    this.keywordDensity = state.keywordDensity || 0;
                    this.keywordMatches = state.keywordMatches || 0;
                    this.keywordDensityColor = state.keywordDensityColor || 'bg-amber-500';

                    this.previewTitle = state.title || 'Set an SEO Meta Title...';
                    this.previewDescription = state.description || 'Add a concise meta description...';
                    this.slug = state.slug || '';
                    this.ogTitle = state.ogTitle || this.previewTitle;
                    this.ogDesc = state.ogDesc || this.previewDescription;
                    this.ogImage = state.ogImage || '';

                    this.metrics.words = state.words || 0;
                    this.metrics.headings = state.headings || 0;
                    this.metrics.readingTime = state.readingTime || 0;

                    this.allAudits = state.audits || [];
                    this.auditStats = state.stats || { passed: 0, warnings: 0, failed: 0 };
                },

                getFullLiveUrl() {
                    const cleanSlug = (this.slug || '').trim();
                    if (!cleanSlug) {
                        return this.urlTemplate.replace('/__SLUG__', '').replace('__SLUG__', '');
                    }
                    return this.urlTemplate.replace('__SLUG__', cleanSlug);
                },

                filteredAudits(category) {
                    if (category === 'all') return this.allAudits;
                    return this.allAudits.filter(a => a.category === category);
                },

                calculateFlesch(text) {
                    const cleanText = text.replace(/[^a-zA-Z0-9.\s!?]/g, ' ').replace(/\s+/g, ' ').trim();
                    if (!cleanText) return 60;
                    const words = cleanText.split(/\s+/).filter(Boolean);
                    const sentences = cleanText.split(/[.!?]+/).filter(s => s.trim().length > 0);
                    if (words.length < 5 || sentences.length === 0) return 60;

                    let syllables = 0;
                    words.forEach(word => {
                        const clean = word.toLowerCase().replace(/(?:[^laeiouy]|ed|es|e)$/i, '').replace(/^y/i, '');
                        const matches = clean.match(/[aeiouy]{1,2}/g);
                        syllables += matches ? matches.length : 1;
                    });

                    const score = 206.835 - (1.015 * (words.length / sentences.length)) - (84.6 * (syllables / words.length));
                    return Math.max(0, Math.min(100, Math.round(score)));
                },

                runEngine() {
                    const wireData = this.$wire?.data;
                    const wireRecord = this.$wire?.record;
                    const fallback = this.initialRecord || {};

                    const data = (wireData && Object.keys(wireData).length > 0)
                        ? wireData
                        : ((wireRecord && Object.keys(wireRecord).length > 0) ? wireRecord : fallback);

                    const metaBlock = data.meta || fallback.meta || {};
                    const settingBlock = data.setting || fallback.setting || {};

                    const rawKeywords = metaBlock.seo_keywords || data.seo_keywords || fallback.seo_keywords || [];
                    this.focusKeyword = (Array.isArray(rawKeywords) ? (rawKeywords[0] || '') : String(rawKeywords).split(',')[0] || '').trim();

                    const title = (metaBlock.seo_title || data.seo_title || data.title || fallback.title || '').trim();
                    const metaDesc = (metaBlock.seo_description || data.seo_description || data.description || fallback.description || '').trim();
                    this.slug = (data.slug || settingBlock.slug || fallback.slug || '').trim();

                    this.ogTitle = metaBlock.og_title || title;
                    this.ogDesc = metaBlock.og_description || metaDesc;

                    // 1. Target ONLY the primary body content
                    let primaryContent = data.content ?? data.blocks ?? data.builder ?? data.body ?? fallback.content ?? fallback.blocks ?? fallback.body ?? '';

                    let extractedRaw = '';
                    let extractedText = '';
                    let headingsCount = 0;

                    const extract = (node) => {
                        if (!node) return;
                        if (typeof node === 'string') {
                            const trimmed = node.trim();
                            if ((trimmed.startsWith('{') && trimmed.endsWith('}')) || (trimmed.startsWith('[') && trimmed.endsWith(']'))) {
                                try {
                                    extract(JSON.parse(trimmed));
                                    return;
                                } catch (e) {}
                            }
                            extractedRaw += '\n' + node;
                            let formatted = node.replace(/<[^>]+>/g, ' ');
                            let clean = formatted.replace(/[#*_~`>\[\]]/g, ' ');
                            extractedText += ' ' + clean;
                            return;
                        }
                        if (Array.isArray(node)) {
                            node.forEach(item => extract(item));
                            return;
                        }
                        if (typeof node === 'object') {
                            if (node.type && ['heading', 'header', 'subheading'].includes(String(node.type).toLowerCase())) {
                                headingsCount++;
                            }
                            Object.entries(node).forEach(([key, val]) => {
                                if (['heading', 'header', 'title', 'subheading', 'headline'].includes(String(key).toLowerCase())) {
                                    headingsCount++;
                                }
                                // Ignore non-content structural/meta keys
                                if (!['type', 'icon', 'layout', 'style', 'styles', 'id', 'meta', 'seo_title', 'seo_description', 'seo_keywords', 'og_title', 'og_description', 'og_image', 'setting'].includes(key)) {
                                    extract(val);
                                }
                            });
                        }
                    };

                    extract(primaryContent);

                    const htmlHeadings = (extractedRaw.match(/<h[1-6][^>]*>/gi) || []).length;
                    headingsCount += htmlHeadings;
                    const mdHeadings = (extractedRaw.match(/^\s*#{1,6}\s+.+/gm) || []).length;
                    headingsCount += mdHeadings;

                    const cleanText = extractedText.replace(/\s+/g, ' ').trim();
                    const words = cleanText.split(/\s+/).filter(Boolean);
                    const totalWords = words.length;

                    // 2. Resolve Social Image
                    let rawImg = metaBlock.og_image || data.og_image || data.image || fallback.image || null;
                    if (typeof rawImg === 'object' && rawImg !== null) {
                        rawImg = Array.isArray(rawImg) ? rawImg[0] : Object.values(rawImg)[0];
                    }

                    this.ogImage = (typeof rawImg === 'string' && rawImg.trim().length > 0)
                        ? (rawImg.startsWith('http') || rawImg.startsWith('data:') ? rawImg : '/storage/' + rawImg.replace(/^\/+/, ''))
                        : '';

                    this.previewTitle = title || 'Set an SEO Meta Title...';
                    this.previewDescription = metaDesc || 'Add a concise meta description to preview how your page appears in search results.';

                    this.metrics.words = totalWords;
                    this.metrics.readingTime = Math.max(1, Math.ceil(totalWords / 200));
                    this.metrics.headings = headingsCount;

                    // 3. Keyword Density
                    if (this.focusKeyword && totalWords > 0) {
                        const escapedKw = this.focusKeyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        const matches = (cleanText.toLowerCase().match(new RegExp(escapedKw.toLowerCase(), 'g')) || []).length;
                        this.keywordMatches = matches;
                        this.keywordDensity = parseFloat(((matches / totalWords) * 100).toFixed(1));

                        this.keywordDensityColor = (this.keywordDensity >= 0.8 && this.keywordDensity <= 2.5)
                            ? 'bg-emerald-500'
                            : (this.keywordDensity > 2.5 ? 'bg-rose-500' : 'bg-amber-500');
                    } else {
                        this.keywordMatches = 0;
                        this.keywordDensity = 0;
                        this.keywordDensityColor = 'bg-gray-300 dark:bg-gray-700';
                    }

                    // 4. Readability Score
                    this.fleschScore = this.calculateFlesch(cleanText);
                    if (this.fleschScore >= 60) {
                        this.readabilityRating = 'Easy to Read';
                        this.readabilityBadge = 'bg-emerald-500';
                        this.readabilityColorClass = 'text-emerald-600 dark:text-emerald-400';
                    } else if (this.fleschScore >= 40) {
                        this.readabilityRating = 'Moderate Level';
                        this.readabilityBadge = 'bg-amber-500';
                        this.readabilityColorClass = 'text-amber-600 dark:text-amber-400';
                    } else {
                        this.readabilityRating = 'Hard to Read';
                        this.readabilityBadge = 'bg-rose-500';
                        this.readabilityColorClass = 'text-rose-600 dark:text-rose-400';
                    }

                    // 5. Audit Engine Evaluation
                    let audits = [];
                    let scorePoints = 0;

                    if (this.focusKeyword) {
                        audits.push({ id: 1, category: 'onpage', status: 'good', title: 'Focus Keyword Defined', message: `Primary keyword set to "${this.focusKeyword}".` });
                        scorePoints += 10;

                        if (title) {
                            if (title.toLowerCase().startsWith(this.focusKeyword.toLowerCase())) {
                                audits.push({ id: 2, category: 'onpage', status: 'good', title: 'Keyword at Start of Title', message: 'Target keyword is placed at the beginning of the title.' });
                                scorePoints += 15;
                            } else if (title.toLowerCase().includes(this.focusKeyword.toLowerCase())) {
                                audits.push({ id: 2, category: 'onpage', status: 'good', title: 'Keyword in Title', message: 'Target keyword is present in the meta title.' });
                                scorePoints += 10;
                            } else {
                                audits.push({ id: 2, category: 'onpage', status: 'error', title: 'Keyword Missing from Title', message: 'Include your target keyword in the SEO Title.' });
                            }
                        }

                        if (metaDesc && metaDesc.toLowerCase().includes(this.focusKeyword.toLowerCase())) {
                            audits.push({ id: 3, category: 'onpage', status: 'good', title: 'Keyword in Meta Description', message: 'Focus keyword appears in the snippet description.' });
                            scorePoints += 10;
                        } else {
                            audits.push({ id: 3, category: 'onpage', status: 'warning', title: 'Keyword Missing from Description', message: 'Include your focus keyword inside the meta description.' });
                        }

                        const cleanSlugKw = this.focusKeyword.toLowerCase().replace(/\s+/g, '-');
                        if (this.slug && this.slug.toLowerCase().includes(cleanSlugKw)) {
                            audits.push({ id: 4, category: 'onpage', status: 'good', title: 'Keyword in URL Slug', message: 'Target keyword is present in the page URL.' });
                            scorePoints += 10;
                        } else {
                            audits.push({ id: 4, category: 'onpage', status: 'warning', title: 'Keyword Missing from URL', message: 'Include your keyword in the page URL slug.' });
                        }

                        const introWords = words.slice(0, 100).join(' ').toLowerCase();
                        if (introWords.includes(this.focusKeyword.toLowerCase())) {
                            audits.push({ id: 5, category: 'content', status: 'good', title: 'Keyword in Introduction', message: 'Keyword appears in the opening paragraph.' });
                            scorePoints += 10;
                        } else {
                            audits.push({ id: 5, category: 'content', status: 'warning', title: 'Keyword Missing from Intro', message: 'Place your keyword in the first paragraph.' });
                        }
                    } else {
                        audits.push({ id: 1, category: 'onpage', status: 'error', title: 'Missing Focus Keyword', message: 'Set a focus keyword to evaluate search optimization.' });
                    }

                    const titleLen = title.length;
                    if (titleLen >= 40 && titleLen <= 60) {
                        audits.push({ id: 6, category: 'onpage', status: 'good', title: 'Optimal Title Length', message: `Title is ${titleLen} characters (Ideal: 40-60).` });
                        scorePoints += 10;
                    } else if (titleLen > 0) {
                        audits.push({ id: 6, category: 'onpage', status: 'warning', title: 'Title Length Suboptimal', message: `Title is ${titleLen} characters. Aim for 40-60 characters.` });
                        scorePoints += 5;
                    } else {
                        audits.push({ id: 6, category: 'onpage', status: 'error', title: 'Missing Title', message: 'Add an SEO Title.' });
                    }

                    const descLen = metaDesc.length;
                    if (descLen >= 120 && descLen <= 160) {
                        audits.push({ id: 7, category: 'onpage', status: 'good', title: 'Optimal Description', message: `Description is ${descLen} characters (Ideal: 120-160).` });
                        scorePoints += 10;
                    } else if (descLen > 0) {
                        audits.push({ id: 7, category: 'onpage', status: 'warning', title: 'Description Length Suboptimal', message: `Description is ${descLen} characters. Target 120-160 characters.` });
                        scorePoints += 5;
                    } else {
                        audits.push({ id: 7, category: 'onpage', status: 'error', title: 'Missing Meta Description', message: 'Add a meta description.' });
                    }

                    if (totalWords >= 300) {
                        audits.push({ id: 8, category: 'content', status: 'good', title: 'Rich Content Depth', message: `Found ${totalWords} words.` });
                        scorePoints += 10;
                    } else if (totalWords >= 150) {
                        audits.push({ id: 8, category: 'content', status: 'good', title: 'Adequate Word Count', message: `Found ${totalWords} words.` });
                        scorePoints += 5;
                    } else {
                        audits.push({ id: 8, category: 'content', status: 'warning', title: 'Short Content', message: `Found ${totalWords} words. Aim for 300+ words.` });
                    }

                    if (this.metrics.headings >= 1) {
                        audits.push({ id: 9, category: 'content', status: 'good', title: 'Structured Headings', message: `Found ${this.metrics.headings} headings organizing the content.` });
                        scorePoints += 5;
                    } else {
                        audits.push({ id: 9, category: 'content', status: 'warning', title: 'Add Subheadings', message: 'Use headings to break up sections.' });
                    }

                    const schemaType = metaBlock.schema_type || data.schema_type;
                    if (schemaType) {
                        audits.push({ id: 10, category: 'technical', status: 'good', title: `Schema Preset: "${schemaType}"`, message: 'Structured data rich snippet is configured.' });
                        scorePoints += 5;
                    }

                    if (this.ogImage) {
                        audits.push({ id: 11, category: 'technical', status: 'good', title: 'Social Share Graphic', message: 'OpenGraph banner is uploaded.' });
                        scorePoints += 5;
                    }

                    this.allAudits = audits;
                    this.auditStats.passed = audits.filter(a => a.status === 'good').length;
                    this.auditStats.warnings = audits.filter(a => a.status === 'warning').length;
                    this.auditStats.failed = audits.filter(a => a.status === 'error').length;

                    this.seoScorePercent = Math.min(100, Math.max(0, scorePoints));

                    if (this.seoScorePercent >= 80) {
                        this.seoScoreRating = 'Rank-Ready';
                        this.seoScoreColorClass = 'text-emerald-600 dark:text-emerald-400';
                        this.seoStrokeColorClass = 'text-emerald-500';
                    } else if (this.seoScorePercent >= 50) {
                        this.seoScoreRating = 'Needs Optimization';
                        this.seoScoreColorClass = 'text-amber-600 dark:text-amber-400';
                        this.seoStrokeColorClass = 'text-amber-500';
                    } else {
                        this.seoScoreRating = 'Action Required';
                        this.seoScoreColorClass = 'text-rose-600 dark:text-rose-400';
                        this.seoStrokeColorClass = 'text-rose-500';
                    }
                }
            }
        }
    </script>
</x-dynamic-component>
