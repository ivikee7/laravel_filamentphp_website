<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->columnSpan(1),

                TextInput::make('url')
                    ->placeholder('e.g., /services or https://...')
                    ->columnSpan(1),

                TextInput::make('icon')
                    ->placeholder('heroicon-o-home')
                    ->columnSpanFull(),

                Repeater::make('children')
                    ->label('Submenu Items (Dropdown)')
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'New Submenu')
                    ->reorderable() // Enables drag-and-drop sorting for submenus
                    ->cloneable()
                    ->collapsible()
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('url')
                            ->required(),
                        TextInput::make('icon')
                            ->placeholder('heroicon-o-arrow-right'),
                    ])->columnSpanFull()
                    ->columns(3),
            ]);
    }
}
