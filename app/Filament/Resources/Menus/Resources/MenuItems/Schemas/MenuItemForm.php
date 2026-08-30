<?php

namespace App\Filament\Resources\Menus\Resources\MenuItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('MenuItems')->schema([
                    Group::make([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('slug'),
                    ])->columns(2),
                    Group::make([
                        Select::make('type')
                            ->label('Link Type')
                            ->options([
                                'internal'  => '🔗 Internal Route / Page',
                                'external'  => '🌐 External URL',
                                'email'     => '✉️ Email Link (mailto:)',
                                'telephone' => '📞 Phone Call (tel:)',
                                'nolink'    => '🏷️ Non-Clickable / Heading',
                            ])
                            ->required()
                            ->default('internal')
                            ->live(),

                        // Target (Open in new tab vs same tab)
                        Select::make('target')
                            ->label('Open Target')
                            ->options([
                                '_self'  => 'Same Window (_self)',
                                '_blank' => 'New Tab (_blank)',
                            ])
                            ->default('_self')
                            ->visible(fn ($get) => in_array($get('type'), ['internal', 'external'])),
                    ])->columns(2),

                    // Internal Path / Page
                    TextInput::make('url')
                        ->label('Internal Path')
                        ->placeholder('/about-us or /admissions')
                        ->visible(fn ($get) => $get('type') === 'internal')
                        ->required(fn ($get) => $get('type') === 'internal'),

                    // External Full URL
                    TextInput::make('url')
                        ->label('Website Address')
                        ->placeholder('https://example.com')
                        ->url()
                        ->visible(fn ($get) => $get('type') === 'external')
                        ->required(fn ($get) => $get('type') === 'external'),

                    // Email Address
                    TextInput::make('url')
                        ->label('Recipient Email')
                        ->placeholder('admissions@srcspatna.com')
                        ->email()
                        ->visible(fn ($get) => $get('type') === 'email')
                        ->required(fn ($get) => $get('type') === 'email'),

                    // Phone Number
                    TextInput::make('url')
                        ->label('Phone Number')
                        ->placeholder('+91 8873002601')
                        ->tel()
                        ->visible(fn ($get) => $get('type') === 'telephone')
                        ->required(fn ($get) => $get('type') === 'telephone'),

                    Group::make([
                        TextInput::make('left_icon'),
                        TextInput::make('right_icon'),
                    ])->columns(2),
                ])->columnSpan(4),
                Section::make('MenuItems')->schema([
                    Select::make('parent_id')
                        ->relationship('parent', 'name'),
                    TextInput::make('sort_order')
                        ->required()
                        ->numeric()
                        ->default(0),
                    Toggle::make('is_active')
                        ->required()->default(true),
                ])->columnSpan(2),

            ])->columns(6);
    }
}
