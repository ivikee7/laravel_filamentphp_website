<?php

namespace App\Filament\Resources\Contents\Schemas;

use App\Models\Content;
use App\Filament\Forms\Components\SeoAnalyzer;
use App\Filament\Schemas\PageSeoSchema;
use App\Filament\Schemas\PageSettingsSchema;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\CodeEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ContentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()->tabs([
                    Tab::make('Page')->schema([
                        Section::make('Content')->schema([
                            CodeEntry::make('content'),
                            RepeatableEntry::make('content')
                                ->hiddenLabel()
                                ->schema([
                                    TextEntry::make('data.content')
                                        ->hiddenLabel()
                                        ->html()
                                        ->prose()
                                        ->columnSpanFull(),
                                ])
                                ->grid(1)
                                ->columnSpanFull(),
                        ]),
                    ]),
                    Tab::make('SEO Analytics')
                        ->icon('heroicon-o-chart-bar-square')
                        ->schema([
                            SeoAnalyzer::make('seo_live_analysis')
                                ->columnSpanFull(),
                        ]),
                    Tab::make('Meta Data')
                        ->schema([
                            CodeEntry::make('meta'),
                        ]),
                    Tab::make('Settings')
                        ->schema([
                            CodeEntry::make('styles'),
                            CodeEntry::make('setting'),
                        ]),
                ]),

            ])->columns(1);
    }
}
