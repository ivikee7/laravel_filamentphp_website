<?php

namespace App\Filament\Resources\Contents\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use App\Filament\Schemas\PageBuilderSchema;
use App\Filament\Schemas\PageSeoSchema;
use App\Filament\Schemas\PageSettingsSchema;
use Filament\Support\Icons\Heroicon;

class ContentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Page Builder Manager')
                    ->tabs([
                        Tab::make('Visual Builder')
                            ->icon('heroicon-o-squares-2x2')
                            ->schema([
                                PageBuilderSchema::make(),
                            ]),

                        Tab::make('SEO Engine')
                            ->icon('heroicon-o-magnifying-glass')
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
            ])->columns(4);
    }
}
