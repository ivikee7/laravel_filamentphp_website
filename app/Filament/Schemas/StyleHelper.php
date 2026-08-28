<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class StyleHelper
{
    public static function makeBoxStyleGroup(): array
    {
        return self::getBordersAndEffectsGroup();
    }

    public static function makeBackgroundGroup(): array
    {
        return self::getBackgroundGroup();
    }

    /**
     * Master Universal Style Tabs Engine
     */
    public static function makeStyleEngine(string $statePath = 'styles'): Group
    {
        return Group::make()
            ->statePath($statePath)
            ->schema([
                Tabs::make('Style & Visual Architecture')
                    ->tabs([
                        Tab::make('Spacing & Layout')
                            ->icon('heroicon-o-arrows-pointing-out')
                            ->schema(self::getSpacingAndLayoutGroup()),

                        Tab::make('Typography')
                            ->icon('heroicon-o-language')
                            ->schema(self::getTypographyGroup()),

                        Tab::make('Background & Layers')
                            ->icon('heroicon-o-paint-brush')
                            ->schema(self::getBackgroundGroup()),

                        Tab::make('Borders & Surfaces')
                            ->icon('heroicon-o-sparkles')
                            ->schema(self::getBordersAndEffectsGroup()),

                        Tab::make('Motion & Animations')
                            ->icon('heroicon-o-bolt')
                            ->schema(self::getAnimationGroup()),

                        Tab::make('Advanced & Responsive')
                            ->icon('heroicon-o-device-phone-mobile')
                            ->schema(self::getAdvancedResponsiveGroup()),
                    ]),
            ]);
    }

    /**
     * 1. Spacing, Padding, Margins & Container Alignment
     */
    public static function getSpacingAndLayoutGroup(): array
    {
        return [
            Section::make('Box Model Spacing')
                ->description('Configure inside (padding) and outside (margin) whitespace.')
                ->schema([
                    Grid::make(4)->schema([
                        Select::make('padding_y')
                            ->label('Vertical Padding (Y)')
                            ->options([
                                'py-0'  => 'None (0px)',
                                'py-4'  => 'Compact (16px)',
                                'py-8'  => 'Standard (32px)',
                                'py-16' => 'Spacious (64px)',
                                'py-24' => 'Hero (96px)',
                                'py-32' => 'Massive (128px)',
                            ])->default('py-8'),

                        Select::make('padding_x')
                            ->label('Horizontal Padding (X)')
                            ->options([
                                'px-0'  => 'None (0px)',
                                'px-4'  => 'Small (16px)',
                                'px-8'  => 'Medium (32px)',
                                'px-12' => 'Large (48px)',
                            ])->default('px-4'),

                        Select::make('margin_top')
                            ->label('Margin Top')
                            ->options([
                                'mt-0'   => 'None (0px)',
                                'mt-4'   => 'Small (16px)',
                                'mt-8'   => 'Medium (32px)',
                                'mt-16'  => 'Large (64px)',
                                '-mt-8'  => 'Overlap Up (-32px)',
                                '-mt-16' => 'Deep Overlap (-64px)',
                            ])->default('mt-0'),

                        Select::make('margin_bottom')
                            ->label('Margin Bottom')
                            ->options([
                                'mb-0'  => 'None (0px)',
                                'mb-4'  => 'Small (16px)',
                                'mb-8'  => 'Medium (32px)',
                                'mb-16' => 'Large (64px)',
                            ])->default('mb-0'),
                    ]),
                ]),

            Section::make('Container Width & Alignment')
                ->collapsible()
                ->collapsed()
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('max_width')
                            ->label('Container Max Width')
                            ->options([
                                'max-w-none'  => 'Full Screen / 100% Fluid',
                                'max-w-7xl'   => 'Standard Container (1280px)',
                                'max-w-5xl'   => 'Compact Container (1024px)',
                                'max-w-3xl'   => 'Narrow Reading Width (768px)',
                                'max-w-prose' => 'Editorial Article (65ch)',
                            ])->default('max-w-7xl'),

                        Select::make('alignment')
                            ->label('Horizontal Placement')
                            ->options([
                                'mx-auto' => 'Center Aligned (mx-auto)',
                                'mr-auto' => 'Left Aligned (mr-auto)',
                                'ml-auto' => 'Right Aligned (ml-auto)',
                            ])->default('mx-auto'),

                        Select::make('content_gap')
                            ->label('Element Child Gap')
                            ->options([
                                'gap-2'  => 'Compact (8px)',
                                'gap-4'  => 'Regular (16px)',
                                'gap-8'  => 'Wide (32px)',
                                'gap-12' => 'Extra Wide (48px)',
                            ])->default('gap-4'),
                    ]),
                ]),
        ];
    }

    /**
     * 2. Typography Engine
     */
    public static function getTypographyGroup(): array
    {
        return [
            Grid::make(3)->schema([
                Select::make('font_family')
                    ->label('Font Family')
                    ->options([
                        'font-sans'  => 'Sans-Serif (Instrument Sans / System)',
                        'font-serif' => 'Serif (Editorial / Classic)',
                        'font-mono'  => 'Monospace (Code / Tech)',
                    ])->default('font-sans'),

                Select::make('text_align')
                    ->label('Text Alignment')
                    ->options([
                        'text-left'    => 'Left Align',
                        'text-center'  => 'Center Align',
                        'text-right'   => 'Right Align',
                        'text-justify' => 'Justified',
                    ])->default('text-left'),

                ColorPicker::make('text_color')
                    ->label('Custom Text Color'),
            ]),

            Grid::make(3)->schema([
                Select::make('font_weight')
                    ->label('Heading Weight')
                    ->options([
                        'font-normal'   => 'Normal (400)',
                        'font-medium'   => 'Medium (500)',
                        'font-semibold' => 'Semibold (600)',
                        'font-bold'     => 'Bold (700)',
                        'font-black'    => 'Ultra Black (900)',
                    ])->default('font-bold'),

                Select::make('line_height')
                    ->label('Line Height / Leading')
                    ->options([
                        'leading-tight'   => 'Tight (Titles)',
                        'leading-normal'  => 'Normal',
                        'leading-relaxed' => 'Relaxed (Readability)',
                        'leading-loose'   => 'Loose (Spaced)',
                    ])->default('leading-normal'),

                Select::make('letter_spacing')
                    ->label('Letter Spacing (Tracking)')
                    ->options([
                        'tracking-tighter' => 'Tighter (-0.05em)',
                        'tracking-normal'  => 'Normal (0)',
                        'tracking-wide'    => 'Wide (+0.025em)',
                        'tracking-widest'  => 'Widest (+0.1em uppercase)',
                    ])->default('tracking-normal'),
            ]),
        ];
    }

    /**
     * 3. Background Layers, Overlays & Patterns
     */
    public static function getBackgroundGroup(): array
    {
        return [
            Grid::make(3)->schema([
                Select::make('bg_type')
                    ->label('Background Mode')
                    ->options([
                        'transparent' => 'Transparent',
                        'color'       => 'Solid Color',
                        'gradient'    => 'CSS Linear/Radial Gradient',
                        'image'       => 'Background Image',
                        'pattern'     => 'Subtle Texture Pattern',
                    ])
                    ->default('transparent')
                    ->live(),

                ColorPicker::make('bg_color')
                    ->label('Solid Fill Color')
                    ->visible(fn ($get) => $get('bg_type') === 'color'),

                TextInput::make('bg_gradient')
                    ->label('Custom CSS Gradient')
                    ->placeholder('linear-gradient(135deg, #0f172a 0%, #1e293b 100%)')
                    ->visible(fn ($get) => $get('bg_type') === 'gradient'),

                Select::make('bg_pattern')
                    ->label('Pattern Texture')
                    ->options([
                        'dots'    => 'Radial Polka Dots',
                        'grid'    => 'Blueprint Engineering Grid',
                        'stripes' => 'Subtle Diagonal Stripes',
                    ])
                    ->visible(fn ($get) => $get('bg_type') === 'pattern'),
            ]),

            FileUpload::make('bg_image')
                ->label('Background Image File')
                ->disk('public')
                ->directory('page-builder/bg')
                ->image()
                ->imageEditor()
                ->visible(fn ($get) => $get('bg_type') === 'image'),

            Grid::make(3)->schema([
                Select::make('bg_position')
                    ->label('Image Position & Attachment')
                    ->options([
                        'bg-center bg-cover' => 'Center Cover (Standard)',
                        'bg-top bg-cover'    => 'Top Cover',
                        'bg-fixed bg-cover'  => 'Parallax Fixed Viewport',
                    ])
                    ->default('bg-center bg-cover')
                    ->visible(fn ($get) => $get('bg_type') === 'image'),

                ColorPicker::make('bg_overlay_color')
                    ->label('Color Mask Overlay')
                    ->default('#000000')
                    ->visible(fn ($get) => in_array($get('bg_type'), ['image', 'pattern'])),

                Select::make('bg_overlay_opacity')
                    ->label('Mask Opacity')
                    ->options([
                        'opacity-0'  => '0% (No overlay)',
                        'opacity-20' => '20% Soft',
                        'opacity-40' => '40% Medium',
                        'opacity-60' => '60% Dark',
                        'opacity-80' => '80% High Contrast',
                    ])
                    ->default('opacity-0')
                    ->visible(fn ($get) => in_array($get('bg_type'), ['image', 'pattern'])),
            ]),
        ];
    }

    /**
     * 4. Corner Radius, Borders, Shadows & Surface Effects
     */
    public static function getBordersAndEffectsGroup(): array
    {
        return [
            Grid::make(3)->schema([
                Select::make('border_radius')
                    ->label('Corner Radius')
                    ->options([
                        'rounded-none' => 'Square (0px)',
                        'rounded-sm'   => 'Small (2px)',
                        'rounded-lg'   => 'Standard (8px)',
                        'rounded-2xl'  => 'Modern Card (16px)',
                        'rounded-3xl'  => 'Pill Curve (24px)',
                        'rounded-full' => 'Fully Round / Circle',
                    ])->default('rounded-none'),

                Select::make('border_width')
                    ->label('Border Width')
                    ->options([
                        'border-0' => '0px (None)',
                        'border'   => '1px Solid',
                        'border-2' => '2px Bold',
                        'border-4' => '4px Heavy',
                    ])->default('border-0'),

                ColorPicker::make('border_color')
                    ->label('Border Color'),
            ]),

            Grid::make(2)->schema([
                Select::make('shadow')
                    ->label('Drop Shadow & Elevation')
                    ->options([
                        'shadow-none'  => 'None',
                        'shadow-sm'    => 'Subtle Soft',
                        'shadow-md'    => 'Card Elevation',
                        'shadow-xl'    => 'High Lift (XL)',
                        'shadow-2xl'   => 'Floating (2XL)',
                        'shadow-inner' => 'Inner Bevel',
                    ])->default('shadow-none'),

                Select::make('backdrop_blur')
                    ->label('Frosted Glass (Backdrop Blur)')
                    ->options([
                        'backdrop-blur-none' => 'None',
                        'backdrop-blur-sm'   => 'Soft Blur (4px)',
                        'backdrop-blur-md'   => 'Glassmorphic Medium (12px)',
                        'backdrop-blur-xl'   => 'Deep Frosted (24px)',
                    ])->default('backdrop-blur-none'),
            ]),
        ];
    }

    /**
     * 5. Universal Motion & Animations (Scroll Reveals, Ambient Loops, Hover)
     */
    public static function getAnimationGroup(): array
    {
        return [
            Section::make('Scroll-Triggered Entry Reveal')
                ->description('Triggers smooth entry animation when the element enters viewport.')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('entry_animation')
                            ->label('Scroll Reveal Animation')
                            ->options([
                                'none'        => 'None (Static)',
                                'fade-in'     => 'Fade In',
                                'slide-up'    => 'Slide Upward',
                                'slide-down'  => 'Slide Downward',
                                'slide-left'  => 'Slide In from Left',
                                'slide-right' => 'Slide In from Right',
                                'zoom-in'     => 'Zoom Scale In',
                                'zoom-out'    => 'Zoom Scale Out',
                                'flip-up'     => '3D Flip Upward',
                            ])
                            ->default('none'),

                        Select::make('animation_duration')
                            ->label('Transition Duration')
                            ->options([
                                'duration-300'  => 'Fast (300ms)',
                                'duration-700'  => 'Smooth Standard (700ms)',
                                'duration-1000' => 'Deliberate (1000ms)',
                                'duration-1500' => 'Cinematic Slow (1500ms)',
                            ])
                            ->default('duration-700'),

                        Select::make('animation_delay')
                            ->label('Stagger Delay')
                            ->options([
                                'delay-0'    => 'Immediate (0ms)',
                                'delay-150'  => '150ms Stagger',
                                'delay-300'  => '300ms Stagger',
                                'delay-500'  => '500ms Stagger',
                                'delay-700'  => '700ms Stagger',
                                'delay-1000' => '1000ms Stagger',
                            ])
                            ->default('delay-0'),
                    ]),
                ]),

            Section::make('Continuous Loop & Micro-Interactions')
                ->description('Continuous ambient motion and cursor interaction effects.')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('loop_animation')
                            ->label('Continuous Ambient Loop')
                            ->options([
                                'none'               => 'None',
                                'animate-float'      => 'Gentle Floating Wave (Y-Axis)',
                                'animate-pulse-glow' => 'Rhythmic Soft Pulse',
                                'animate-spin-slow'  => 'Slow 360° Infinite Rotation',
                                'animate-shimmer'    => 'Metallic Light Shimmer Sweep',
                                'animate-bounce'     => 'Tailwind Bounce',
                            ])
                            ->default('none'),

                        Select::make('hover_effect')
                            ->label('Hover Micro-Interaction')
                            ->options([
                                'hover:none'                     => 'None',
                                'hover:-translate-y-2'           => 'Elevate Up (-8px)',
                                'hover:scale-[1.03]'             => 'Scale Zoom (+3%)',
                                'hover:shadow-2xl'               => 'Deep Drop Shadow Glow',
                                'hover:brightness-110'           => 'Lighten Surface',
                                'hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl' => 'Composite Lift & Glow Card',
                            ])
                            ->default('hover:none'),
                    ]),
                ]),
        ];
    }

    /**
     * 6. Custom CSS & Device Viewport Visibility
     */
    public static function getAdvancedResponsiveGroup(): array
    {
        return [
            Section::make('Responsive Breakpoint Visibility')
                ->description('Control which devices this block renders on.')
                ->schema([
                    Grid::make(3)->schema([
                        Toggle::make('hide_on_mobile')
                            ->label('Hide on Mobile (<640px)')
                            ->default(false),

                        Toggle::make('hide_on_tablet')
                            ->label('Hide on Tablet (640px-1024px)')
                            ->default(false),

                        Toggle::make('hide_on_desktop')
                            ->label('Hide on Desktop (>1024px)')
                            ->default(false),
                    ]),
                ]),

            Section::make('Custom Inline CSS & Overrides')
                ->collapsible()
                ->collapsed()
                ->schema([
                    TextInput::make('custom_css_classes')
                        ->label('Extra Tailwind Classes')
                        ->placeholder('overflow-hidden filter grayscale'),

                    TextInput::make('custom_id')
                        ->label('HTML Element ID')
                        ->placeholder('features-section'),

                    Textarea::make('custom_inline_css')
                        ->label('Custom Raw CSS (<style>)')
                        ->placeholder('clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);')
                        ->rows(3),
                ]),
        ];
    }

    /**
     * Compile array of style values into Tailwind class string, Alpine attributes & inline CSS
     */
    public static function compileStyles(array $styles = []): array
    {
        $classes = [];
        $inlineCss = [];

        // Box & Spacing
        $classes[] = $styles['padding_y'] ?? 'py-8';
        $classes[] = $styles['padding_x'] ?? 'px-4';
        $classes[] = $styles['margin_top'] ?? 'mt-0';
        $classes[] = $styles['margin_bottom'] ?? 'mb-0';
        $classes[] = $styles['max_width'] ?? 'max-w-7xl';
        $classes[] = $styles['alignment'] ?? 'mx-auto';

        // Typography
        $classes[] = $styles['font_family'] ?? 'font-sans';
        $classes[] = $styles['text_align'] ?? 'text-left';
        $classes[] = $styles['font_weight'] ?? '';
        $classes[] = $styles['line_height'] ?? 'leading-normal';
        $classes[] = $styles['letter_spacing'] ?? 'tracking-normal';

        if (!empty($styles['text_color'])) {
            $inlineCss[] = "color: {$styles['text_color']};";
        }

        // Borders & Radius
        $classes[] = $styles['border_radius'] ?? 'rounded-none';
        $classes[] = $styles['border_width'] ?? 'border-0';
        $classes[] = $styles['shadow'] ?? 'shadow-none';
        $classes[] = $styles['backdrop_blur'] ?? 'backdrop-blur-none';
        $classes[] = $styles['hover_effect'] ?? 'hover:none';

        if (!empty($styles['border_color'])) {
            $inlineCss[] = "border-color: {$styles['border_color']};";
        }

        // Background Processing
        $bgType = $styles['bg_type'] ?? 'transparent';
        if ($bgType === 'color' && !empty($styles['bg_color'])) {
            $inlineCss[] = "background-color: {$styles['bg_color']};";
        } elseif ($bgType === 'gradient' && !empty($styles['bg_gradient'])) {
            $inlineCss[] = "background: {$styles['bg_gradient']};";
        } elseif ($bgType === 'image' && !empty($styles['bg_image'])) {
            $imageUrl = asset('storage/' . $styles['bg_image']);
            $inlineCss[] = "background-image: url('{$imageUrl}');";
            $classes[] = $styles['bg_position'] ?? 'bg-center bg-cover';
        }

        // Continuous Loop Animation
        if (!empty($styles['loop_animation']) && $styles['loop_animation'] !== 'none') {
            $classes[] = $styles['loop_animation'];
        }

        // Scroll Entry Reveal Animation Setup
        $entryAnim = $styles['entry_animation'] ?? 'none';
        $revealAttrs = '';
        if ($entryAnim !== 'none') {
            $classes[] = 'reveal-init reveal-' . $entryAnim;
            $classes[] = $styles['animation_duration'] ?? 'duration-700';
            $classes[] = $styles['animation_delay'] ?? 'delay-0';
            $revealAttrs = 'x-data="{ shown: false }" x-intersect.once.threshold.15="shown = true" :class="{ \'reveal-active\': shown }"';
        }

        // Responsive Visibility (Tailwind CSS v4 media queries)
        if (!empty($styles['hide_on_mobile']))  $classes[] = 'max-sm:hidden';
        if (!empty($styles['hide_on_tablet']))  $classes[] = 'sm:max-lg:hidden';
        if (!empty($styles['hide_on_desktop'])) $classes[] = 'lg:hidden';

        // Custom Classes & Inline CSS
        if (!empty($styles['custom_css_classes'])) $classes[] = $styles['custom_css_classes'];
        if (!empty($styles['custom_inline_css']))  $inlineCss[] = $styles['custom_inline_css'];

        return [
            'classes'     => implode(' ', array_filter($classes)),
            'inlineCss'   => implode(' ', array_filter($inlineCss)),
            'revealAttrs' => $revealAttrs,
            'id'          => $styles['custom_id'] ?? null,
            'overlay'     => [
                'active'  => in_array($bgType, ['image', 'pattern']),
                'color'   => $styles['bg_overlay_color'] ?? '#000000',
                'opacity' => $styles['bg_overlay_opacity'] ?? 'opacity-0',
            ],
        ];
    }
}
