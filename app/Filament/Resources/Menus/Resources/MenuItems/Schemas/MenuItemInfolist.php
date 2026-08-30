<?php

namespace App\Filament\Resources\Menus\Resources\MenuItems\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MenuItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('menu.name')
                    ->label('Menu'),
                TextEntry::make('parent.name')
                    ->label('Parent')
                    ->placeholder('-'),
                TextEntry::make('name'),
                TextEntry::make('slug')
                    ->placeholder('-'),
                TextEntry::make('type'),
                TextEntry::make('url')
                    ->placeholder('-'),
                TextEntry::make('target'),
                TextEntry::make('left_icon')
                    ->placeholder('-'),
                TextEntry::make('right_icon')
                    ->placeholder('-'),
                TextEntry::make('sort_order')
                    ->numeric(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
