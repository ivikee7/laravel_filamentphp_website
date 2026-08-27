<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CheckboxList;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;

class PageBuilderSchema
{
    public static function make(): Section
    {
        return Section::make('High-Level Page Architecture')
            ->schema([
                Tabs::make('Page Structure Setup')
                    ->tabs([
                        Tab::make('Root Canvas')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('title')->label('Document Title')->required(),
                                    TextInput::make('slug')->label('URL Endpoint')->required(),
                                ]),
                                Builder::make('content')
                                    ->label('Root Content Layouts')
                                    ->blockIcons()
                                    ->collapsible()
                                    ->cloneable()
                                    ->blocks([
                                        Block::make('section')
                                            ->label('Root Section Canvas')
                                            ->icon('heroicon-o-rectangle-group')
                                            ->schema([
                                                Tabs::make('Canvas Controls')
                                                    ->tabs([
                                                        Tab::make('Grid Engine')
                                                            ->schema([
                                                                Repeater::make('rows')
                                                                    ->label('Canvas Rows')
                                                                    ->schema([
                                                                        Grid::make(3)->schema([
                                                                            Select::make('columns_layout')
                                                                                ->label('Grid Preset')
                                                                                ->options([
                                                                                    '1'     => '1 Column (Full Width)',
                                                                                    '2'     => '2 Columns (50 / 50)',
                                                                                    '3'     => '3 Columns (33 / 33 / 33)',
                                                                                    '4'     => '4 Columns (25 / 25 / 25 / 25)',
                                                                                    '1-2'   => '2 Columns (33 / 67)',
                                                                                    '2-1'   => '2 Columns (67 / 33)',
                                                                                ])->default('1'),
                                                                            Select::make('gap')->label('Column Spacing Gap')->options(['gap-0' => '0px', 'gap-4' => '16px', 'gap-8' => '32px', 'gap-12' => '48px'])->default('gap-8'),
                                                                            Select::make('align_items')->label('Vertical Alignment')->options(['items-start' => 'Top', 'items-center' => 'Center', 'items-end' => 'Bottom'])->default('items-start'),
                                                                        ]),
                                                                        Repeater::make('columns')
                                                                            ->label('Column Slots')
                                                                            ->schema([
                                                                                Tabs::make('Column Inspector')
                                                                                    ->tabs([
                                                                                        Tab::make('Nested Blocks')->schema([
                                                                                            Builder::make('blocks')
                                                                                                ->label('Column Items')
                                                                                                ->blockIcons()
                                                                                                ->collapsible()
                                                                                                ->blocks(BlockRegistry::getBlocks(depth: 0, maxDepth: 5)),
                                                                                        ]),
                                                                                        Tab::make('Column Surface')->schema(array_merge(
                                                                                            StyleHelper::makeBackgroundGroup(),
                                                                                            StyleHelper::makeBoxStyleGroup()
                                                                                        )),
                                                                                    ]),
                                                                            ])->grid(1),
                                                                    ])->collapsible(),
                                                            ]),
                                                        Tab::make('Section Surface')
                                                            ->schema(StyleHelper::makeBackgroundGroup()),
                                                        Tab::make('Box Model & Visibility')
                                                            ->schema([
                                                                Grid::make(4)->schema([
                                                                    Select::make('padding_top')
                                                                        ->options(['pt-0' => '0', 'pt-4' => 'Small', 'pt-8' => 'Medium', 'pt-16' => 'Large', 'pt-24' => 'XL'])
                                                                        ->default('pt-8'),
                                                                    Select::make('padding_bottom')
                                                                        ->options(['pb-0' => '0', 'pb-4' => 'Small', 'pb-8' => 'Medium', 'pb-16' => 'Large', 'pb-24' => 'XL'])
                                                                        ->default('pb-8'),
                                                                    Select::make('padding_left')
                                                                        ->options(['px-0' => '0', 'px-4' => 'Small', 'px-8' => 'Medium', 'px-16' => 'Large'])
                                                                        ->default('px-4'),
                                                                    Select::make('max_width')
                                                                        ->options(['max-w-4xl' => 'Compact (896px)', 'max-w-7xl' => 'Standard Boxed (1280px)', 'max-w-full' => '100% Full Width'])
                                                                        ->default('max-w-7xl'),
                                                                ]),
                                                                CheckboxList::make('hide_on')
                                                                    ->label('Responsive Breakpoint Hiding')
                                                                    ->options([
                                                                        'max-md:hidden' => 'Hide on Mobile (<768px)',
                                                                        'md:max-lg:hidden' => 'Hide on Tablet (768px-1024px)',
                                                                        'lg:hidden' => 'Hide on Desktop (>1024px)',
                                                                    ])->columns(3),
                                                            ]),
                                                    ]),
                                            ]),
                                    ]),
                            ]),
                    ]),
            ])
            ->columnSpanFull();
    }
}
