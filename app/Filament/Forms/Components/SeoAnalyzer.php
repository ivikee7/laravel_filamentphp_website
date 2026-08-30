<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Route;

class SeoAnalyzer extends Field
{
    protected string $view = 'filament.forms.components.seo-analyzer';

    protected ?string $routeName = 'content.show';

    public static function make(?string $name = null): static
    {
        return parent::make($name ?? 'seo_live_analysis');
    }

    public function routeName(string $name): static
    {
        $this->routeName = $name;
        return $this;
    }

    public function getLiveUrlTemplate(): string
    {
        if (Route::has($this->routeName)) {
            return route($this->routeName, ['slug' => '__SLUG__']);
        }

        return url('/contents/__SLUG__');
    }

    public function getEvaluationPayload(): array
    {
        $record = $this->getRecord();

        $getter = function ($key) use ($record) {
            if (! $record) {
                return null;
            }

            $cleanKey = ltrim($key, './');
            $data = $record->toArray();

            if (str_contains($cleanKey, '.')) {
                return data_get($data, $cleanKey);
            }

            return $data[$cleanKey] ?? null;
        };

        return static::analyze($getter);
    }

    public static function calculateSeoScore(callable $get): int
    {
        return static::analyze($get)['score'];
    }

    public static function analyze(callable $get): array
    {
        $meta = $get('meta') ?? [];
        if (is_string($meta)) {
            $meta = json_decode($meta, true) ?? [];
        }

        $title = trim((string) ($get('seo_title') ?? $get('meta.seo_title') ?? ($meta['seo_title'] ?? null) ?? $get('title') ?? $get('../title') ?? ''));
        $desc = trim((string) ($get('seo_description') ?? $get('meta.seo_description') ?? ($meta['seo_description'] ?? null) ?? $get('description') ?? ''));
        $slug = trim((string) ($get('slug') ?? $get('setting.slug') ?? $get('../slug') ?? ''));

        $keywords = $get('seo_keywords') ?? $get('meta.seo_keywords') ?? ($meta['seo_keywords'] ?? []);
        $focusKeyword = is_array($keywords)
            ? trim((string) ($keywords[0] ?? ''))
            : trim((string) (explode(',', (string) $keywords)[0] ?? ''));

        // Pick ONLY the primary non-empty content field to prevent duplication
        $rawContent = null;
        $contentCandidates = [
            $get('content'),
            $get('../content'),
            $get('blocks'),
            $get('../blocks'),
            $get('builder'),
            $get('../builder'),
            $get('body'),
            $get('../body'),
        ];

        foreach ($contentCandidates as $candidate) {
            if (!empty($candidate)) {
                $rawContent = $candidate;
                break;
            }
        }

        $extractedRaw = '';
        $extractedText = '';
        $headingsCount = 0;

        $extract = function ($node) use (&$extract, &$extractedRaw, &$extractedText, &$headingsCount) {
            if (empty($node)) return;

            if (is_string($node)) {
                $trimmed = trim($node);
                if ((str_starts_with($trimmed, '{') && str_ends_with($trimmed, '}')) || (str_starts_with($trimmed, '[') && str_ends_with($trimmed, ']'))) {
                    $json = json_decode($trimmed, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $extract($json);
                        return;
                    }
                }

                $extractedRaw .= "\n" . $node;
                $formatted = preg_replace('/<[^>]+>/', ' ', $node);
                $clean = preg_replace('/[#*_~`>\[\]]/', ' ', $formatted);
                $extractedText .= ' ' . $clean;
                return;
            }

            if (is_array($node)) {
                if (isset($node['type']) && in_array(strtolower((string) $node['type']), ['heading', 'header', 'subheading'], true)) {
                    $headingsCount++;
                }

                foreach ($node as $key => $val) {
                    if (is_string($key) && in_array(strtolower($key), ['heading', 'header', 'title', 'subheading', 'headline'], true)) {
                        $headingsCount++;
                    }
                    if (!in_array((string) $key, ['type', 'icon', 'layout', 'style', 'styles', 'id', 'meta', 'seo_title', 'seo_description', 'seo_keywords'], true)) {
                        $extract($val);
                    }
                }
            }
        };

        $extract($rawContent);

        preg_match_all('/<h[1-6][^>]*>/i', $extractedRaw, $htmlMatches);
        $headingsCount += count($htmlMatches[0] ?? []);

        preg_match_all('/^\s*#{1,6}\s+.+$/m', $extractedRaw, $mdMatches);
        $headingsCount += count($mdMatches[0] ?? []);

        $cleanText = trim((string) preg_replace('/\s+/', ' ', $extractedText));
        $words = array_values(array_filter(explode(' ', $cleanText)));
        $totalWords = count($words);
        $readingTime = max(1, (int) ceil($totalWords / 200));

        $keywordMatches = 0;
        $keywordDensity = 0.0;
        if (!empty($focusKeyword) && $totalWords > 0) {
            $escapedKw = preg_quote($focusKeyword, '/');
            preg_match_all('/' . $escapedKw . '/i', $cleanText, $densityMatches);
            $keywordMatches = count($densityMatches[0] ?? []);
            $keywordDensity = round(($keywordMatches / $totalWords) * 100, 1);
        }

        $fleschScore = 60;
        if ($totalWords >= 5) {
            $sentences = preg_split('/[.!?]+/', $cleanText, -1, PREG_SPLIT_NO_EMPTY);
            $sentenceCount = max(1, count($sentences));

            $syllables = 0;
            foreach ($words as $w) {
                $cw = preg_replace('/(?:[^laeiouy]|ed|es|e)$/i', '', strtolower($w));
                $cw = preg_replace('/^y/i', '', (string) $cw);
                preg_match_all('/[aeiouy]{1,2}/', (string) $cw, $sMatches);
                $syllables += max(1, count($sMatches[0] ?? []));
            }

            $scoreCalc = 206.835 - (1.015 * ($totalWords / $sentenceCount)) - (84.6 * ($syllables / $totalWords));
            $fleschScore = max(0, min(100, (int) round($scoreCalc)));
        }

        $rawImg = $get('og_image') ?? $get('meta.og_image') ?? ($meta['og_image'] ?? null) ?? $get('image') ?? $get('../image');
        if (is_array($rawImg)) {
            $rawImg = reset($rawImg);
        }
        $ogImage = '';
        if (!empty($rawImg) && is_string($rawImg)) {
            if (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://')) {
                $ogImage = $rawImg;
            } elseif (str_starts_with($rawImg, 'storage/') || str_starts_with($rawImg, '/storage/')) {
                $ogImage = '/' . ltrim($rawImg, '/');
            } else {
                $ogImage = '/storage/' . ltrim($rawImg, '/');
            }
        }

        $score = 0;
        $audits = [];

        // 1. Focus Keyword (10 pts)
        if (!empty($focusKeyword)) {
            $score += 10;
            $audits[] = ['id' => 1, 'category' => 'onpage', 'status' => 'good', 'title' => 'Focus Keyword Defined', 'message' => "Primary keyword set to \"{$focusKeyword}\"."];

            // 2. Title
            if (!empty($title)) {
                if (stripos($title, $focusKeyword) === 0) {
                    $score += 15;
                    $audits[] = ['id' => 2, 'category' => 'onpage', 'status' => 'good', 'title' => 'Keyword at Start of Title', 'message' => 'Target keyword is placed at the beginning of the title.'];
                } elseif (stripos($title, $focusKeyword) !== false) {
                    $score += 10;
                    $audits[] = ['id' => 2, 'category' => 'onpage', 'status' => 'good', 'title' => 'Keyword in Title', 'message' => 'Target keyword is present in the meta title.'];
                } else {
                    $audits[] = ['id' => 2, 'category' => 'onpage', 'status' => 'error', 'title' => 'Keyword Missing from Title', 'message' => 'Include your target keyword in the SEO Title.'];
                }
            }

            // 3. Description
            if (!empty($desc) && stripos($desc, $focusKeyword) !== false) {
                $score += 10;
                $audits[] = ['id' => 3, 'category' => 'onpage', 'status' => 'good', 'title' => 'Keyword in Meta Description', 'message' => 'Focus keyword appears in the snippet description.'];
            } else {
                $audits[] = ['id' => 3, 'category' => 'onpage', 'status' => 'warning', 'title' => 'Keyword Missing from Description', 'message' => 'Include your focus keyword inside the meta description.'];
            }

            // 4. URL Slug
            $cleanSlugKw = str_replace(' ', '-', strtolower($focusKeyword));
            if (!empty($slug) && stripos(strtolower($slug), $cleanSlugKw) !== false) {
                $score += 10;
                $audits[] = ['id' => 4, 'category' => 'onpage', 'status' => 'good', 'title' => 'Keyword in URL Slug', 'message' => 'Target keyword is present in the page URL.'];
            } else {
                $audits[] = ['id' => 4, 'category' => 'onpage', 'status' => 'warning', 'title' => 'Keyword Missing from URL', 'message' => 'Include your keyword in the page URL slug.'];
            }

            // 5. Intro
            $first100Words = implode(' ', array_slice($words, 0, 100));
            if (!empty($first100Words) && stripos($first100Words, $focusKeyword) !== false) {
                $score += 10;
                $audits[] = ['id' => 5, 'category' => 'content', 'status' => 'good', 'title' => 'Keyword in Introduction', 'message' => 'Keyword appears in the opening paragraph.'];
            } else {
                $audits[] = ['id' => 5, 'category' => 'content', 'status' => 'warning', 'title' => 'Keyword Missing from Intro', 'message' => 'Place your keyword in the first paragraph.'];
            }
        } else {
            $audits[] = ['id' => 1, 'category' => 'onpage', 'status' => 'error', 'title' => 'Missing Focus Keyword', 'message' => 'Set a focus keyword to evaluate search optimization.'];
        }

        // 6. Title Length
        $titleLen = mb_strlen($title);
        if ($titleLen >= 40 && $titleLen <= 60) {
            $score += 10;
            $audits[] = ['id' => 6, 'category' => 'onpage', 'status' => 'good', 'title' => 'Optimal Title Length', 'message' => "Title is {$titleLen} characters (Ideal: 40-60)."];
        } elseif ($titleLen > 0) {
            $score += 5;
            $audits[] = ['id' => 6, 'category' => 'onpage', 'status' => 'warning', 'title' => 'Title Length Suboptimal', 'message' => "Title is {$titleLen} characters. Aim for 40-60 characters."];
        } else {
            $audits[] = ['id' => 6, 'category' => 'onpage', 'status' => 'error', 'title' => 'Missing Title', 'message' => 'Add an SEO Title.'];
        }

        // 7. Description Length
        $descLen = mb_strlen($desc);
        if ($descLen >= 120 && $descLen <= 160) {
            $score += 10;
            $audits[] = ['id' => 7, 'category' => 'onpage', 'status' => 'good', 'title' => 'Optimal Description', 'message' => "Description is {$descLen} characters (Ideal: 120-160)."];
        } elseif ($descLen > 0) {
            $score += 5;
            $audits[] = ['id' => 7, 'category' => 'onpage', 'status' => 'warning', 'title' => 'Description Length Suboptimal', 'message' => "Description is {$descLen} characters. Target 120-160 characters."];
        } else {
            $audits[] = ['id' => 7, 'category' => 'onpage', 'status' => 'error', 'title' => 'Missing Meta Description', 'message' => 'Add a meta description.'];
        }

        // 8. Word Count
        if ($totalWords >= 280) {
            $score += 10;
            $audits[] = ['id' => 8, 'category' => 'content', 'status' => 'good', 'title' => 'Rich Content Depth', 'message' => "Found {$totalWords} words."];
        } elseif ($totalWords >= 120) {
            $score += 5;
            $audits[] = ['id' => 8, 'category' => 'content', 'status' => 'good', 'title' => 'Adequate Word Count', 'message' => "Found {$totalWords} words."];
        } else {
            $audits[] = ['id' => 8, 'category' => 'content', 'status' => 'warning', 'title' => 'Short Content', 'message' => "Found {$totalWords} words. Aim for 300+ words."];
        }

        // 9. Headings
        if ($headingsCount >= 1) {
            $score += 5;
            $audits[] = ['id' => 9, 'category' => 'content', 'status' => 'good', 'title' => 'Structured Headings', 'message' => "Found {$headingsCount} heading(s) organizing the content."];
        } else {
            $audits[] = ['id' => 9, 'category' => 'content', 'status' => 'warning', 'title' => 'Add Subheadings', 'message' => 'Use headings to break up sections.'];
        }

        // 10. Schema Preset
        $schemaType = $get('schema_type') ?? $get('meta.schema_type') ?? ($meta['schema_type'] ?? null);
        if (!empty($schemaType)) {
            $score += 5;
            $audits[] = ['id' => 10, 'category' => 'technical', 'status' => 'good', 'title' => "Schema Preset: \"{$schemaType}\"", 'message' => 'Structured data rich snippet is configured.'];
        }

        // 11. Social Sharing Banner
        if (!empty($ogImage)) {
            $score += 5;
            $audits[] = ['id' => 11, 'category' => 'technical', 'status' => 'good', 'title' => 'Social Share Graphic', 'message' => 'OpenGraph banner is uploaded.'];
        }

        $finalScore = min(100, max(0, $score));

        return [
            'score'               => $finalScore,
            'scoreRating'         => match (true) { $finalScore >= 80 => 'Rank-Ready', $finalScore >= 50 => 'Needs Optimization', default => 'Action Required' },
            'scoreColor'          => match (true) { $finalScore >= 80 => 'text-emerald-600 dark:text-emerald-400', $finalScore >= 50 => 'text-amber-600 dark:text-amber-400', default => 'text-rose-600 dark:text-rose-400' },
            'strokeColor'         => match (true) { $finalScore >= 80 => 'text-emerald-500', $finalScore >= 50 => 'text-amber-500', default => 'text-rose-500' },
            'fleschScore'         => $fleschScore,
            'readabilityRating'   => match (true) { $fleschScore >= 60 => 'Easy to Read', $fleschScore >= 40 => 'Moderate Level', default => 'Hard to Read' },
            'readabilityBadge'    => match (true) { $fleschScore >= 60 => 'bg-emerald-500', $fleschScore >= 40 => 'bg-amber-500', default => 'bg-rose-500' },
            'readabilityColor'    => match (true) { $fleschScore >= 60 => 'text-emerald-600 dark:text-emerald-400', $fleschScore >= 40 => 'text-amber-600 dark:text-amber-400', default => 'text-rose-600 dark:text-rose-400' },
            'focusKeyword'        => $focusKeyword,
            'keywordDensity'      => $keywordDensity,
            'keywordMatches'      => $keywordMatches,
            'keywordDensityColor' => match (true) { $keywordDensity >= 0.8 && $keywordDensity <= 2.5 => 'bg-emerald-500', $keywordDensity > 2.5 => 'bg-rose-500', default => 'bg-amber-500' },
            'words'               => $totalWords,
            'headings'            => $headingsCount,
            'readingTime'         => $readingTime,
            'title'               => $title ?: 'Set an SEO Meta Title...',
            'description'         => $desc ?: 'Add a concise meta description to preview how your page appears in search results.',
            'slug'                => $slug,
            'ogTitle'             => $meta['og_title'] ?? $title,
            'ogDesc'              => $meta['og_description'] ?? $desc,
            'ogImage'             => $ogImage,
            'audits'              => $audits,
            'stats'               => [
                'passed'   => count(array_filter($audits, fn ($a) => $a['status'] === 'good')),
                'warnings' => count(array_filter($audits, fn ($a) => $a['status'] === 'warning')),
                'failed'   => count(array_filter($audits, fn ($a) => $a['status'] === 'error')),
            ],
        ];
    }
}
