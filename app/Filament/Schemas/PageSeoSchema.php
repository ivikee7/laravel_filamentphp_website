<?php

namespace App\Filament\Schemas;

use App\Filament\Forms\Components\SeoAnalyzer;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class PageSeoSchema
{
    public static function make(): Group
    {
        // Tells Filament to store all children inside the 'seo' JSON column
        return Group::make()
            ->statePath('seo')
            ->schema([
                Tabs::make('SEO Configuration Engine')
                    ->tabs([
                        // Live Inspector
                        Tab::make('Live SEO Inspector')
                            ->icon('heroicon-o-chart-bar-square')
                            ->schema([
                                SeoAnalyzer::make('seo_live_analysis')
                                    ->columnSpanFull(),
                            ]),

                        // Search Metadata
                        Tab::make('Search Metadata')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('seo_title')
                                        ->label('Meta Title')
                                        ->reactive()
                                        ->maxLength(60),
                                    TextInput::make('canonical_url')
                                        ->label('Canonical URL')
                                        ->url(),
                                ]),
                                Textarea::make('seo_description')
                                    ->label('Meta Description')
                                    ->reactive()
                                    ->rows(3)
                                    ->maxLength(160),
                                TagsInput::make('seo_keywords')
                                    ->label('Focus Keywords')
                                    ->reactive()
                                    ->separator(','),
                            ]),

                        // Social Sharing Cards
                        Tab::make('Social Media (OG)')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('og_title')->label('Facebook Title'),
                                    TextInput::make('twitter_title')->label('Twitter Title'),
                                ]),
                                Textarea::make('og_description')->label('Social Description')->rows(2),
                                Grid::make(2)->schema([
                                    FileUpload::make('og_image')
                                        ->label('Social Card Image')
                                        ->disk('public')
                                        ->directory('seo/og-images')
                                        ->image(),
                                    Select::make('twitter_card_type')
                                        ->options([
                                            'summary' => 'Standard Card',
                                            'summary_large_image' => 'Large Banner',
                                        ])->default('summary_large_image'),
                                ]),
                            ]),
                    ]),
            ]);
    }
}
