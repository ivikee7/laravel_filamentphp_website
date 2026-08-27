<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class BlockRegistry
{
    /**
     * Recursive block provider supporting unlimited layout depth.
     */
    public static function getBlocks(int $depth = 0, int $maxDepth = 5): array
    {
        if ($depth >= $maxDepth) {
            return static::getLeafBlocks();
        }

        return array_merge(static::getLeafBlocks(), [
            // Nested Container: Accordion System
            Block::make('accordion_container')
                ->label('Nested Accordion Block')
                ->icon('heroicon-o-chevron-down')
                ->schema([
                    Repeater::make('items')
                        ->schema([
                            TextInput::make('title')->label('Accordion Header')->required(),
                            Builder::make('blocks')
                                ->label('Accordion Nested Content')
                                ->blockIcons()
                                ->collapsible()
                                ->blocks(static::getBlocks($depth + 1, $maxDepth)),
                        ])->collapsible(),
                ]),

            // Nested Container: Tabs Wrapper
            Block::make('tabs_container')
                ->label('Nested Tabbed Group')
                ->icon('heroicon-o-folder')
                ->schema([
                    Repeater::make('tabs')
                        ->schema([
                            TextInput::make('tab_title')->label('Tab Trigger Label')->required(),
                            Builder::make('blocks')
                                ->label('Tab Content Area')
                                ->blockIcons()
                                ->collapsible()
                                ->blocks(static::getBlocks($depth + 1, $maxDepth)),
                        ])->collapsible(),
                ]),

            // Nested Container: Sub-Section Wrapper
            Block::make('nested_section')
                ->label('Sub-Section Canvas')
                ->icon('heroicon-o-rectangle-stack')
                ->schema([
                    Tabs::make('Sub-Section Blueprint')
                        ->tabs([
                            Tab::make('Layout Grids')->schema([
                                Repeater::make('rows')
                                    ->schema([
                                        Select::make('columns_layout')
                                            ->options([
                                                '1'     => '1 Column (Full Width)',
                                                '2'     => '2 Columns (50/50)',
                                                '3'     => '3 Columns (33/33/33)',
                                                '4'     => '4 Columns (25/25/25/25)',
                                                '1-2'   => '2 Columns (33/67)',
                                                '2-1'   => '2 Columns (67/33)',
                                            ])->default('1'),
                                        Repeater::make('columns')
                                            ->schema([
                                                Builder::make('blocks')
                                                    ->blockIcons()
                                                    ->collapsible()
                                                    ->blocks(static::getBlocks($depth + 1, $maxDepth)),
                                            ])->grid(1),
                                    ])->collapsible(),
                            ]),
                            Tab::make('Design Engine')->schema(array_merge(
                                StyleHelper::makeBackgroundGroup(),
                                StyleHelper::makeBoxStyleGroup()
                            )),
                        ]),
                ]),
        ]);
    }

    /**
     * Complete Suite of Content & Media Leaf Blocks
     */
    protected static function getLeafBlocks(): array
    {
        return [
            // 1. Heading Block
            Block::make('heading')
                ->icon('heroicon-o-h1')
                ->schema([
                    Tabs::make('Heading Settings')->tabs([
                        Tab::make('Content')->schema([
                            TextInput::make('content')->label('Text')->required(),
                            Grid::make(3)->schema([
                                Select::make('level')->options(['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5'])->default('h2'),
                                Select::make('alignment')->options(['text-left' => 'Left', 'text-center' => 'Center', 'text-right' => 'Right'])->default('text-left'),
                                Select::make('font_weight')->options(['font-light' => 'Light', 'font-normal' => 'Regular', 'font-semibold' => 'Semibold', 'font-bold' => 'Bold', 'font-black' => 'Black'])->default('font-bold'),
                            ]),
                        ]),
                        Tab::make('Styling')->schema(array_merge([
                            Grid::make(2)->schema([
                                ColorPicker::make('text_color')->label('Text Color'),
                                TextInput::make('custom_font_size')->label('Font Size (e.g. 2.5rem)'),
                            ]),
                        ], StyleHelper::makeBoxStyleGroup())),
                    ]),
                ]),

            // 2. Rich Text Editor
            Block::make('richText')
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    RichEditor::make('content')->label('Rich Text')->required(),
                ]),

            // 3. Image Element
            Block::make('image')
                ->icon('heroicon-o-photo')
                ->schema([
                    FileUpload::make('url')->disk('public')->directory('page-builder')->image()->required(),
                    Grid::make(3)->schema([
                        TextInput::make('alt')->label('Alt Text'),
                        Select::make('aspect_ratio')->options(['auto' => 'Auto', '1:1' => '1:1 Square', '16:9' => '16:9 Video', '4:3' => '4:3 Standard'])->default('auto'),
                        Select::make('object_fit')->options(['object-cover' => 'Cover', 'object-contain' => 'Contain'])->default('object-cover'),
                    ]),
                ]),

            // 4. Buttons & Action Links
            Block::make('button')
                ->label('CTA Button / Link')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('label')->label('Button Label')->required(),
                        TextInput::make('url')->label('Destination URL')->required(),
                        Select::make('target')->options(['_self' => 'Same Window', '_blank' => 'New Tab'])->default('_self'),
                    ]),
                    Grid::make(3)->schema([
                        Select::make('style')->options([
                            'btn-primary'   => 'Solid Primary',
                            'btn-secondary' => 'Solid Secondary',
                            'btn-outline'   => 'Outline Outline',
                            'btn-ghost'     => 'Ghost Text',
                        ])->default('btn-primary'),
                        Select::make('size')->options(['btn-sm' => 'Small', 'btn-md' => 'Medium', 'btn-lg' => 'Large'])->default('btn-md'),
                        ColorPicker::make('custom_bg')->label('Custom BG Color'),
                    ]),
                ]),

            // 5. Video Player & Embeds
            Block::make('video')
                ->icon('heroicon-o-video-camera')
                ->schema([
                    Select::make('source_type')->options(['embed' => 'YouTube / Vimeo URL', 'upload' => 'Self-Hosted MP4 File'])->default('embed'),
                    TextInput::make('embed_url')->label('Embed Link (YouTube/Vimeo)')->visible(fn ($get) => $get('source_type') === 'embed'),
                    FileUpload::make('file_path')->disk('public')->directory('videos')->visible(fn ($get) => $get('source_type') === 'upload'),
                    Grid::make(3)->schema([
                        Select::make('autoplay')->options(['0' => 'Off', '1' => 'On'])->default('0'),
                        Select::make('loop')->options(['0' => 'Off', '1' => 'On'])->default('0'),
                        Select::make('controls')->options(['1' => 'Show Controls', '0' => 'Hide Controls'])->default('1'),
                    ]),
                ]),

            // 6. Metric & KPI Counter Block
            Block::make('stat_card')
                ->label('Stat / KPI Counter')
                ->icon('heroicon-o-chart-bar')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('number')->label('Stat Value (e.g. 99.9%, $10M+)')->required(),
                        TextInput::make('label')->label('Metric Title')->required(),
                        TextInput::make('description')->label('Subtext / Detail'),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make('icon')->label('Heroicon / SVG Icon Name'),
                        ColorPicker::make('number_color')->label('Number Color'),
                    ]),
                ]),

            // 7. Testimonial / Quote Card
            Block::make('testimonial')
                ->label('Testimonial Card')
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->schema([
                    Textarea::make('quote')->label('Quote Content')->required(),
                    Grid::make(3)->schema([
                        TextInput::make('author_name')->label('Author Name')->required(),
                        TextInput::make('author_title')->label('Title / Company'),
                        FileUpload::make('author_avatar')->disk('public')->directory('avatars')->image(),
                    ]),
                ]),

            // 8. Interactive Pricing Table
            Block::make('pricing_card')
                ->label('Pricing Tier Card')
                ->icon('heroicon-o-currency-dollar')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('plan_name')->label('Plan Name (e.g. Pro)')->required(),
                        TextInput::make('price')->label('Price (e.g. $49)')->required(),
                        TextInput::make('billing_cycle')->label('Period (e.g. /month)')->default('/month'),
                    ]),
                    Repeater::make('features')
                        ->schema([
                            TextInput::make('feature_text')->label('Feature Included'),
                            Select::make('is_included')->options(['1' => 'Included', '0' => 'Excluded'])->default('1'),
                        ]),
                    TextInput::make('button_text')->default('Get Started'),
                    TextInput::make('button_url')->default('#'),
                ]),

            // 9. Code Snippet & Syntax Block
            Block::make('code_block')
                ->label('Code Snippet')
                ->icon('heroicon-o-code-bracket')
                ->schema([
                    Select::make('language')->options([
                        'html' => 'HTML', 'css' => 'CSS', 'javascript' => 'JavaScript',
                        'php' => 'PHP', 'python' => 'Python', 'json' => 'JSON', 'sql' => 'SQL'
                    ])->default('php'),
                    Textarea::make('code')->rows(8)->required(),
                ]),

            // 10. Callout / Alert Box
            Block::make('callout')
                ->icon('heroicon-o-exclamation-triangle')
                ->schema([
                    Grid::make(2)->schema([
                        Select::make('type')->options(['info' => 'Info', 'success' => 'Success', 'warning' => 'Warning', 'danger' => 'Danger'])->default('info'),
                        TextInput::make('title')->label('Alert Heading'),
                    ]),
                    Textarea::make('message')->required(),
                ]),
        ];
    }
}
