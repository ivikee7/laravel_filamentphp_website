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

class PageSeoSchema
{
    public static function make(): Group
    {
        return Group::make()
            ->statePath('meta')
            ->schema([
                Tabs::make('SEO Management Engine')
                    ->tabs([
                        Tab::make('SEO Analytics')
                            ->icon('heroicon-o-chart-bar-square')
                            ->schema([
                                SeoAnalyzer::make('seo_live_analysis')
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Metadata & Settings')
                            ->icon('heroicon-o-adjustments-horizontal')
                            ->schema([
                                Section::make('Search Engine Snippet')
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('seo_title')
                                                ->label('Meta Title')
                                                ->placeholder('Catchy title (Defaults to page title if empty)')
                                                ->live(debounce: 500)
                                                ->maxLength(70)
                                                ->helperText('Target: 40-60 characters.'),

                                            TextInput::make('canonical_url')
                                                ->label('Canonical URL')
                                                ->placeholder('https://yourdomain.com/canonical')
                                                ->url(),
                                        ]),

                                        Textarea::make('seo_description')
                                            ->label('Meta Description')
                                            ->placeholder('Concise summary containing target keywords...')
                                            ->live(debounce: 500)
                                            ->rows(3)
                                            ->maxLength(160)
                                            ->helperText('Target: 120-160 characters.'),

                                        Grid::make(2)->schema([
                                            TagsInput::make('seo_keywords')
                                                ->label('Target Focus Keywords')
                                                ->placeholder('Enter primary keyword first')
                                                ->live(debounce: 500)
                                                ->separator(','),

                                            TextInput::make('breadcrumb_title')
                                                ->label('Breadcrumb Title'),
                                        ]),
                                    ]),

                                Section::make('Social Sharing (OpenGraph & Twitter/X)')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(2)->schema([
                                            TextInput::make('og_title')
                                                ->label('Social Share Title')
                                                ->live(debounce: 500),

                                            TextInput::make('twitter_title')
                                                ->label('Twitter / X Title')
                                                ->live(debounce: 500),
                                        ]),

                                        Textarea::make('og_description')
                                            ->label('Social Description')
                                            ->rows(2)
                                            ->live(debounce: 500),

                                        Grid::make(2)->schema([
                                            FileUpload::make('og_image')
                                                ->label('Social Share Image (1200x630)')
                                                ->disk('public')
                                                ->directory('seo/og-images')
                                                ->image()
                                                ->live(),

                                            Select::make('twitter_card_type')
                                                ->options([
                                                    'summary_large_image' => 'Large Visual Banner',
                                                    'summary' => 'Standard Thumbnail',
                                                ])
                                                ->default('summary_large_image'),
                                        ]),
                                    ]),

                                Section::make('Structured Data & Schema.org')
                                    ->collapsible()
                                    ->collapsed()
                                    ->schema([
                                        Select::make('schema_type')
                                            ->label('Schema Preset')
                                            ->options([
                                                'WebPage' => 'Standard Web Page',
                                                'Article' => 'Article / Blog Post',
                                                'NewsArticle' => 'News Article',
                                                'Organization' => 'Organization / School',
                                                'Person' => 'Person Profile',
                                                'FAQPage' => 'FAQ Page',
                                            ])
                                            ->default('Article')
                                            ->live(),

                                        Textarea::make('custom_json_ld')
                                            ->label('Custom JSON-LD Override')
                                            ->rows(4),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
