<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class PageSettingsSchema
{
    public static function make(): Group
    {
        // Bind all setting fields directly into the 'setting' JSON database column
        return Group::make()
            ->statePath('setting')
            ->schema([
                Tabs::make('Technical Page Settings')
                    ->tabs([
                        // General & Status
                        Tab::make('General Status')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Grid::make(3)->schema([
                                    Select::make('status')
                                        ->options([
                                            'draft' => 'Draft',
                                            'published' => 'Published',
                                            'archived' => 'Archived',
                                        ])->default('draft'),
                                    DateTimePicker::make('published_at')->label('Publish Date'),
                                    Select::make('template')
                                        ->options([
                                            'default' => 'Default Canvas Layout',
                                            'full_width' => 'Full Width Canvas',
                                            'sidebar' => 'With Sidebar',
                                        ])->default('default'),
                                ]),
                                Grid::make(2)->schema([
                                    Toggle::make('requires_auth')
                                        ->label('Restrict Access (Auth Required)')
                                        ->default(false),
                                    TextInput::make('password_protection')
                                        ->label('Page Password Protection')
                                        ->password(),
                                ]),
                            ]),

                        // Custom Scripts & Meta
                        Tab::make('Code Injection')
                            ->icon('heroicon-o-code-bracket')
                            ->schema([
                                Textarea::make('header_scripts')
                                    ->label('Head Script Injection (<head>)')
                                    ->rows(4),
                                Textarea::make('footer_scripts')
                                    ->label('Footer Script Injection (</body>)')
                                    ->rows(4),
                                KeyValue::make('custom_meta_tags')
                                    ->label('Custom Meta Tags (Key => Value)')
                                    ->keyLabel('Meta Property Name')
                                    ->valueLabel('Content'),
                            ]),
                    ]),
            ]);
    }
}
