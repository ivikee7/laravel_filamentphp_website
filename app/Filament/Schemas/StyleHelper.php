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
use Filament\Forms\Components\ToggleButtons;

class StyleHelper
{
    /**
     * Master Universal Visual & Architecture Engine
     */
    public static function makeStyleEngine(string $statePath = 'styles'): Group
    {
        return Group::make()
            ->statePath($statePath)
            ->schema([
                Tabs::make('Block Style & Visual Architecture')
                    ->schema([
                        Tab::make('Layout & Spacing')
                            ->icon('heroicon-o-arrows-pointing-out')
                            ->schema(self::getSpacingAndLayoutGroup()),

                        Tab::make('Typography')
                            ->icon('heroicon-o-language')
                            ->schema(self::getTypographyGroup()),

                        Tab::make('Backgrounds')
                            ->icon('heroicon-o-paint-brush')
                            ->schema(self::getBackgroundFields()),

                        Tab::make('Borders & Surfaces')
                            ->icon('heroicon-o-sparkles')
                            ->schema(self::getBordersAndEffectsGroup()),

                        Tab::make('Motion & FX')
                            ->icon('heroicon-o-bolt')
                            ->schema(self::getAnimationGroup()),

                        Tab::make('Advanced & Custom Code')
                            ->icon('heroicon-o-code-bracket')
                            ->schema(self::getAdvancedResponsiveGroup()),
                    ]),
            ]);
    }

    /**
     * 1. Layout, Spacing, Container Constraints & Display
     */
    public static function getSpacingAndLayoutGroup(): array
    {
        return [
            Section::make('Container Width & Placement')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('max_width')
                            ->label('Container Max Width')
                            ->options([
                                'max-w-none'  => '100% Fluid / Full Screen',
                                'max-w-7xl'   => 'Standard Wide (1280px)',
                                'max-w-6xl'   => 'Regular (1152px)',
                                'max-w-5xl'   => 'Compact Container (1024px)',
                                'max-w-4xl'   => 'Reading Focus (896px)',
                                'max-w-3xl'   => 'Narrow Article (768px)',
                                'max-w-prose' => 'Editorial Prose (65ch)',
                            ])->default('max-w-7xl'),

                        Select::make('alignment')
                            ->label('Horizontal Placement')
                            ->options([
                                'mx-auto' => 'Center (mx-auto)',
                                'mr-auto' => 'Left Aligned (mr-auto)',
                                'ml-auto' => 'Right Aligned (ml-auto)',
                            ])->default('mx-auto'),

                        Select::make('content_gap')
                            ->label('Child Gap Spacing')
                            ->options([
                                'gap-0'  => 'None (0px)',
                                'gap-2'  => 'Tight (8px)',
                                'gap-4'  => 'Standard (16px)',
                                'gap-6'  => 'Medium (24px)',
                                'gap-8'  => 'Large (32px)',
                                'gap-12' => 'Extra Large (48px)',
                                'gap-16' => 'Massive (64px)',
                            ])->default('gap-6'),
                    ]),
                ]),

            Section::make('Inside Padding Whitespace')
                ->description('Configure individual top/bottom and horizontal padding.')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('padding_top')
                            ->label('Padding Top')
                            ->options([
                                'pt-0'  => '0px',
                                'pt-4'  => '16px',
                                'pt-8'  => '32px',
                                'pt-12' => '48px',
                                'pt-16' => '64px',
                                'pt-24' => '96px (Hero Top)',
                                'pt-32' => '128px',
                            ])->default('pt-8'),

                        Select::make('padding_bottom')
                            ->label('Padding Bottom')
                            ->options([
                                'pb-0'  => '0px',
                                'pb-4'  => '16px',
                                'pb-8'  => '32px',
                                'pb-12' => '48px',
                                'pb-16' => '64px',
                                'pb-24' => '96px',
                                'pb-32' => '128px',
                            ])->default('pb-8'),

                        Select::make('padding_x')
                            ->label('Horizontal Padding (X)')
                            ->options([
                                'px-0'  => '0px',
                                'px-4'  => '16px (Mobile Default)',
                                'px-6'  => '24px',
                                'px-8'  => '32px (Desktop Default)',
                                'px-12' => '48px',
                                'px-16' => '64px',
                            ])->default('px-4'),
                    ]),
                ]),

            Section::make('Outside Margin Whitespace')
                ->collapsible()
                ->collapsed()
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('margin_top')
                            ->label('Margin Top')
                            ->options([
                                'mt-0'   => 'None (0px)',
                                'mt-4'   => 'Small (16px)',
                                'mt-8'   => 'Medium (32px)',
                                'mt-12'  => 'Large (48px)',
                                'mt-16'  => 'Extra Large (64px)',
                                'mt-24'  => 'Massive (96px)',
                                '-mt-8'  => 'Overlap Up (-32px)',
                                '-mt-16' => 'Deep Overlap (-64px)',
                            ])->default('mt-0'),

                        Select::make('margin_bottom')
                            ->label('Margin Bottom')
                            ->options([
                                'mb-0'  => 'None (0px)',
                                'mb-4'  => 'Small (16px)',
                                'mb-8'  => 'Medium (32px)',
                                'mb-12' => 'Large (48px)',
                                'mb-16' => 'Extra Large (64px)',
                                'mb-24' => 'Massive (96px)',
                            ])->default('mb-0'),
                    ]),
                ]),
        ];
    }

    /**
     * 2. Typography, Headings, Text Colors & Formats
     */
    public static function getTypographyGroup(): array
    {
        return [
            Section::make('Font Family & Alignment')
                ->schema([
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
                            ->label('Custom Text Color (Overrides Theme)'),
                    ]),
                ]),

            Section::make('Heading & Body Scale')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('font_size')
                            ->label('Base Text Scale')
                            ->options([
                                'text-xs'  => 'Extra Small (12px)',
                                'text-sm'  => 'Small (14px)',
                                'text-base'=> 'Normal (16px)',
                                'text-lg'  => 'Large (18px)',
                                'text-xl'  => 'Lead Article (20px)',
                            ])->default('text-base'),

                        Select::make('font_weight')
                            ->label('Font Weight')
                            ->options([
                                'font-light'    => 'Light (300)',
                                'font-normal'   => 'Regular (400)',
                                'font-medium'   => 'Medium (500)',
                                'font-semibold' => 'Semibold (600)',
                                'font-bold'     => 'Bold (700)',
                                'font-extrabold'=> 'Extra Bold (800)',
                                'font-black'    => 'Ultra Black (900)',
                            ])->default('font-normal'),

                        Select::make('line_height')
                            ->label('Line Leading')
                            ->options([
                                'leading-none'    => 'Tightest (1.0)',
                                'leading-tight'   => 'Tight (1.25)',
                                'leading-snug'    => 'Snug (1.375)',
                                'leading-normal'  => 'Normal (1.5)',
                                'leading-relaxed' => 'Relaxed (1.625)',
                                'leading-loose'   => 'Loose (2.0)',
                            ])->default('leading-relaxed'),
                    ]),

                    Grid::make(2)->schema([
                        Select::make('letter_spacing')
                            ->label('Letter Spacing (Tracking)')
                            ->options([
                                'tracking-tighter' => 'Tighter (-0.05em)',
                                'tracking-tight'   => 'Tight (-0.025em)',
                                'tracking-normal'  => 'Normal (0)',
                                'tracking-wide'    => 'Wide (+0.025em)',
                                'tracking-wider'   => 'Wider (+0.05em)',
                                'tracking-widest'  => 'Widest (+0.1em)',
                            ])->default('tracking-normal'),

                        Select::make('text_transform')
                            ->label('Text Transform')
                            ->options([
                                'normal-case' => 'Normal Text',
                                'uppercase'   => 'UPPERCASE',
                                'lowercase'   => 'lowercase',
                                'capitalize'  => 'Capitalize Words',
                            ])->default('normal-case'),
                    ]),
                ]),
        ];
    }

    /**
     * 3. Multi-layer Backgrounds, Patterns, Gradients & Images
     */
    public static function getBackgroundFields(): array
    {
        return [
            Section::make('Background Canvas Mode')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('bg_type')
                            ->label('Background Layer')
                            ->options([
                                'transparent' => 'Transparent / Inherit Theme',
                                'color'       => 'Solid Color Fill',
                                'gradient'    => 'CSS Gradient Preset / Custom',
                                'image'       => 'High-Res Background Image',
                                'pattern'     => 'Subtle Texture Pattern',
                            ])
                            ->default('transparent')
                            ->live(),

                        ColorPicker::make('bg_color')
                            ->label('Solid Fill Hex/RGB')
                            ->visible(fn ($get) => $get('bg_type') === 'color'),

                        Select::make('bg_gradient_preset')
                            ->label('Gradient Preset')
                            ->options([
                                'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)'  => 'Deep Slate Gradient',
                                'linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%)'  => 'Midnight Blue Navy',
                                'linear-gradient(135deg, #2563eb 0%, #7c3aed 100%)'  => 'Blue & Indigo Electric',
                                'linear-gradient(135deg, #0f172a 0%, #030712 100%)'  => 'Pure Dark Stealth',
                                'custom'                                              => 'Custom CSS String...',
                            ])
                            ->visible(fn ($get) => $get('bg_type') === 'gradient')
                            ->live(),

                        TextInput::make('bg_gradient_custom')
                            ->label('Custom Gradient CSS')
                            ->placeholder('radial-gradient(circle, #2563eb 0%, #0f172a 100%)')
                            ->visible(fn ($get) => $get('bg_type') === 'gradient' && $get('bg_gradient_preset') === 'custom'),

                        Select::make('bg_pattern')
                            ->label('Texture Pattern')
                            ->options([
                                'dots'    => 'Radial Polka Dots',
                                'grid'    => 'Engineering Blueprint Grid',
                                'stripes' => 'Diagonal Subtle Stripes',
                            ])
                            ->visible(fn ($get) => $get('bg_type') === 'pattern'),
                    ]),

                    FileUpload::make('bg_image')
                        ->label('Background Image')
                        ->disk('public')
                        ->directory('page-builder/bg')
                        ->image()
                        ->imageEditor()
                        ->visible(fn ($get) => $get('bg_type') === 'image'),

                    Grid::make(3)->schema([
                        Select::make('bg_position')
                            ->label('Image Fit & Viewport')
                            ->options([
                                'bg-center bg-cover' => 'Center Cover (Standard)',
                                'bg-top bg-cover'    => 'Top Cover',
                                'bg-fixed bg-cover'  => 'Parallax Viewport Fixed',
                                'bg-center bg-contain bg-no-repeat' => 'Contain (No Repeat)',
                            ])
                            ->default('bg-center bg-cover')
                            ->visible(fn ($get) => $get('bg_type') === 'image'),

                        ColorPicker::make('bg_overlay_color')
                            ->label('Contrast Color Mask')
                            ->default('#000000')
                            ->visible(fn ($get) => in_array($get('bg_type'), ['image', 'pattern'])),

                        Select::make('bg_overlay_opacity')
                            ->label('Mask Intensity')
                            ->options([
                                'opacity-0'  => '0% (No Overlay)',
                                'opacity-20' => '20% Soft Tint',
                                'opacity-40' => '40% Medium Dim',
                                'opacity-60' => '60% Dark Contrast',
                                'opacity-80' => '80% Heavy Mask',
                                'opacity-90' => '90% Stealth Mask',
                            ])
                            ->default('opacity-0')
                            ->visible(fn ($get) => in_array($get('bg_type'), ['image', 'pattern'])),
                    ]),
                ]),
        ];
    }

    /**
     * 4. Corner Radius, Borders, Drop Shadows & Frosted Glass
     */
    public static function getBordersAndEffectsGroup(): array
    {
        return [
            Section::make('Surface Curves & Borders')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('border_radius')
                            ->label('Corner Curvature')
                            ->options([
                                'rounded-none' => 'Square (0px)',
                                'rounded-md'   => 'Subtle (6px)',
                                'rounded-xl'   => 'Standard Modern (12px)',
                                'rounded-2xl'  => 'Card Curve (16px)',
                                'rounded-3xl'  => 'Floating Pill (24px)',
                                'rounded-full' => 'Circular / Pill',
                            ])->default('rounded-none'),

                        Select::make('border_width')
                            ->label('Border Width')
                            ->options([
                                'border-0' => '0px (None)',
                                'border'   => '1px Solid',
                                'border-2' => '2px Bold',
                                'border-4' => '4px Heavy Accent',
                            ])->default('border-0'),

                        ColorPicker::make('border_color')
                            ->label('Custom Border Color'),
                    ]),
                ]),

            Section::make('Shadows & Glassmorphism')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('shadow')
                            ->label('Drop Shadow & Elevation')
                            ->options([
                                'shadow-none'  => 'None (Flat)',
                                'shadow-sm'    => 'Subtle Card Elevation',
                                'shadow-md'    => 'Medium Elevation',
                                'shadow-xl'    => 'High Float Lift (XL)',
                                'shadow-2xl'   => 'Dramatic Ambient Glow (2XL)',
                                'shadow-inner' => 'Recessed Inner Shadow',
                            ])->default('shadow-none'),

                        Select::make('backdrop_blur')
                            ->label('Glassmorphic Backdrop Blur')
                            ->options([
                                'backdrop-blur-none' => 'None (Opaque/Clear)',
                                'backdrop-blur-sm'   => 'Subtle Blur (4px)',
                                'backdrop-blur-md'   => 'Medium Glass (12px)',
                                'backdrop-blur-xl'   => 'Deep Frosted Glass (24px)',
                            ])->default('backdrop-blur-none'),
                    ]),
                ]),
        ];
    }

    /**
     * 5. Motion, Scroll Trigger Animations & Continuous Keyframes
     */
    public static function getAnimationGroup(): array
    {
        return [
            Section::make('Scroll-Triggered Viewport Entry')
                ->description('Smooth transition triggered via Alpine Intersect when scrolled into view.')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('entry_animation')
                            ->label('Entry Reveal Effect')
                            ->options([
                                'none'        => 'None (Static)',
                                'fade-in'     => 'Fade In',
                                'slide-up'    => 'Slide Upward (+Y)',
                                'slide-down'  => 'Slide Downward (-Y)',
                                'slide-left'  => 'Slide In from Left',
                                'slide-right' => 'Slide In from Right',
                                'zoom-in'     => 'Zoom Scale In',
                                'zoom-out'    => 'Zoom Scale Out',
                                'flip-up'     => '3D Perspective Flip Up',
                            ])
                            ->default('none'),

                        Select::make('animation_duration')
                            ->label('Animation Speed')
                            ->options([
                                'duration-300'  => 'Fast (300ms)',
                                'duration-500'  => 'Quick (500ms)',
                                'duration-700'  => 'Standard Smooth (700ms)',
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

            Section::make('Continuous Loops & Hover Interactions')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('loop_animation')
                            ->label('Ambient Keyframe Loop')
                            ->options([
                                'none'               => 'None',
                                'animate-float'      => 'Gentle Floating Wave (Y-Axis)',
                                'animate-pulse-glow' => 'Rhythmic Soft Glow Pulse',
                                'animate-spin-slow'  => 'Slow 360° Infinite Rotation',
                                'animate-bounce'     => 'Tailwind Bounce',
                            ])
                            ->default('none'),

                        Select::make('hover_effect')
                            ->label('Hover Micro-Interaction')
                            ->options([
                                'hover:none'                     => 'None',
                                'hover:-translate-y-2'           => 'Elevate Up (-8px)',
                                'hover:scale-[1.02]'             => 'Micro Zoom Scale (+2%)',
                                'hover:scale-[1.05]'             => 'Medium Zoom Scale (+5%)',
                                'hover:shadow-2xl'               => 'Deep Ambient Shadow Glow',
                                'hover:-translate-y-2 hover:scale-[1.02] hover:shadow-2xl' => 'Composite Lift + Glow Card',
                            ])
                            ->default('hover:none'),
                    ]),
                ]),
        ];
    }

    /**
     * 6. Device Breakpoint Visibility & Custom Injected Code
     */
    public static function getAdvancedResponsiveGroup(): array
    {
        return [
            Section::make('Device Viewport Display')
                ->description('Toggle visibility per responsive viewport breakpoint.')
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

            Section::make('Custom CSS Injection & Attributes')
                ->collapsible()
                ->collapsed()
                ->schema([
                    TextInput::make('custom_css_classes')
                        ->label('Extra Tailwind Classes')
                        ->placeholder('overflow-hidden filter grayscale'),

                    TextInput::make('custom_id')
                        ->label('HTML Element ID (#id)')
                        ->placeholder('executive-leadership-section'),

                    Textarea::make('custom_inline_css')
                        ->label('Raw CSS Injected String')
                        ->placeholder('clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);')
                        ->rows(3),
                ]),
        ];
    }

    /**
     * Master Style Compiler Engine
     */
    public static function compileStyles(array $styles = []): array
    {
        $classes = [];
        $inlineCss = [];

        // 1. Spacing & Container Constraints
        $classes[] = $styles['padding_top'] ?? 'pt-8';
        $classes[] = $styles['padding_bottom'] ?? 'pb-8';
        $classes[] = $styles['padding_x'] ?? 'px-4';
        $classes[] = $styles['margin_top'] ?? 'mt-0';
        $classes[] = $styles['margin_bottom'] ?? 'mb-0';
        $classes[] = $styles['max_width'] ?? 'max-w-7xl';
        $classes[] = $styles['alignment'] ?? 'mx-auto';
        if (!empty($styles['content_gap'])) $classes[] = $styles['content_gap'];

        // 2. Typography
        $classes[] = $styles['font_family'] ?? 'font-sans';
        $classes[] = $styles['text_align'] ?? 'text-left';
        $classes[] = $styles['font_size'] ?? 'text-base';
        if (!empty($styles['font_weight'])) $classes[] = $styles['font_weight'];
        $classes[] = $styles['line_height'] ?? 'leading-relaxed';
        $classes[] = $styles['letter_spacing'] ?? 'tracking-normal';
        $classes[] = $styles['text_transform'] ?? 'normal-case';

        if (!empty($styles['text_color'])) {
            $inlineCss[] = "color: {$styles['text_color']};";
        }

        // 3. Borders & Surfaces
        $classes[] = $styles['border_radius'] ?? 'rounded-none';
        $classes[] = $styles['border_width'] ?? 'border-0';
        $classes[] = $styles['shadow'] ?? 'shadow-none';
        $classes[] = $styles['backdrop_blur'] ?? 'backdrop-blur-none';

        if (!empty($styles['hover_effect']) && $styles['hover_effect'] !== 'hover:none') {
            $classes[] = $styles['hover_effect'];
            $classes[] = 'transition-all duration-200';
        }

        if (!empty($styles['border_color'])) {
            $inlineCss[] = "border-color: {$styles['border_color']};";
        }

        // 4. Background Processing
        $bgType = $styles['bg_type'] ?? 'transparent';
        if ($bgType === 'color' && !empty($styles['bg_color'])) {
            $inlineCss[] = "background-color: {$styles['bg_color']};";
        } elseif ($bgType === 'gradient') {
            $gradient = ($styles['bg_gradient_preset'] ?? '') === 'custom'
                ? ($styles['bg_gradient_custom'] ?? '')
                : ($styles['bg_gradient_preset'] ?? '');
            if (!empty($gradient)) {
                $inlineCss[] = "background: {$gradient};";
            }
        } elseif ($bgType === 'image' && !empty($styles['bg_image'])) {
            $imageUrl = asset('storage/' . $styles['bg_image']);
            $inlineCss[] = "background-image: url('{$imageUrl}');";
            $classes[] = $styles['bg_position'] ?? 'bg-center bg-cover';
        } elseif ($bgType === 'pattern' && !empty($styles['bg_pattern'])) {
            $classes[] = 'bg-pattern-' . $styles['bg_pattern'];
        }

        // 5. Continuous Keyframe Loop
        if (!empty($styles['loop_animation']) && $styles['loop_animation'] !== 'none') {
            $classes[] = $styles['loop_animation'];
        }

        // 6. Scroll Entry Reveal (Alpine.js + @alpinejs/intersect)
        $entryAnim = $styles['entry_animation'] ?? 'none';
        $revealAttrs = '';
        if ($entryAnim !== 'none') {
            $classes[] = 'reveal-init reveal-' . $entryAnim;
            $classes[] = $styles['animation_duration'] ?? 'duration-700';
            $classes[] = $styles['animation_delay'] ?? 'delay-0';
            $revealAttrs = 'x-data="{ shown: false }" x-intersect.once.threshold.15="shown = true" :class="{ \'reveal-active\': shown }"';
        }

        // 7. Viewport Responsive Display Visibility
        if (!empty($styles['hide_on_mobile']))  $classes[] = 'hidden sm:block';
        if (!empty($styles['hide_on_tablet']))  $classes[] = 'sm:hidden lg:block';
        if (!empty($styles['hide_on_desktop'])) $classes[] = 'lg:hidden';

        // 8. Custom Classes & Inline CSS Strings
        if (!empty($styles['custom_css_classes'])) $classes[] = $styles['custom_css_classes'];
        if (!empty($styles['custom_inline_css']))  $inlineCss[] = $styles['custom_inline_css'];

        return [
            'classes'     => trim(implode(' ', array_filter($classes))),
            'inlineCss'   => trim(implode(' ', array_filter($inlineCss))),
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
