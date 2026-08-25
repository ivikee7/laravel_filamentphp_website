<?php

namespace App\Filament\Resources\Contents\Schemas;

use App\Models\Content;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Content')->schema([
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
                ])->columnSpan(3),
                Section::make('Settings')->schema([
                    TextEntry::make('title'),
                    TextEntry::make('description'),
                    TextEntry::make('slug'),
                    ImageEntry::make('image')
                        ->placeholder('-'),
                    IconEntry::make('published')
                        ->boolean(),
                    TextEntry::make('published_at')
                        ->dateTime()
                        ->placeholder('-'),
                    TextEntry::make('seo.title')
                        ->placeholder('-'),
                    TextEntry::make('seo.description')
                        ->placeholder('-'),
                    TextEntry::make('meta')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('setting')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('created_at')
                        ->dateTime()
                        ->placeholder('-'),
                    TextEntry::make('updated_at')
                        ->dateTime()
                        ->placeholder('-'),
                    TextEntry::make('deleted_at')
                        ->dateTime()
                        ->visible(fn (Content $record): bool => $record->trashed()),
                ]),
            ])->columns(4);
    }
}
