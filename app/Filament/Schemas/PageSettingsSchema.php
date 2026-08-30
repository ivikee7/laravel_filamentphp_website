<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\ColorPicker;
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
        return Group::make()
            ->statePath('setting')
            ->schema([
                Tabs::make('Technical Page Settings')
                    ->tabs([
                        // 1. General Status & Routing Control
                        Tab::make('General Status')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Grid::make(3)->schema([
                                    Select::make('status')
                                        ->label('Publication Status')
                                        ->options([
                                            'draft' => 'Draft',
                                            'published' => 'Published',
                                            'archived' => 'Archived',
                                        ])
                                        ->default('draft')
                                        ->required(),

                                    DateTimePicker::make('published_at')
                                        ->label('Publish Date / Schedule')
                                        ->seconds(false)
                                        ->helperText('Leave empty to publish immediately upon saving.'),

                                    Select::make('template')
                                        ->label('Page Template')
                                        ->options([
                                            'default' => 'Default Canvas Layout',
                                            'full_width' => 'Full Width Canvas',
                                            'sidebar' => 'With Sidebar',
                                        ])
                                        ->default('default'),
                                ]),

                                Grid::make(3)->schema([
                                    Toggle::make('is_frontpage')
                                        ->label('Set as Homepage')
                                        ->helperText('Designates this page as the main root URL content.')
                                        ->default(false),

                                    Toggle::make('requires_auth')
                                        ->label('Restrict Access')
                                        ->helperText('Requires users to be logged in to view.')
                                        ->default(false),

                                    TextInput::make('password_protection')
                                        ->label('Password Protection')
                                        ->placeholder('Optional page password')
                                        ->password(),
                                ]),
                            ]),

                        // 2. Custom Script & Meta Injections
                        Tab::make('Code Injection')
                            ->icon('heroicon-o-code-bracket')
                            ->schema([
                                Textarea::make('header_scripts')
                                    ->label('Head Script Injection (<head>)')
                                    ->placeholder('<script>/* Analytics tracking or custom head tags */</script>')
                                    ->rows(4),

                                Textarea::make('footer_scripts')
                                    ->label('Footer Script Injection (before </body>)')
                                    ->placeholder('<script>/* Chat widget or conversion pixels */</script>')
                                    ->rows(4),

                                KeyValue::make('custom_meta_tags')
                                    ->label('Custom Meta Tags')
                                    ->keyLabel('Meta Name / Property')
                                    ->valueLabel('Content')
                                    ->reorderable(),
                            ]),
                    ]),
            ]);
    }
}
