<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="seoAnalyzer()"
        x-init="initEngine()"
        class="space-y-6 p-6 bg-slate-900 border border-slate-800 rounded-2xl text-white shadow-lg"
    >
        {{-- High-Level Score Dashboard --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 bg-slate-800/50 rounded-xl border border-slate-700/50 flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">SEO Score</span>
                    <h4 class="text-xl font-bold mt-1" x-text="seoScoreText">Calculating...</h4>
                </div>
                <div class="w-4 h-4 rounded-full transition-colors duration-300" :class="seoBadgeColor"></div>
            </div>

            <div class="p-4 bg-slate-800/50 rounded-xl border border-slate-700/50 flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Readability Index</span>
                    <h4 class="text-xl font-bold mt-1" x-text="readabilityScoreText">Calculating...</h4>
                </div>
                <div class="w-4 h-4 rounded-full transition-colors duration-300" :class="readabilityBadgeColor"></div>
            </div>
        </div>

        {{-- Live Audit Checklist --}}
        <div class="space-y-3">
            <h5 class="text-sm font-semibold text-slate-300">Real-Time Audit Results</h5>
            <ul class="space-y-2 text-sm">
                <template x-for="result in analysisResults" :key="result.id">
                    <li class="flex items-start gap-3 p-3 bg-slate-800/30 rounded-lg border border-slate-800">
                        <span class="w-3 h-3 rounded-full mt-1 shrink-0 transition-colors duration-300" :class="result.color"></span>
                        <div>
                            <p class="font-medium text-slate-200" x-text="result.title"></p>
                            <p class="text-xs text-slate-400 mt-0.5" x-text="result.description"></p>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    <script>
        function seoAnalyzer() {
            return {
                seoScoreText: 'Calculating...',
                readabilityScoreText: 'Calculating...',
                seoBadgeColor: 'bg-amber-500',
                readabilityBadgeColor: 'bg-amber-500',
                analysisResults: [],

                initEngine() {
                    this.$watch('$wire.data', () => this.runAnalysis(), { deep: true });
                    this.runAnalysis();
                },

                extractContentText(node) {
                    if (!node) return '';
                    if (typeof node === 'string') return node.replace(/<[^>]*>?/gm, ' ');
                    if (typeof node === 'number') return node.toString();
                    if (Array.isArray(node)) {
                        return node.map(item => this.extractContentText(item)).join(' ');
                    }
                    if (typeof node === 'object') {
                        return Object.entries(node)
                            .filter(([key]) => !['type', 'icon', 'layout', 'style', 'id'].includes(key))
                            .map(([_, val]) => this.extractContentText(val))
                            .join(' ');
                    }
                    return '';
                },

                calculateFleschScore(text) {
                    const words = text.trim().split(/\s+/).filter(Boolean);
                    const sentences = text.split(/[.!?]+/).filter(Boolean);
                    if (!words.length || !sentences.length) return 0;

                    let syllables = 0;
                    words.forEach(word => {
                        const cleanWord = word.toLowerCase().replace(/(?:[^laeiouy]|ed|es|e)$/i, '').replace(/^y/i, '');
                        const matches = cleanWord.match(/[aeiouy]{1,2}/g);
                        syllables += matches ? matches.length : 1;
                    });

                    return Math.round(206.835 - (1.015 * (words.length / sentences.length)) - (84.6 * (syllables / words.length)));
                },

                runAnalysis() {
                    const data = this.$wire.data || {};
                    const keyword = (data.seo_keywords?.[0] || '').trim();
                    const title = data.seo_title || data.title || '';
                    const metaDesc = data.seo_description || '';
                    const slug = data.slug || '';

                    const contentSource = data.content || data.blocks || data.builder || [];
                    const cleanText = this.extractContentText(contentSource).replace(/\s+/g, ' ').trim();
                    const wordList = cleanText.split(/\s+/).filter(Boolean);
                    const totalWords = wordList.length;

                    let tests = [];

                    // Readability Analysis
                    const fleschScore = Math.max(0, Math.min(100, this.calculateFleschScore(cleanText)));
                    if (fleschScore >= 60) {
                        this.readabilityScoreText = `Good (${fleschScore}/100)`;
                        this.readabilityBadgeColor = 'bg-emerald-500';
                    } else if (fleschScore >= 40) {
                        this.readabilityScoreText = `Fair (${fleschScore}/100)`;
                        this.readabilityBadgeColor = 'bg-amber-500';
                    } else {
                        this.readabilityScoreText = `Needs Work (${fleschScore}/100)`;
                        this.readabilityBadgeColor = 'bg-rose-500';
                    }

                    // Keyword in Title
                    if (keyword) {
                        const titleLower = title.toLowerCase();
                        const kwLower = keyword.toLowerCase();
                        if (titleLower.includes(kwLower)) {
                            tests.push({ id: 'kw_title', color: 'bg-emerald-500', title: 'Focus Keyword in Title', description: 'Target keyword exists in the page meta title.' });
                        } else {
                            tests.push({ id: 'kw_title', color: 'bg-rose-500', title: 'Keyword Missing from Title', description: 'Add primary focus keyword to your meta title.' });
                        }
                    }

                    // Keyword Density
                    if (keyword && totalWords > 0) {
                        const escapedKw = keyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        const matches = (cleanText.toLowerCase().match(new RegExp(escapedKw.toLowerCase(), 'g')) || []).length;
                        const density = ((matches / totalWords) * 100).toFixed(1);

                        if (density >= 0.5 && density <= 2.5) {
                            tests.push({ id: 'kw_density', color: 'bg-emerald-500', title: 'Keyword Density', description: `Optimal density at ${density}% (${matches} occurrences).` });
                        } else if (density > 2.5) {
                            tests.push({ id: 'kw_density', color: 'bg-amber-500', title: 'Keyword Stuffing Warning', description: `High density (${density}%). Reduce keyword instances.` });
                        } else {
                            tests.push({ id: 'kw_density', color: 'bg-rose-500', title: 'Low Keyword Density', description: `Density is ${density}%. Use keyword more within content.` });
                        }
                    }

                    // Keyword in Slug
                    if (keyword && slug) {
                        const slugClean = slug.replace(/-/g, ' ').toLowerCase();
                        if (slugClean.includes(keyword.toLowerCase())) {
                            tests.push({ id: 'kw_slug', color: 'bg-emerald-500', title: 'Keyword in URL Slug', description: 'Focus keyword exists in the page URL.' });
                        } else {
                            tests.push({ id: 'kw_slug', color: 'bg-amber-500', title: 'Keyword Missing from Slug', description: 'Add your primary keyword to the URL slug.' });
                        }
                    }

                    // Meta Description Length
                    if (metaDesc.length >= 120 && metaDesc.length <= 160) {
                        tests.push({ id: 'meta_len', color: 'bg-emerald-500', title: 'Meta Description Length', description: `Optimal length (${metaDesc.length}/160 chars).` });
                    } else {
                        tests.push({ id: 'meta_len', color: 'bg-amber-500', title: 'Meta Description Length', description: `Currently ${metaDesc.length} chars (Target: 120-160).` });
                    }

                    // Word Count / Depth
                    if (totalWords >= 600) {
                        tests.push({ id: 'word_count', color: 'bg-emerald-500', title: 'Content Depth', description: `Sufficient content length (${totalWords} words).` });
                    } else {
                        tests.push({ id: 'word_count', color: 'bg-rose-500', title: 'Thin Content', description: `Only ${totalWords} words. Aim for at least 600 words.` });
                    }

                    this.analysisResults = tests;
                    const passed = tests.filter(t => t.color === 'bg-emerald-500').length;
                    const total = tests.length;
                    const percentage = total > 0 ? (passed / total) * 100 : 0;

                    if (percentage >= 75) {
                        this.seoScoreText = `Good (${passed}/${total})`;
                        this.seoBadgeColor = 'bg-emerald-500';
                    } else if (percentage >= 50) {
                        this.seoScoreText = `Needs Improvement (${passed}/${total})`;
                        this.seoBadgeColor = 'bg-amber-500';
                    } else {
                        this.seoScoreText = `Poor (${passed}/${total})`;
                        this.seoBadgeColor = 'bg-rose-500';
                    }
                }
            }
        }
    </script>
</x-dynamic-component>
