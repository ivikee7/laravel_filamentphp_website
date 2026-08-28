<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="advancedSeoAnalyzer()"
        x-init="initEngine()"
        class="space-y-6 p-6 bg-slate-900 border border-slate-800 rounded-2xl text-slate-100 shadow-xl font-sans"
    >
        {{-- High-Level Progress Dashboard --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Overall SEO Score -->
            <div class="p-4 bg-slate-800/60 rounded-xl border border-slate-700/60 flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">SEO Optimization</span>
                    <h4 class="text-2xl font-black mt-1" :class="seoScoreColorClass" x-text="seoScorePercent + '/100'">0/100</h4>
                    <span class="text-xs font-medium text-slate-400" x-text="seoScoreRating">Evaluating...</span>
                </div>
                <div class="relative flex items-center justify-center">
                    <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                        <path class="text-slate-700" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <path :class="seoStrokeColorClass" stroke-dasharray="100, 100" :stroke-dashoffset="100 - seoScorePercent" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                </div>
            </div>

            <!-- Readability Score -->
            <div class="p-4 bg-slate-800/60 rounded-xl border border-slate-700/60 flex items-center justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Readability Index</span>
                    <h4 class="text-2xl font-black mt-1" :class="readabilityColorClass" x-text="fleschScore + '/100'">0/100</h4>
                    <span class="text-xs font-medium text-slate-400" x-text="readabilityRating">Evaluating...</span>
                </div>
                <div class="w-4 h-4 rounded-full" :class="readabilityBadge"></div>
            </div>

            <!-- Content Stats -->
            <div class="p-4 bg-slate-800/60 rounded-xl border border-slate-700/60 flex flex-col justify-center">
                <span class="text-xs uppercase tracking-wider text-slate-400 font-semibold">Page Metrics</span>
                <div class="flex items-center gap-4 mt-2">
                    <div>
                        <span class="text-lg font-bold text-white" x-text="metrics.words">0</span>
                        <p class="text-[11px] text-slate-400">Words</p>
                    </div>
                    <div class="h-6 w-px bg-slate-700"></div>
                    <div>
                        <span class="text-lg font-bold text-white" x-text="metrics.readingTime + 'm'">0m</span>
                        <p class="text-[11px] text-slate-400">Reading Time</p>
                    </div>
                    <div class="h-6 w-px bg-slate-700"></div>
                    <div>
                        <span class="text-lg font-bold text-white" x-text="metrics.headings">0</span>
                        <p class="text-[11px] text-slate-400">Headings</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Google SERP Live Search Engine Preview --}}
        <div class="p-4 bg-slate-800/40 rounded-xl border border-slate-700/50 space-y-2">
            <div class="flex items-center justify-between">
                <h5 class="text-xs uppercase font-bold tracking-wider text-slate-400 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                    Google SERP Preview (Desktop)
                </h5>
                <span class="text-[11px] text-slate-500 font-mono" x-text="previewUrl"></span>
            </div>
            <div class="p-4 bg-[#202124] rounded-lg border border-slate-700/80 font-sans">
                <div class="text-xs text-[#bdc1c6] truncate flex items-center gap-1.5">
                    <span class="w-4 h-4 rounded-full bg-slate-700 flex items-center justify-center text-[9px] text-slate-300">G</span>
                    <span class="truncate" x-text="previewDomain + ' › ' + (slug || 'your-page-slug')"></span>
                </div>
                <h3 class="text-lg text-[#8ab4f8] font-medium leading-snug cursor-pointer hover:underline truncate mt-1" x-text="previewTitle"></h3>
                <p class="text-xs text-[#bdc1c6] mt-1 line-clamp-2 leading-relaxed" x-text="previewDescription"></p>
            </div>
        </div>

        {{-- Tabbed Live Audit Categories --}}
        <div class="space-y-3">
            <div class="flex items-center justify-between border-b border-slate-800 pb-2">
                <h5 class="text-sm font-bold text-slate-200">Comprehensive SEO & Readability Audits</h5>
                <div class="flex gap-2 text-xs font-semibold">
                    <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400" x-text="auditStats.passed + ' Passed'"></span>
                    <span class="px-2 py-0.5 rounded bg-amber-500/20 text-amber-400" x-text="auditStats.warnings + ' Warnings'"></span>
                    <span class="px-2 py-0.5 rounded bg-rose-500/20 text-rose-400" x-text="auditStats.failed + ' Errors'"></span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <template x-for="audit in allAudits" :key="audit.id">
                    <div class="p-3.5 rounded-xl border flex items-start gap-3 transition-colors"
                         :class="{
                            'bg-emerald-950/20 border-emerald-800/40': audit.status === 'good',
                            'bg-amber-950/20 border-amber-800/40': audit.status === 'warning',
                            'bg-rose-950/20 border-rose-800/40': audit.status === 'error'
                         }">
                        <span class="w-2.5 h-2.5 rounded-full mt-1.5 shrink-0"
                              :class="{
                                'bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.6)]': audit.status === 'good',
                                'bg-amber-400 shadow-[0_0_8px_rgba(251,191,36,0.6)]': audit.status === 'warning',
                                'bg-rose-400 shadow-[0_0_8px_rgba(251,113,133,0.6)]': audit.status === 'error'
                              }"></span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-200" x-text="audit.title"></p>
                            <p class="text-[11px] text-slate-400 mt-0.5 leading-relaxed" x-text="audit.message"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function advancedSeoAnalyzer() {
            return {
                seoScorePercent: 0,
                seoScoreRating: 'Calculating...',
                seoScoreColorClass: 'text-amber-400',
                seoStrokeColorClass: 'text-amber-400',

                fleschScore: 0,
                readabilityRating: 'Calculating...',
                readabilityBadge: 'bg-amber-500',
                readabilityColorClass: 'text-amber-400',

                previewTitle: '',
                previewDescription: '',
                previewDomain: window.location.hostname || 'example.com',
                previewUrl: window.location.origin,
                slug: '',

                metrics: {
                    words: 0,
                    readingTime: 0,
                    headings: 0,
                    images: 0,
                    imagesWithoutAlt: 0,
                    linksInternal: 0,
                    linksExternal: 0
                },

                auditStats: { passed: 0, warnings: 0, failed: 0 },
                allAudits: [],

                initEngine() {
                    this.$watch('$wire.data', () => this.runEngine(), { deep: true });
                    this.runEngine();
                },

                // Traverse JSON content blocks and collect raw HTML / text
                extractContentPayload(node, accumulator = { html: '', text: '' }) {
                    if (!node) return accumulator;

                    if (typeof node === 'string') {
                        accumulator.html += ' ' + node;
                        accumulator.text += ' ' + node.replace(/<[^>]*>?/gm, ' ');
                        return accumulator;
                    }
                    if (Array.isArray(node)) {
                        node.forEach(item => this.extractContentPayload(item, accumulator));
                        return accumulator;
                    }
                    if (typeof node === 'object') {
                        Object.entries(node).forEach(([key, val]) => {
                            if (!['type', 'icon', 'layout', 'style', 'id'].includes(key)) {
                                this.extractContentPayload(val, accumulator);
                            }
                        });
                    }
                    return accumulator;
                },

                // Improved Flesch Reading Ease algorithm
                calculateFlesch(text) {
                    const cleanText = text.replace(/[^a-zA-Z0-9.\s!?]/g, ' ').replace(/\s+/g, ' ').trim();
                    if (!cleanText) return 0;

                    const words = cleanText.split(/\s+/).filter(w => w.length > 0);
                    const sentences = cleanText.split(/[.!?]+/).filter(s => s.trim().length > 0);

                    if (words.length < 5 || sentences.length === 0) return 60; // Neutral default for short text

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
                    const data = this.$wire.data || {};

                    // 1. Omnichannel field resolution (works at root or inside 'seo' / 'setting' blocks)
                    const seoBlock = data.seo || {};
                    const settingBlock = data.setting || {};

                    const rawKeywords = seoBlock.seo_keywords || data.seo_keywords || [];
                    const focusKeyword = (Array.isArray(rawKeywords) ? (rawKeywords[0] || '') : String(rawKeywords).split(',')[0] || '').trim();

                    const title = seoBlock.seo_title || data.seo_title || data.title || '';
                    const metaDesc = seoBlock.seo_description || data.seo_description || '';
                    this.slug = data.slug || settingBlock.slug || '';

                    // 2. Extract DOM & Content
                    const contentPayload = this.extractContentPayload(data.content || data.blocks || data.builder || []);
                    const rawHtml = contentPayload.html;
                    const cleanText = contentPayload.text.replace(/\s+/g, ' ').trim();
                    const words = cleanText.split(/\s+/).filter(Boolean);
                    const totalWords = words.length;

                    // 3. Populate Live SERP
                    this.previewTitle = title || 'Please set a Page Title...';
                    this.previewDescription = metaDesc || 'Please provide a meta description to preview how your snippet appears in search engine results.';

                    // 4. Calculate Structural Metrics
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = rawHtml;

                    const headings = tempDiv.querySelectorAll('h1, h2, h3, h4, h5, h6');
                    const images = tempDiv.querySelectorAll('img');
                    let imagesWithoutAlt = 0;
                    images.forEach(img => { if (!img.getAttribute('alt')) imagesWithoutAlt++; });

                    const links = tempDiv.querySelectorAll('a');
                    let internalLinks = 0;
                    let externalLinks = 0;
                    links.forEach(link => {
                        const href = link.getAttribute('href') || '';
                        if (href.startsWith('http') && !href.includes(this.previewDomain)) {
                            externalLinks++;
                        } else if (href.length > 0 && !href.startsWith('#')) {
                            internalLinks++;
                        }
                    });

                    this.metrics.words = totalWords;
                    this.metrics.readingTime = Math.max(1, Math.ceil(totalWords / 200));
                    this.metrics.headings = headings.length;
                    this.metrics.images = images.length;
                    this.metrics.imagesWithoutAlt = imagesWithoutAlt;
                    this.metrics.linksInternal = internalLinks;
                    this.metrics.linksExternal = externalLinks;

                    // 5. Readability Analysis
                    this.fleschScore = this.calculateFlesch(cleanText);
                    if (this.fleschScore >= 60) {
                        this.readabilityRating = 'Easy to read (Good)';
                        this.readabilityBadge = 'bg-emerald-500 shadow-[0_0_8px_rgba(52,211,153,0.6)]';
                        this.readabilityColorClass = 'text-emerald-400';
                    } else if (this.fleschScore >= 40) {
                        this.readabilityRating = 'Moderate reading level';
                        this.readabilityBadge = 'bg-amber-500 shadow-[0_0_8px_rgba(251,191,36,0.6)]';
                        this.readabilityColorClass = 'text-amber-400';
                    } else {
                        this.readabilityRating = 'Complex phrasing (Hard)';
                        this.readabilityBadge = 'bg-rose-500 shadow-[0_0_8px_rgba(251,113,133,0.6)]';
                        this.readabilityColorClass = 'text-rose-400';
                    }

                    // 6. Comprehensive 12-Point Live Audits
                    let audits = [];
                    let scorePoints = 0;
                    const maxPoints = 100;

                    // Audit 1: Focus Keyword Defined
                    if (focusKeyword) {
                        audits.push({ id: 1, status: 'good', title: `Focus Keyword: "${focusKeyword}"`, message: 'Primary target keyword is set.' });
                        scorePoints += 10;
                    } else {
                        audits.push({ id: 1, status: 'error', title: 'Missing Focus Keyword', message: 'Add a target keyword to unlock keyword density and placement audits.' });
                    }

                    // Audit 2: Keyword in Meta Title
                    if (focusKeyword) {
                        const kwLower = focusKeyword.toLowerCase();
                        const titleLower = title.toLowerCase();
                        if (titleLower.includes(kwLower)) {
                            if (titleLower.startsWith(kwLower)) {
                                audits.push({ id: 2, status: 'good', title: 'Keyword at Start of Title', message: 'Target keyword appears at the beginning of the title.' });
                                scorePoints += 10;
                            } else {
                                audits.push({ id: 2, status: 'good', title: 'Keyword in Title', message: 'Target keyword is present in the meta title.' });
                                scorePoints += 8;
                            }
                        } else {
                            audits.push({ id: 2, status: 'error', title: 'Keyword Missing from Title', message: 'Include your focus keyword inside the meta title.' });
                        }
                    }

                    // Audit 3: Title Length Optimization
                    const titleLen = title.length;
                    if (titleLen >= 40 && titleLen <= 60) {
                        audits.push({ id: 3, status: 'good', title: 'Optimal Title Length', message: `Title is ${titleLen} chars (Ideal: 40-60 chars).` });
                        scorePoints += 10;
                    } else if (titleLen > 60) {
                        audits.push({ id: 3, status: 'warning', title: 'Title is Too Long', message: `Title is ${titleLen} chars. It may be truncated in Google search results.` });
                        scorePoints += 4;
                    } else {
                        audits.push({ id: 3, status: 'error', title: 'Title is Too Short', message: `Title is ${titleLen} chars. Aim for 40-60 characters for maximum CTR.` });
                    }

                    // Audit 4: Meta Description Length
                    const descLen = metaDesc.length;
                    if (descLen >= 120 && descLen <= 160) {
                        audits.push({ id: 4, status: 'good', title: 'Optimal Meta Description', message: `Description is ${descLen} chars (Ideal: 120-160 chars).` });
                        scorePoints += 10;
                    } else if (descLen > 160) {
                        audits.push({ id: 4, status: 'warning', title: 'Meta Description Too Long', message: `Description is ${descLen} chars. Google will truncate snippets over 160 chars.` });
                        scorePoints += 4;
                    } else if (descLen > 0) {
                        audits.push({ id: 4, status: 'warning', title: 'Meta Description Too Short', message: `Description is ${descLen} chars. Add more context (target 120-160).` });
                        scorePoints += 3;
                    } else {
                        audits.push({ id: 4, status: 'error', title: 'Missing Meta Description', message: 'Write a compelling meta description to improve organic click-through rates.' });
                    }

                    // Audit 5: Keyword in Meta Description
                    if (focusKeyword && metaDesc) {
                        if (metaDesc.toLowerCase().includes(focusKeyword.toLowerCase())) {
                            audits.push({ id: 5, status: 'good', title: 'Keyword in Meta Description', message: 'Focus keyword appears in the snippet description.' });
                            scorePoints += 10;
                        } else {
                            audits.push({ id: 5, status: 'warning', title: 'Keyword Missing from Description', message: 'Include your focus keyword inside the meta description for bold search highlighting.' });
                        }
                    }

                    // Audit 6: Keyword in URL Slug
                    if (focusKeyword && this.slug) {
                        const cleanSlug = this.slug.replace(/[-_]/g, ' ').toLowerCase();
                        if (cleanSlug.includes(focusKeyword.toLowerCase())) {
                            audits.push({ id: 6, status: 'good', title: 'Keyword in URL Slug', message: 'Target keyword is included in the URL slug.' });
                            scorePoints += 10;
                        } else {
                            audits.push({ id: 6, status: 'warning', title: 'Keyword Missing from URL', message: 'Add your primary keyword to the page URL slug.' });
                        }
                    }

                    // Audit 7: Content Length & Depth
                    if (totalWords >= 600) {
                        audits.push({ id: 7, status: 'good', title: 'Content Depth', message: `Good length (${totalWords} words). Matches standard search intent guidelines.` });
                        scorePoints += 15;
                    } else if (totalWords >= 300) {
                        audits.push({ id: 7, status: 'warning', title: 'Acceptable Content Length', message: `Found ${totalWords} words. Expanding past 600 words improves ranking probability.` });
                        scorePoints += 8;
                    } else {
                        audits.push({ id: 7, status: 'error', title: 'Thin Content', message: `Only ${totalWords} words found. Search engines favor rich, comprehensive resources.` });
                    }

                    // Audit 8: Keyword Density
                    if (focusKeyword && totalWords > 0) {
                        const escapedKw = focusKeyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                        const matches = (cleanText.toLowerCase().match(new RegExp(escapedKw.toLowerCase(), 'g')) || []).length;
                        const density = ((matches / totalWords) * 100).toFixed(1);

                        if (density >= 0.8 && density <= 2.5) {
                            audits.push({ id: 8, status: 'good', title: `Keyword Density (${density}%)`, message: `Optimal keyword usage (${matches} occurrences).` });
                            scorePoints += 10;
                        } else if (density > 2.5) {
                            audits.push({ id: 8, status: 'error', title: `Keyword Stuffing (${density}%)`, message: 'Keyword occurs too frequently. Reduce usage to avoid algorithmic penalties.' });
                        } else {
                            audits.push({ id: 8, status: 'warning', title: `Low Keyword Density (${density}%)`, message: `Found ${matches} occurrences. Try naturally including your keyword across subheadings and body.` });
                            scorePoints += 4;
                        }
                    }

                    // Audit 9: Keyword in First 10% / Intro
                    if (focusKeyword && totalWords > 20) {
                        const first100Words = words.slice(0, 100).join(' ').toLowerCase();
                        if (first100Words.includes(focusKeyword.toLowerCase())) {
                            audits.push({ id: 9, status: 'good', title: 'Keyword in Introduction', message: 'Focus keyword appears within the first paragraph/100 words.' });
                            scorePoints += 10;
                        } else {
                            audits.push({ id: 9, status: 'warning', title: 'Keyword Missing from Intro', message: 'Include your focus keyword in the introductory paragraph.' });
                        }
                    }

                    // Audit 10: Headings Structure (H2 / H3)
                    if (headings.length >= 2) {
                        audits.push({ id: 10, status: 'good', title: 'Content Hierarchy', message: `Page utilizes ${headings.length} subheadings for clean visual structure.` });
                        scorePoints += 5;
                    } else {
                        audits.push({ id: 10, status: 'warning', title: 'Missing Subheadings', message: 'Add H2 and H3 subheadings to break up long blocks of text.' });
                    }

                    // Audit 11: Link Architecture (Internal / External)
                    if (internalLinks > 0 || externalLinks > 0) {
                        audits.push({ id: 11, status: 'good', title: 'Link Architecture', message: `Found ${internalLinks} internal and ${externalLinks} external references.` });
                        scorePoints += 5;
                    } else {
                        audits.push({ id: 11, status: 'warning', title: 'No Outbound/Internal Links', message: 'Add contextual links to related resources or pages.' });
                    }

                    // Audit 12: Image Alt Tags
                    if (images.length > 0) {
                        if (imagesWithoutAlt === 0) {
                            audits.push({ id: 12, status: 'good', title: 'Image Accessibility (ALT)', message: `All ${images.length} images include descriptive ALT text.` });
                            scorePoints += 5;
                        } else {
                            audits.push({ id: 12, status: 'warning', title: 'Missing Image ALT Tags', message: `${imagesWithoutAlt} out of ${images.length} images are missing ALT attributes.` });
                        }
                    }

                    // 7. Compute Totals & Color Schemes
                    this.allAudits = audits;
                    this.auditStats.passed = audits.filter(a => a.status === 'good').length;
                    this.auditStats.warnings = audits.filter(a => a.status === 'warning').length;
                    this.auditStats.failed = audits.filter(a => a.status === 'error').length;

                    this.seoScorePercent = Math.min(100, Math.max(0, scorePoints));

                    if (this.seoScorePercent >= 80) {
                        this.seoScoreRating = 'Rank-Ready (Great)';
                        this.seoScoreColorClass = 'text-emerald-400';
                        this.seoStrokeColorClass = 'text-emerald-400';
                    } else if (this.seoScorePercent >= 50) {
                        this.seoScoreRating = 'Fair (Needs Optimization)';
                        this.seoScoreColorClass = 'text-amber-400';
                        this.seoStrokeColorClass = 'text-amber-400';
                    } else {
                        this.seoScoreRating = 'Poor (Action Required)';
                        this.seoScoreColorClass = 'text-rose-400';
                        this.seoStrokeColorClass = 'text-rose-400';
                    }
                }
            }
        }
    </script>
</x-dynamic-component>
