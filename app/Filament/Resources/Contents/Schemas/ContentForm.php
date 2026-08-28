<?php

namespace App\Filament\Resources\Contents\Schemas;

use App\Filament\Schemas\PageBuilderSchema;
use App\Filament\Schemas\PageSeoSchema;
use App\Filament\Schemas\PageSettingsSchema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Schemas\Schema;

class ContentForm
{
    /**
     * Define the schema for Filament Resource Form
     */
    public static function configure(Schema|Form $form): Schema|Form
    {
        return $form->schema(self::make());
    }

    /**
     * Form components definition
     */
    public static function make(): array
    {
        return [
            TextInput::make('title')
                ->label('Page Title')
                ->required()
                ->live(onBlur: true)
                ->maxLength(255),

            TextInput::make('slug')
                ->label('URL Slug')
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            Tabs::make('Content Management')
                ->tabs([
                    Tab::make('Page Builder')
                        ->icon('heroicon-o-rectangle-stack')
                        ->schema([
                            PageBuilderSchema::make('content'),
                        ]),

                    Tab::make('SEO & Social')
                        ->icon('heroicon-o-globe-alt')
                        ->schema([
                            PageSeoSchema::make(),
                        ]),

                    Tab::make('Page Settings')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            PageSettingsSchema::make(),
                        ]),
                ])
                ->columnSpanFull(),
        ];
    }
}
