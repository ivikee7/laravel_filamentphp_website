<?php

namespace App\Filament\Schemas;

use Filament\Actions\Action;
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
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;

class StyleHelper
{
    /**
     * Master Style Defaults Map
     */
    public static function getDefaultStyles(): array
    {
        return [
            // Dimensions & Spacing
            'max_width' => 'full',
            'alignment' => 'mx-auto',
            'content_gap' => 'gap-0',
            'custom_min_height' => null,
            'overflow' => 'overflow-visible',
            'z_index' => 'z-auto',
            'padding_top_custom' => null,
            'padding_bottom_custom' => null,
            'padding_left_custom' => null,
            'padding_right_custom' => null,
            'padding_top' => 'pt-0',
            'padding_bottom' => 'pb-0',
            'padding_x' => 'px-0',
            'margin_top_custom' => null,
            'margin_bottom_custom' => null,
            'margin_left_custom' => null,
            'margin_right_custom' => null,
            'margin_top' => 'mt-0',
            'margin_bottom' => 'mb-0',

            // Typography
            'font_family' => 'font-sans',
            'text_align' => 'text-left',
            'font_size' => 'text-base',
            'font_weight' => 'font-normal',
            'line_height' => 'leading-normal',
            'letter_spacing' => 'tracking-normal',
            'text_transform' => 'normal-case',
            'custom_font_size' => null,
            'text_color' => null,

            // Backgrounds
            'bg_type' => 'transparent',
            'bg_color' => null,
            'bg_gradient_preset' => null,
            'bg_gradient_custom' => null,
            'bg_pattern' => null,
            'bg_image' => null,
            'bg_position' => 'bg-center bg-cover',
            'bg_overlay_color' => '#000000',
            'bg_overlay_opacity' => 'opacity-0',

            // Borders & Surfaces
            'border_radius' => 'rounded-none',
            'border_width' => 'border-0',
            'border_style' => 'border-solid',
            'border_color' => null,
            'shadow' => 'shadow-none',
            'backdrop_blur' => 'backdrop-blur-none',
            'opacity' => 'opacity-100',

            // Motion & FX
            'entry_animation' => 'none',
            'animation_duration' => 'duration-700',
            'animation_delay' => 'delay-0',
            'loop_animation' => 'none',
            'hover_effect' => 'hover:none',

            // Responsive & Custom Code
            'hide_on_mobile' => false,
            'hide_on_tablet' => false,
            'hide_on_desktop' => false,
            'custom_css_classes' => null,
            'custom_id' => null,
            'custom_inline_css' => null,
        ];
    }

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
                        Tab::make('Dimensions & Spacing')
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
                                'full'        => '100% Fluid / Full Screen',
                                'max-w-7xl'   => 'Standard Wide (1280px)',
                                'max-w-6xl'   => 'Regular (1152px)',
                                'max-w-5xl'   => 'Compact Container (1024px)',
                                'max-w-4xl'   => 'Reading Focus (896px)',
                                'max-w-3xl'   => 'Narrow Article (768px)',
                                'max-w-prose' => 'Editorial Prose (65ch)',
                            ])->default('full'),

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
                            ])->default('gap-0'),
                    ]),

                    Grid::make(3)->schema([
                        TextInput::make('custom_min_height')
                            ->label('Min Height (e.g. 100vh, 400px)')
                            ->placeholder('auto'),

                        Select::make('overflow')
                            ->label('Overflow')
                            ->options([
                                'overflow-visible' => 'Visible',
                                'overflow-hidden'  => 'Hidden (Clip)',
                                'overflow-auto'    => 'Auto Scroll',
                            ])->default('overflow-visible'),

                        Select::make('z_index')
                            ->label('Z-Index Layer')
                            ->options([
                                'z-auto' => 'Auto (0)',
                                'z-10'   => 'Z-10 (Elevated)',
                                'z-20'   => 'Z-20 (Dropdown/Sticky)',
                                'z-30'   => 'Z-30 (Modal/Drawer)',
                                'z-50'   => 'Z-50 (Top Layer)',
                            ])->default('z-auto'),
                    ]),
                ]),

            Section::make('Padding (Inside Whitespace)')
                ->schema([
                    Grid::make(4)->schema([
                        TextInput::make('padding_top_custom')->label('Top (e.g. 2rem, 30px)')->placeholder('0px default'),
                        TextInput::make('padding_bottom_custom')->label('Bottom (e.g. 2rem, 30px)')->placeholder('0px default'),
                        TextInput::make('padding_left_custom')->label('Left (e.g. 1rem, 15px)')->placeholder('0px default'),
                        TextInput::make('padding_right_custom')->label('Right (e.g. 1rem, 15px)')->placeholder('0px default'),
                    ]),
                    Grid::make(3)->schema([
                        Select::make('padding_top')
                            ->label('Padding Top Preset')
                            ->options([
                                'pt-0'  => '0px',
                                'pt-2'  => '8px',
                                'pt-4'  => '16px',
                                'pt-6'  => '24px',
                                'pt-8'  => '32px',
                                'pt-12' => '48px',
                                'pt-16' => '64px',
                                'pt-24' => '96px',
                                'pt-32' => '128px',
                            ])->default('pt-0'),

                        Select::make('padding_bottom')
                            ->label('Padding Bottom Preset')
                            ->options([
                                'pb-0'  => '0px',
                                'pb-2'  => '8px',
                                'pb-4'  => '16px',
                                'pb-6'  => '24px',
                                'pb-8'  => '32px',
                                'pb-12' => '48px',
                                'pb-16' => '64px',
                                'pb-24' => '96px',
                                'pb-32' => '128px',
                            ])->default('pb-0'),

                        Select::make('padding_x')
                            ->label('Horizontal Padding Preset')
                            ->options([
                                'px-0'  => '0px',
                                'px-2'  => '8px',
                                'px-4'  => '16px',
                                'px-6'  => '24px',
                                'px-8'  => '32px',
                                'px-12' => '48px',
                                'px-16' => '64px',
                            ])->default('px-0'),
                    ]),
                ]),

            Section::make('Margin (Outside Whitespace)')
                ->collapsible()
                ->collapsed()
                ->schema([
                    Grid::make(4)->schema([
                        TextInput::make('margin_top_custom')->label('Margin Top Custom'),
                        TextInput::make('margin_bottom_custom')->label('Margin Bottom Custom'),
                        TextInput::make('margin_left_custom')->label('Margin Left Custom'),
                        TextInput::make('margin_right_custom')->label('Margin Right Custom'),
                    ]),
                    Grid::make(2)->schema([
                        Select::make('margin_top')
                            ->label('Margin Top Preset')
                            ->options([
                                'mt-0'   => 'None (0px)',
                                'mt-2'   => 'Extra Small (8px)',
                                'mt-4'   => 'Small (16px)',
                                'mt-6'   => 'Medium (24px)',
                                'mt-8'   => 'Standard (32px)',
                                'mt-12'  => 'Large (48px)',
                                'mt-16'  => 'Extra Large (64px)',
                                'mt-24'  => 'Massive (96px)',
                                '-mt-4'  => 'Overlap Up (-16px)',
                                '-mt-8'  => 'Overlap Up (-32px)',
                            ])->default('mt-0'),

                        Select::make('margin_bottom')
                            ->label('Margin Bottom Preset')
                            ->options([
                                'mb-0'  => 'None (0px)',
                                'mb-2'  => 'Extra Small (8px)',
                                'mb-4'  => 'Small (16px)',
                                'mb-6'  => 'Medium (24px)',
                                'mb-8'  => 'Standard (32px)',
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
                                'font-sans'  => 'Sans-Serif (Standard)',
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
                ]),

            Section::make('Scale & Formats')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('font_size')
                            ->label('Base Text Scale')
                            ->options([
                                'text-xs'   => 'Extra Small (12px)',
                                'text-sm'   => 'Small (14px)',
                                'text-base' => 'Normal (16px)',
                                'text-lg'   => 'Large (18px)',
                                'text-xl'   => 'Lead (20px)',
                                'text-2xl'  => 'Display Small (24px)',
                                'text-3xl'  => 'Display Medium (30px)',
                                'text-4xl'  => 'Display Large (36px)',
                            ])->default('text-base'),

                        Select::make('font_weight')
                            ->label('Font Weight')
                            ->options([
                                'font-light'     => 'Light (300)',
                                'font-normal'    => 'Regular (400)',
                                'font-medium'    => 'Medium (500)',
                                'font-semibold'  => 'Semibold (600)',
                                'font-bold'      => 'Bold (700)',
                                'font-extrabold' => 'Extra Bold (800)',
                                'font-black'     => 'Ultra Black (900)',
                            ])->default('font-normal'),

                        Select::make('line_height')
                            ->label('Line Height')
                            ->options([
                                'leading-none'    => 'Tightest (1.0)',
                                'leading-tight'   => 'Tight (1.25)',
                                'leading-snug'    => 'Snug (1.375)',
                                'leading-normal'  => 'Normal (1.5)',
                                'leading-relaxed' => 'Relaxed (1.625)',
                                'leading-loose'   => 'Loose (2.0)',
                            ])->default('leading-normal'),
                    ]),

                    Grid::make(3)->schema([
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

                        TextInput::make('custom_font_size')
                            ->label('Custom CSS Font Size')
                            ->placeholder('clamp(1.5rem, 4vw, 3rem)'),
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
            Section::make('Background Canvas Layer')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('bg_type')
                            ->label('Background Layer')
                            ->options([
                                'transparent' => 'Transparent / Inherit',
                                'color'       => 'Solid Color Fill',
                                'gradient'    => 'CSS Gradient Preset / Custom',
                                'image'       => 'Background Image',
                                'pattern'     => 'Texture Pattern',
                            ])
                            ->default('transparent')
                            ->live(),

                        ColorPicker::make('bg_color')
                            ->label('Solid Fill Color')
                            ->visible(fn ($get) => $get('bg_type') === 'color'),

                        Select::make('bg_gradient_preset')
                            ->label('Gradient Preset')
                            ->options([
                                'linear-gradient(135deg, #1e293b 0%, #0f172a 100%)' => 'Deep Slate Dark',
                                'linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%)' => 'Midnight Blue Navy',
                                'linear-gradient(135deg, #2563eb 0%, #7c3aed 100%)' => 'Blue & Violet Electric',
                                'linear-gradient(135deg, #059669 0%, #047857 100%)' => 'Emerald Green Forest',
                                'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)' => 'Warm Sunset Gold',
                                'custom'                                             => 'Custom CSS String...',
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
                                'grid'    => 'Grid Lines',
                                'stripes' => 'Diagonal Stripes',
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
                            ->label('Image Fit & Position')
                            ->options([
                                'bg-center bg-cover'                => 'Center Cover (Standard)',
                                'bg-top bg-cover'                   => 'Top Cover',
                                'bg-fixed bg-cover'                 => 'Parallax Viewport Fixed',
                                'bg-center bg-contain bg-no-repeat' => 'Contain (No Repeat)',
                            ])
                            ->default('bg-center bg-cover')
                            ->visible(fn ($get) => $get('bg_type') === 'image'),

                        ColorPicker::make('bg_overlay_color')
                            ->label('Overlay Mask Color')
                            ->default('#000000')
                            ->visible(fn ($get) => in_array($get('bg_type'), ['image', 'pattern'])),

                        Select::make('bg_overlay_opacity')
                            ->label('Overlay Intensity')
                            ->options([
                                'opacity-0'  => '0% (No Overlay)',
                                'opacity-20' => '20% Soft Tint',
                                'opacity-40' => '40% Medium Dim',
                                'opacity-60' => '60% Dark Contrast',
                                'opacity-80' => '80% Heavy Dim',
                                'opacity-90' => '90% Stealth Mask',
                            ])
                            ->default('opacity-0')
                            ->visible(fn ($get) => in_array($get('bg_type'), ['image', 'pattern'])),
                    ]),
                ]),
        ];
    }

    /**
     * 4. Corner Radius, Borders, Drop Shadows & Filters
     */
    public static function getBordersAndEffectsGroup(): array
    {
        return [
            Section::make('Borders & Curves')
                ->schema([
                    Grid::make(4)->schema([
                        Select::make('border_radius')
                            ->label('Corner Curvature')
                            ->options([
                                'rounded-none' => 'Square (0px)',
                                'rounded-sm'   => 'Small (2px)',
                                'rounded-md'   => 'Subtle (6px)',
                                'rounded-xl'   => 'Standard (12px)',
                                'rounded-2xl'  => 'Card Curve (16px)',
                                'rounded-3xl'  => 'Pill Shape (24px)',
                                'rounded-full' => 'Circle (9999px)',
                            ])->default('rounded-none'),

                        Select::make('border_width')
                            ->label('Border Width')
                            ->options([
                                'border-0' => '0px (None)',
                                'border'   => '1px Solid',
                                'border-2' => '2px Bold',
                                'border-4' => '4px Heavy',
                            ])->default('border-0'),

                        Select::make('border_style')
                            ->label('Border Style')
                            ->options([
                                'border-solid'  => 'Solid',
                                'border-dashed' => 'Dashed',
                                'border-dotted' => 'Dotted',
                                'border-double' => 'Double',
                            ])->default('border-solid'),

                        ColorPicker::make('border_color')
                            ->label('Border Color'),
                    ]),
                ]),

            Section::make('Elevation & Glassmorphism')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('shadow')
                            ->label('Drop Shadow')
                            ->options([
                                'shadow-none'  => 'None (Flat)',
                                'shadow-sm'    => 'Subtle Elevation',
                                'shadow-md'    => 'Medium Elevation',
                                'shadow-xl'    => 'High Float Lift (XL)',
                                'shadow-2xl'   => 'Ambient Glow (2XL)',
                                'shadow-inner' => 'Inner Recessed Shadow',
                            ])->default('shadow-none'),

                        Select::make('backdrop_blur')
                            ->label('Glass Backdrop Blur')
                            ->options([
                                'backdrop-blur-none' => 'None (Clear)',
                                'backdrop-blur-sm'   => 'Subtle (4px)',
                                'backdrop-blur-md'   => 'Medium Glass (12px)',
                                'backdrop-blur-xl'   => 'Deep Frosted Glass (24px)',
                            ])->default('backdrop-blur-none'),

                        Select::make('opacity')
                            ->label('Element Opacity')
                            ->options([
                                'opacity-100' => '100% (Solid)',
                                'opacity-90'  => '90%',
                                'opacity-75'  => '75%',
                                'opacity-50'  => '50%',
                                'opacity-25'  => '25%',
                            ])->default('opacity-100'),
                    ]),
                ]),
        ];
    }

    /**
     * 5. Motion, Scroll Trigger Animations & Keyframes
     */
    public static function getAnimationGroup(): array
    {
        return [
            Section::make('Scroll Viewport Entry Reveal')
                ->description('Triggered smoothly when scrolled into view.')
                ->schema([
                    Grid::make(3)->schema([
                        Select::make('entry_animation')
                            ->label('Reveal Effect')
                            ->options([
                                'none'        => 'None (Static)',
                                'fade-in'     => 'Fade In',
                                'slide-up'    => 'Slide Upward (+Y)',
                                'slide-down'  => 'Slide Downward (-Y)',
                                'slide-left'  => 'Slide In Left',
                                'slide-right' => 'Slide In Right',
                                'zoom-in'     => 'Zoom In',
                                'zoom-out'    => 'Zoom Out',
                            ])
                            ->default('none'),

                        Select::make('animation_duration')
                            ->label('Speed')
                            ->options([
                                'duration-300'  => 'Fast (300ms)',
                                'duration-500'  => 'Quick (500ms)',
                                'duration-700'  => 'Standard (700ms)',
                                'duration-1000' => 'Slow (1000ms)',
                                'duration-1500' => 'Cinematic (1500ms)',
                            ])
                            ->default('duration-700'),

                        Select::make('animation_delay')
                            ->label('Delay')
                            ->options([
                                'delay-0'    => 'Immediate (0ms)',
                                'delay-150'  => '150ms',
                                'delay-300'  => '300ms',
                                'delay-500'  => '500ms',
                                'delay-700'  => '700ms',
                                'delay-1000' => '1000ms',
                            ])
                            ->default('delay-0'),
                    ]),
                ]),

            Section::make('Hover Micro-Interactions & Loops')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('loop_animation')
                            ->label('Keyframe Loop')
                            ->options([
                                'none'               => 'None',
                                'animate-pulse'      => 'Pulse Softly',
                                'animate-bounce'     => 'Gentle Bounce',
                                'animate-spin'       => 'Slow Spin',
                            ])
                            ->default('none'),

                        Select::make('hover_effect')
                            ->label('Hover Effect')
                            ->options([
                                'hover:none'                               => 'None',
                                'hover:-translate-y-2'                     => 'Lift Up (-8px)',
                                'hover:scale-[1.02]'                       => 'Scale Up (+2%)',
                                'hover:scale-[1.05]'                       => 'Scale Up (+5%)',
                                'hover:shadow-2xl'                         => 'Deep Shadow Glow',
                                'hover:-translate-y-2 hover:shadow-2xl'    => 'Composite Lift & Shadow',
                            ])
                            ->default('hover:none'),
                    ]),
                ]),
        ];
    }

    /**
     * 6. Device Breakpoints & Custom Code (With Reset Action)
     */
    public static function getAdvancedResponsiveGroup(): array
    {
        return [
            Section::make('Visual Style Controls')
                ->headerActions([
                    Action::make('resetStyles')
                        ->label('Reset All Block Styles')
                        ->icon('heroicon-m-arrow-path')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Reset Visual Styles')
                        ->modalDescription('Are you sure you want to reset all custom styles, dimensions, and spacing back to default values?')
                        ->modalSubmitActionLabel('Yes, Reset')
                        ->action(function (Set $set) {
                            foreach (static::getDefaultStyles() as $key => $value) {
                                $set($key, $value);
                            }

                            Notification::make()
                                ->title('Styles Reset')
                                ->body('All visual properties have been restored to defaults.')
                                ->success()
                                ->send();
                        }),
                ])
                ->schema([
                    Grid::make(3)->schema([
                        Toggle::make('hide_on_mobile')->label('Hide on Mobile (<640px)')->default(false),
                        Toggle::make('hide_on_tablet')->label('Hide on Tablet (640px-1024px)')->default(false),
                        Toggle::make('hide_on_desktop')->label('Hide on Desktop (>1024px)')->default(false),
                    ]),
                ]),

            Section::make('Custom CSS & HTML Attributes')
                ->collapsible()
                ->collapsed()
                ->schema([
                    TextInput::make('custom_css_classes')
                        ->label('Custom Tailwind / CSS Classes')
                        ->placeholder('overflow-hidden filter grayscale'),

                    TextInput::make('custom_id')
                        ->label('HTML Element ID (#id)')
                        ->placeholder('unique-section-id'),

                    Textarea::make('custom_inline_css')
                        ->label('Custom Inline CSS')
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
        if (!empty($styles['padding_top_custom'])) {
            $inlineCss[] = "padding-top: {$styles['padding_top_custom']};";
        } elseif (!empty($styles['padding_top']) && $styles['padding_top'] !== 'pt-0') {
            $classes[] = $styles['padding_top'];
        }

        if (!empty($styles['padding_bottom_custom'])) {
            $inlineCss[] = "padding-bottom: {$styles['padding_bottom_custom']};";
        } elseif (!empty($styles['padding_bottom']) && $styles['padding_bottom'] !== 'pb-0') {
            $classes[] = $styles['padding_bottom'];
        }

        if (!empty($styles['padding_left_custom'])) {
            $inlineCss[] = "padding-left: {$styles['padding_left_custom']};";
        }
        if (!empty($styles['padding_right_custom'])) {
            $inlineCss[] = "padding-right: {$styles['padding_right_custom']};";
        }
        if (empty($styles['padding_left_custom']) && empty($styles['padding_right_custom'])) {
            if (!empty($styles['padding_x']) && $styles['padding_x'] !== 'px-0') {
                $classes[] = $styles['padding_x'];
            }
        }

        // Custom Margins
        if (!empty($styles['margin_top_custom'])) {
            $inlineCss[] = "margin-top: {$styles['margin_top_custom']};";
        } elseif (!empty($styles['margin_top']) && $styles['margin_top'] !== 'mt-0') {
            $classes[] = $styles['margin_top'];
        }

        if (!empty($styles['margin_bottom_custom'])) {
            $inlineCss[] = "margin-bottom: {$styles['margin_bottom_custom']};";
        } elseif (!empty($styles['margin_bottom']) && $styles['margin_bottom'] !== 'mb-0') {
            $classes[] = $styles['margin_bottom'];
        }

        if (!empty($styles['margin_left_custom'])) {
            $inlineCss[] = "margin-left: {$styles['margin_left_custom']};";
        }
        if (!empty($styles['margin_right_custom'])) {
            $inlineCss[] = "margin-right: {$styles['margin_right_custom']};";
        }

        // --- Container Width Resolution ---
        $maxWidth = $styles['max_width'] ?? 'full';
        if ($maxWidth === 'full' || $maxWidth === 'w-full max-w-none' || $maxWidth === 'max-w-none') {
            $classes[] = 'w-full max-w-none';
        } else {
            $classes[] = 'w-full ' . $maxWidth;
        }

        $classes[] = $styles['alignment'] ?? 'mx-auto';
        $classes[] = $styles['overflow'] ?? 'overflow-visible';

        if (!empty($styles['z_index']) && $styles['z_index'] !== 'z-auto') {
            $classes[] = $styles['z_index'];
        }

        if (!empty($styles['opacity']) && $styles['opacity'] !== 'opacity-100') {
            $classes[] = $styles['opacity'];
        }

        if (!empty($styles['custom_min_height'])) {
            $inlineCss[] = "min-height: {$styles['custom_min_height']};";
        }

        if (!empty($styles['content_gap']) && $styles['content_gap'] !== 'gap-0') {
            $classes[] = $styles['content_gap'];
        }

        // 2. Typography
        $classes[] = $styles['font_family'] ?? 'font-sans';
        $classes[] = $styles['text_align'] ?? 'text-left';

        if (!empty($styles['font_size'])) {
            $classes[] = $styles['font_size'];
        }
        if (!empty($styles['font_weight']) && $styles['font_weight'] !== 'font-normal') {
            $classes[] = $styles['font_weight'];
        }
        if (!empty($styles['line_height'])) {
            $classes[] = $styles['line_height'];
        }
        if (!empty($styles['letter_spacing']) && $styles['letter_spacing'] !== 'tracking-normal') {
            $classes[] = $styles['letter_spacing'];
        }
        if (!empty($styles['text_transform']) && $styles['text_transform'] !== 'normal-case') {
            $classes[] = $styles['text_transform'];
        }

        if (!empty($styles['custom_font_size'])) {
            $inlineCss[] = "font-size: {$styles['custom_font_size']};";
        }

        if (!empty($styles['text_color'])) {
            $inlineCss[] = "color: {$styles['text_color']};";
        }

        // 3. Borders & Surfaces
        if (!empty($styles['border_radius']) && $styles['border_radius'] !== 'rounded-none') {
            $classes[] = $styles['border_radius'];
        }
        if (!empty($styles['border_width']) && $styles['border_width'] !== 'border-0') {
            $classes[] = $styles['border_width'];
            $classes[] = $styles['border_style'] ?? 'border-solid';
        }
        if (!empty($styles['shadow']) && $styles['shadow'] !== 'shadow-none') {
            $classes[] = $styles['shadow'];
        }
        if (!empty($styles['backdrop_blur']) && $styles['backdrop_blur'] !== 'backdrop-blur-none') {
            $classes[] = $styles['backdrop_blur'];
        }

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

        // 6. Scroll Entry Reveal (Alpine.js)
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
