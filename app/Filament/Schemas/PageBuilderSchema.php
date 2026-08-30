<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class PageBuilderSchema
{
    public static function make(string $statePath = 'content'): Builder
    {
        return Builder::make($statePath)
            ->label('Canvas Blocks & Sections')
            ->blockIcons()
            ->collapsible()
            ->cloneable()
            ->blockPickerColumns(4)
            ->blocks(array_merge(
                [
                    Block::make('section')
                        ->label('Section Layout Canvas')
                        ->icon('heroicon-o-rectangle-group')
                        ->schema([
                            Tabs::make('Section Controls')
                                ->schema([
                                    Tab::make('Rows & Columns Grid')
                                        ->icon('heroicon-o-view-columns')
                                        ->schema([
                                            Repeater::make('rows')
                                                ->label('Grid Rows')
                                                ->schema([
                                                    Grid::make(3)->schema([
                                                        Select::make('columns_layout')
                                                            ->label('Grid Preset')
                                                            ->options([
                                                                '1'   => '1 Column (Full Width)',
                                                                '2'   => '2 Columns (50 / 50)',
                                                                '3'   => '3 Columns (33 / 33 / 33)',
                                                                '4'   => '4 Columns (25 / 25 / 25 / 25)',
                                                                '1-2' => '2 Columns (33 / 67 Sidebar Left)',
                                                                '2-1' => '2 Columns (67 / 33 Sidebar Right)',
                                                            ])
                                                            ->default('1')
                                                            ->live(),

                                                        Select::make('gap')
                                                            ->label('Column Spacing Gap')
                                                            ->options([
                                                                'gap-0'  => 'No Gap (0px)',
                                                                'gap-4'  => 'Small (16px)',
                                                                'gap-6'  => 'Medium (24px)',
                                                                'gap-8'  => 'Standard (32px)',
                                                                'gap-12' => 'Wide (48px)',
                                                            ])
                                                            ->default('gap-6'),

                                                        Select::make('align_items')
                                                            ->label('Vertical Alignment')
                                                            ->options([
                                                                'items-start'  => 'Top',
                                                                'items-center' => 'Center',
                                                                'items-end'    => 'Bottom',
                                                            ])
                                                            ->default('items-start'),
                                                    ]),

                                                    Repeater::make('columns')
                                                        ->label('Column Content Slots')
                                                        ->schema([
                                                            Tabs::make('Column Settings')
                                                                ->schema([
                                                                    Tab::make('Column Elements')
                                                                        ->icon('heroicon-o-cube')
                                                                        ->schema([
                                                                            Builder::make('blocks')
                                                                                ->label('Elements in Column')
                                                                                ->blockIcons()
                                                                                ->collapsible()
                                                                                ->blockPickerColumns(3)
                                                                                ->blocks(BlockRegistry::getLeafBlocks()),
                                                                        ]),

                                                                    Tab::make('Column Styles')
                                                                        ->icon('heroicon-o-paint-brush')
                                                                        ->schema([
                                                                            StyleHelper::makeStyleEngine('styles'),
                                                                        ]),
                                                                ]),
                                                        ])
                                                        ->grid(fn ($get) => match ($get('columns_layout')) {
                                                            '2', '1-2', '2-1' => 2,
                                                            '3'               => 3,
                                                            '4'               => 4,
                                                            default           => 1,
                                                        })
                                                        ->collapsible(),
                                                ])
                                                ->collapsible(),
                                        ]),

                                    Tab::make('Section Design & Box Model')
                                        ->icon('heroicon-o-paint-brush')
                                        ->schema([
                                            StyleHelper::makeStyleEngine('styles'),
                                        ]),
                                ]),
                        ]),
                ],
                BlockRegistry::getBlocks(depth: 0, maxDepth: 1)
            ))
            ->columnSpanFull();
    }
}
