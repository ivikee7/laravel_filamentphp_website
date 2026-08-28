<?php

namespace App\Filament\Schemas;

use App\Filament\Forms\Components\SeoAnalyzer;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PageSeoSchema
{
    public static function make(): Group
    {
        return Group::make()
            ->statePath('seo')
            ->schema([
                Tabs::make('SEO Management Engine')
                    ->tabs([
                        // Tab 1: Live SEO Analysis & Diagnostics
                        Tab::make('SEO Analytics')
                            ->icon('heroicon-o-chart-bar-square')
                            ->schema([
                                SeoAnalyzer::make('seo_live_analysis')
                                    ->columnSpanFull(),
                            ]),

                        // Tab 2: All Metadata, Social, Search & Technical SEO Settings
                        Tab::make('Metadata & Settings')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->schema([
                                // 1. SERP Search Snippet
                                Section::make('Search Engine Snippet')
                                    ->description('Core meta tags displayed on search engine result pages (SERPs).')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('seo_title')
                                                ->label('Meta Title')
                                                ->placeholder('Catchy, keyword-rich title (Defaults to page title if empty)')
                                                ->live(debounce: 400)
                                                ->maxLength(70)
                                                ->helperText('Recommended: 40-60 characters for desktop/mobile snippets.'),

                                            TextInput::make('canonical_url')
                                                ->label('Canonical URL')
                                                ->placeholder('https://yourdomain.com/original-source')
                                                ->url()
                                                ->helperText('Prevents duplicate content penalties if republished elsewhere.'),
                                        ]),

                                        Textarea::make('seo_description')
                                            ->label('Meta Description')
                                            ->placeholder('Concise summary containing primary and secondary keywords...')
                                            ->live(debounce: 400)
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Target: 120-160 characters. Search engines highlight search terms found here.'),

                                        Grid::make(2)->schema([
                                            TagsInput::make('seo_keywords')
                                                ->label('Target Focus Keywords')
                                                ->placeholder('Enter primary keyword first, then secondary terms')
                                                ->live(debounce: 400)
                                                ->separator(','),

                                            TextInput::make('breadcrumb_title')
                                                ->label('Breadcrumb Title')
                                                ->placeholder('Short title for search trail navigation (e.g. Admissions)'),
                                        ]),
                                    ]),

                                // 2. Social Sharing (OpenGraph & Twitter / X)
                                Section::make('Social Sharing (OpenGraph & Twitter/X)')
                                    ->description('Customize how this page looks when shared on social platforms and messaging apps.')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('og_title')
                                                ->label('Social Share Title')
                                                ->placeholder('Headline for Facebook, LinkedIn & Slack')
                                                ->live(debounce: 400),

                                            TextInput::make('twitter_title')
                                                ->label('Twitter / X Title')
                                                ->placeholder('Headline specifically for Twitter/X cards')
                                                ->live(debounce: 400),
                                        ]),

                                        Textarea::make('og_description')
                                            ->label('Social Description')
                                            ->placeholder('Engaging snippet optimized for social timeline click-throughs...')
                                            ->rows(2)
                                            ->live(debounce: 400),

                                        Grid::make(2)->schema([
                                            FileUpload::make('og_image')
                                                ->label('Social Share Banner Image')
                                                ->disk('public')
                                                ->directory('seo/og-images')
                                                ->image()
                                                ->imageResizeMode('cover')
                                                ->imageCropAspectRatio('1200:630')
                                                ->helperText('Optimal dimensions: 1200 × 630 px (1.91:1 ratio).'),

                                            Select::make('twitter_card_type')
                                                ->label('Twitter / X Card Layout')
                                                ->options([
                                                    'summary_large_image' => 'Large Visual Banner (Recommended)',
                                                    'summary' => 'Standard Square Thumbnail',
                                                ])
                                                ->default('summary_large_image'),
                                        ]),
                                    ]),

                                // 3. Structured Data (Schema.org)
                                Section::make('Structured Data & Rich Snippets')
                                    ->description('Structured schema gives search engines semantic context to generate rich SERP cards.')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Select::make('schema_type')
                                            ->label('Schema Preset Type')
                                            ->options([
                                                'WebPage' => 'Standard Web Page',
                                                'Article' => 'Article / Blog Post',
                                                'NewsArticle' => 'News Article',
                                                'Organization' => 'Organization / School / Business',
                                                'Person' => 'Person / Profile',
                                                'FAQPage' => 'FAQ Page',
                                                'Custom' => 'Custom JSON-LD (Manual Override)',
                                            ])
                                            ->default('WebPage'),

                                        Textarea::make('custom_json_ld')
                                            ->label('Custom JSON-LD Override')
                                            ->placeholder("{\n  \"@context\": \"https://schema.org\",\n  \"@type\": \"Article\",\n  \"headline\": \"...\"\n}")
                                            ->rows(5)
                                            ->helperText('Manual JSON-LD script injected directly into <head>.'),
                                    ]),

                                // 4. Crawl Directives & Technical 301 Controls
                                Section::make('Crawling Directives & Redirections')
                                    ->description('Advanced crawler behavior and 301/302 URL redirection.')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(2)->schema([
                                            Toggle::make('is_indexable')
                                                ->label('Allow Search Indexing (index / noindex)')
                                                ->helperText('Disable to prevent search engines from adding this page to their index.')
                                                ->default(true),

                                            Toggle::make('is_followable')
                                                ->label('Follow Links (follow / nofollow)')
                                                ->helperText('Disable to tell bots not to follow hyperlinks on this page.')
                                                ->default(true),
                                        ]),

                                        TextInput::make('robots_custom_tags')
                                            ->label('Custom Robots Directives')
                                            ->placeholder('e.g. max-snippet:-1, max-image-preview:large, max-video-preview:-1')
                                            ->helperText('Extra directives for Googlebot and Bingbot.'),

                                        Grid::make(2)->schema([
                                            TextInput::make('redirect_url')
                                                ->label('Redirect Target URL')
                                                ->placeholder('https://example.com/new-location')
                                                ->url()
                                                ->helperText('Leave empty unless this page has permanently moved.'),

                                            Select::make('redirect_code')
                                                ->label('HTTP Redirect Code')
                                                ->options([
                                                    301 => '301 - Permanent Redirect (Transfers SEO rank)',
                                                    302 => '302 - Temporary Redirect',
                                                ])
                                                ->default(301),
                                        ]),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
