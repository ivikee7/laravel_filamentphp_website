<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class StyleHelper
{
    /**
     * Complete Box Model, Spacing & Border Engine
     */
    public static function makeBoxStyleGroup(): array
    {
        return [
            Grid::make(4)->schema([
                Select::make('margin_top')
                    ->label('Margin Top')
                    ->options(['mt-0' => '0', 'mt-4' => 'Small', 'mt-8' => 'Medium', 'mt-16' => 'Large', 'mt-24' => 'XL'])
                    ->default('mt-0'),

                Select::make('margin_bottom')
                    ->label('Margin Bottom')
                    ->options(['mb-0' => '0', 'mb-4' => 'Small', 'mb-8' => 'Medium', 'mb-16' => 'Large', 'mb-24' => 'XL'])
                    ->default('mb-0'),

                Select::make('border_radius')
                    ->label('Corner Radius')
                    ->options([
                        'rounded-none' => 'Square (0px)',
                        'rounded-sm'   => 'Small (2px)',
                        'rounded-md'   => 'Medium (6px)',
                        'rounded-xl'   => 'Large (12px)',
                        'rounded-3xl'  => 'Extra Large (24px)',
                        'rounded-full' => 'Fully Rounded / Pill',
                    ])
                    ->default('rounded-none'),

                Select::make('shadow')
                    ->label('Drop Shadow')
                    ->options([
                        'shadow-none' => 'None',
                        'shadow-sm'   => 'Soft Small',
                        'shadow-md'   => 'Regular',
                        'shadow-lg'   => 'Large',
                        'shadow-2xl'  => 'Elevated (2XL)',
                    ])
                    ->default('shadow-none'),
            ]),

            Grid::make(3)->schema([
                ColorPicker::make('border_color')->label('Border Color'),
                Select::make('border_width')
                    ->label('Border Width')
                    ->options(['border-0' => '0px', 'border' => '1px', 'border-2' => '2px', 'border-4' => '4px', 'border-8' => '8px'])
                    ->default('border-0'),
                Select::make('hover_effect')
                    ->label('Hover Micro-Interactions')
                    ->options([
                        'hover:none'           => 'None',
                        'hover:-translate-y-2'  => 'Elevate Up',
                        'hover:scale-[1.03]'   => 'Scale Zoom',
                        'hover:brightness-110' => 'Lighten Brightness',
                        'hover:opacity-80'     => 'Soft Dissolve',
                    ])
                    ->default('hover:none'),
            ]),
        ];
    }

    /**
     * Universal Layer Background Engine
     */
    public static function makeBackgroundGroup(): array
    {
        return [
            Grid::make(3)->schema([
                Select::make('bg_type')
                    ->label('Background Layer Type')
                    ->options([
                        'transparent' => 'Transparent',
                        'color'       => 'Solid Color',
                        'gradient'    => 'CSS Gradient',
                        'image'       => 'Background Image',
                    ])
                    ->default('transparent'),

                ColorPicker::make('bg_color')
                    ->label('Solid Fill Color')
                    ->visible(fn ($get) => $get('bg_type') === 'color'),

                TextInput::make('bg_gradient')
                    ->label('CSS Gradient Code')
                    ->placeholder('linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%)')
                    ->visible(fn ($get) => $get('bg_type') === 'gradient'),
            ]),

            FileUpload::make('bg_image')
                ->label('Background Image File')
                ->disk('public')
                ->directory('page-builder/bg')
                ->image()
                ->visible(fn ($get) => $get('bg_type') === 'image'),

            Grid::make(2)->schema([
                ColorPicker::make('bg_overlay_color')
                    ->label('Image Overlay Mask Color')
                    ->visible(fn ($get) => $get('bg_type') === 'image'),

                Select::make('bg_overlay_opacity')
                    ->label('Overlay Mask Opacity')
                    ->options([
                        'opacity-0'  => '0%',
                        'opacity-20' => '20%',
                        'opacity-40' => '40%',
                        'opacity-60' => '60%',
                        'opacity-80' => '80%',
                    ])
                    ->default('opacity-0')
                    ->visible(fn ($get) => $get('bg_type') === 'image'),
            ]),
        ];
    }
}
