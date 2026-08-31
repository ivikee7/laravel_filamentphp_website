<?php

namespace App\Filament\Schemas;

use Filament\Actions\Action;
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
            ->blockNumbers()
            ->cloneable() // 1. Section Duplication
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
                                                ->collapsible()
                                                ->reorderable()
                                                ->cloneable() // 2. Row Duplication
                                                ->extraItemActions([
                                                    Action::make('duplicateRow')
                                                        ->icon('heroicon-m-document-duplicate')
                                                        ->tooltip('Duplicate Row')
                                                        ->action(function (array $arguments, Repeater $component): void {
                                                            $state = $component->getState();
                                                            $item = $state[$arguments['item']] ?? null;
                                                            if ($item !== null) {
                                                                $state[] = $item;
                                                                $component->state($state);
                                                            }
                                                        }),
                                                ])
                                                ->schema([
                                                    Grid::make(3)->schema([
                                                        Select::make('columns_layout')
                                                            ->label('Grid Preset')
                                                            ->options([
                                                                // --- Single & Equal Multi-Columns ---
                                                                '1'       => '1 Column (Full Width - 100%)',
                                                                '2'       => '2 Columns (50 / 50)',
                                                                '3'       => '3 Columns (33 / 33 / 33)',
                                                                '4'       => '4 Columns (25 / 25 / 25 / 25)',
                                                                '5'       => '5 Columns (20 / 20 / 20 / 20 / 20)',
                                                                '6'       => '6 Columns (16.6% x 6)',

                                                                // --- 2-Column Asymmetric Splits ---
                                                                '1-2'     => '2 Columns (33 / 67 - Sidebar Left)',
                                                                '2-1'     => '2 Columns (67 / 33 - Sidebar Right)',
                                                                '1-3'     => '2 Columns (25 / 75 - Narrow Sidebar Left)',
                                                                '3-1'     => '2 Columns (75 / 25 - Narrow Sidebar Right)',
                                                                '2-3'     => '2 Columns (40 / 60 - Offset Left)',
                                                                '3-2'     => '2 Columns (60 / 40 - Offset Right)',

                                                                // --- 3-Column Asymmetric & Focus Layouts ---
                                                                '1-2-1'   => '3 Columns (25 / 50 / 25 - Center Hero Focus)',
                                                                '2-1-1'   => '3 Columns (50 / 25 / 25 - Main Left + 2 Stacked Right)',
                                                                '1-1-2'   => '3 Columns (25 / 25 / 50 - 2 Stacked Left + Main Right)',
                                                                '1-4-1'   => '3 Columns (16 / 68 / 16 - Wide Center Focus)',

                                                                // --- 4-Column Feature Splits ---
                                                                '2-1-1-1' => '4 Columns (40 / 20 / 20 / 20 - Featured Card Left)',
                                                                '1-1-1-2' => '4 Columns (20 / 20 / 20 / 40 - Featured Card Right)',
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
                                                        ->collapsible()
                                                        ->reorderable()
                                                        ->cloneable() // 3. Column Duplication
                                                        ->extraItemActions([
                                                            Action::make('duplicateColumn')
                                                                ->icon('heroicon-m-document-duplicate')
                                                                ->tooltip('Duplicate Column')
                                                                ->action(function (array $arguments, Repeater $component): void {
                                                                    $state = $component->getState();
                                                                    $item = $state[$arguments['item']] ?? null;
                                                                    if ($item !== null) {
                                                                        $state[] = $item;
                                                                        $component->state($state);
                                                                    }
                                                                }),
                                                        ])
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
                                                                                ->blockNumbers()
                                                                                ->cloneable() // 4. Element Duplication
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
                                                            '2', '1-2', '2-1', '1-3', '3-1', '2-3', '3-2' => 2,
                                                            '3', '1-2-1', '2-1-1', '1-1-2', '1-4-1'       => 3,
                                                            '4', '2-1-1-1', '1-1-1-2'                     => 4,
                                                            '5'                                           => 5,
                                                            '6'                                           => 6,
                                                            default                                       => 1,
                                                        }),
                                                ]),
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
