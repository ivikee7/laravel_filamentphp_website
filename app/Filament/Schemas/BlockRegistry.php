<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class BlockRegistry
{
    /**
     * Recursive layout containers (strictly depth-controlled to prevent execution timeout).
     */
    public static function getBlocks(int $depth = 0, int $maxDepth = 1): array
    {
        $leafBlocks = static::getLeafBlocks();

        // When depth limit is reached, return only leaf blocks (no sub-containers)
        if ($depth >= $maxDepth) {
            return $leafBlocks;
        }

        return array_merge($leafBlocks, [
            // Container 1: Accordion System
            Block::make('accordion_container')
                ->label('Accordion (Layout)')
                ->icon('heroicon-o-chevron-down')
                ->schema([
                    Tabs::make('Accordion Config')->schema([
                        Tab::make('Content Items')->schema([
                            Repeater::make('items')
                                ->schema([
                                    TextInput::make('title')->label('Accordion Header')->required(),
                                    Builder::make('blocks')
                                        ->label('Accordion Content')
                                        ->blockIcons()
                                        ->collapsible()
                                        ->blockPickerColumns(3)
                                        ->blocks(static::getLeafBlocks()), // Leaf only inside accordion
                                ])->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            // Container 2: Tabbed Panes
            Block::make('tabs_container')
                ->label('Tab Group (Layout)')
                ->icon('heroicon-o-folder')
                ->schema([
                    Tabs::make('Tabs Config')->schema([
                        Tab::make('Tab Panes')->schema([
                            Repeater::make('tabs')
                                ->schema([
                                    TextInput::make('tab_title')->label('Tab Trigger Label')->required(),
                                    Builder::make('blocks')
                                        ->label('Tab Content Area')
                                        ->blockIcons()
                                        ->collapsible()
                                        ->blockPickerColumns(3)
                                        ->blocks(static::getLeafBlocks()), // Leaf only inside tabs
                                ])->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),
        ]);
    }

    /**
     * Essential suite of leaf component blocks.
     */
    public static function getLeafBlocks(): array
    {
        return [
            // --- 1. HERO & BANNERS ---
            Block::make('hero_section')
                ->label('Hero Banner')
                ->icon('heroicon-o-sparkles')
                ->schema([
                    Tabs::make('Hero Settings')->schema([
                        Tab::make('Content')->schema([
                            TextInput::make('badge')->label('Eyebrow Badge'),
                            TextInput::make('headline')->label('Main Headline')->required(),
                            Textarea::make('subheadline')->label('Subheading Description')->rows(3),
                            Grid::make(2)->schema([
                                TextInput::make('primary_cta_label')->label('Primary CTA Text')->default('Get Started'),
                                TextInput::make('primary_cta_url')->label('Primary CTA URL')->default('#'),
                            ]),
                            Grid::make(2)->schema([
                                TextInput::make('secondary_cta_label')->label('Secondary CTA Text'),
                                TextInput::make('secondary_cta_url')->label('Secondary CTA URL'),
                            ]),
                            FileUpload::make('hero_image')
                                ->disk('public')
                                ->directory('hero')
                                ->image()
                                ->label('Hero Featured Graphic'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            // --- 2. TYPOGRAPHY & PROSE ---
            Block::make('heading')
                ->label('Heading (Typography)')
                ->icon('heroicon-o-h1')
                ->schema([
                    Tabs::make('Heading Settings')->schema([
                        Tab::make('Content')->schema([
                            TextInput::make('content')->label('Heading Text')->required(),
                            Grid::make(3)->schema([
                                Select::make('level')->options(['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5'])->default('h2'),
                                Select::make('alignment')->options(['text-left' => 'Left', 'text-center' => 'Center', 'text-right' => 'Right'])->default('text-left'),
                                Select::make('font_weight')->options(['font-normal' => 'Regular', 'font-semibold' => 'Semibold', 'font-bold' => 'Bold', 'font-black' => 'Black'])->default('font-bold'),
                            ]),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('rich_text')
                ->label('Rich Text (Typography)')
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    Tabs::make('Rich Text Settings')->schema([
                        Tab::make('Editor')->schema([
                            RichEditor::make('content')->label('Article Content')->required(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('callout')
                ->label('Callout Box (Typography)')
                ->icon('heroicon-o-exclamation-triangle')
                ->schema([
                    Tabs::make('Callout Settings')->schema([
                        Tab::make('Content')->schema([
                            Grid::make(2)->schema([
                                Select::make('type')->options(['info' => 'Info Blue', 'success' => 'Success Green', 'warning' => 'Warning Yellow', 'danger' => 'Danger Red'])->default('info'),
                                TextInput::make('title')->label('Alert Headline'),
                            ]),
                            Textarea::make('message')->label('Message Body')->required(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('notice_ticker')
                ->label('Notice Ticker (Urgent)')
                ->icon('heroicon-o-megaphone')
                ->schema([
                    Tabs::make('Notice Settings')->schema([
                        Tab::make('Content')->schema([
                            Select::make('urgency_level')
                                ->options([
                                    'info'    => 'Information (Blue)',
                                    'success' => 'Admissions Open (Green)',
                                    'warning' => 'Important Notice (Amber)',
                                    'danger'  => 'Urgent Alert / Holiday (Red)',
                                ])->default('info'),
                            TextInput::make('notice_text')->label('Announcement Headline')->required(),
                            Grid::make(2)->schema([
                                TextInput::make('action_label')->label('Action Link Text'),
                                TextInput::make('action_url')->label('Action Link URL'),
                            ]),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            // --- 3. MEDIA & VISUALS ---
            Block::make('image')
                ->label('Image Block (Media)')
                ->icon('heroicon-o-photo')
                ->schema([
                    Tabs::make('Image Settings')->schema([
                        Tab::make('Image Source')->schema([
                            FileUpload::make('url')->disk('public')->directory('page-builder/images')->image()->imageEditor()->required(),
                            Grid::make(3)->schema([
                                TextInput::make('alt')->label('Alt Text (SEO)'),
                                Select::make('aspect_ratio')->options(['auto' => 'Original', '1:1' => '1:1 Square', '16:9' => '16:9 Wide', '4:3' => '4:3 Photo'])->default('auto'),
                                Select::make('object_fit')->options(['object-cover' => 'Cover', 'object-contain' => 'Contain'])->default('object-cover'),
                            ]),
                            TextInput::make('caption')->label('Image Caption'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('gallery')
                ->label('Photo Gallery (Media)')
                ->icon('heroicon-o-square-3-stack-3d')
                ->schema([
                    Tabs::make('Gallery Settings')->schema([
                        Tab::make('Photos')->schema([
                            Repeater::make('images')
                                ->schema([
                                    FileUpload::make('image')->disk('public')->directory('gallery')->image()->required(),
                                    TextInput::make('caption')->label('Caption'),
                                ])->columns(2)->collapsible(),
                            Select::make('columns')->options(['2' => '2 Columns', '3' => '3 Columns', '4' => '4 Columns'])->default('3'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('video_embed')
                ->label('Video Embed (Media)')
                ->icon('heroicon-o-video-camera')
                ->schema([
                    Tabs::make('Video Settings')->schema([
                        Tab::make('Media')->schema([
                            Select::make('source_type')->options(['embed' => 'YouTube / Vimeo URL', 'upload' => 'Self-Hosted MP4'])->default('embed')->live(),
                            TextInput::make('embed_url')->label('Embed Link')->visible(fn($get) => $get('source_type') === 'embed'),
                            FileUpload::make('file_path')->disk('public')->directory('videos')->visible(fn($get) => $get('source_type') === 'upload'),
                            Grid::make(3)->schema([
                                Toggle::make('autoplay')->label('Autoplay'),
                                Toggle::make('loop')->label('Loop Video'),
                                Toggle::make('controls')->label('Show Controls')->default(true),
                            ]),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            // --- 4. MARKETING & CONVERSION ---
            Block::make('button')
                ->label('CTA Button (Marketing)')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->schema([
                    Tabs::make('Button Settings')->schema([
                        Tab::make('Action')->schema([
                            Grid::make(3)->schema([
                                TextInput::make('label')->label('Button Label')->required(),
                                TextInput::make('url')->label('Destination URL')->required(),
                                Select::make('target')->options(['_self' => 'Same Tab', '_blank' => 'New Window'])->default('_self'),
                            ]),
                            Grid::make(3)->schema([
                                Select::make('style')->options(['btn-primary' => 'Solid Primary', 'btn-secondary' => 'Solid Secondary', 'btn-outline' => 'Outline Border', 'btn-ghost' => 'Ghost Text'])->default('btn-primary'),
                                Select::make('size')->options(['btn-sm' => 'Small', 'btn-md' => 'Medium', 'btn-lg' => 'Large'])->default('btn-md'),
                                ColorPicker::make('custom_bg')->label('Custom BG Color'),
                            ]),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('feature_card')
                ->label('Feature Card (Marketing)')
                ->icon('heroicon-o-cube-transparent')
                ->schema([
                    Tabs::make('Feature Settings')->schema([
                        Tab::make('Content')->schema([
                            TextInput::make('icon')->label('Icon Name')->default('sparkles'),
                            TextInput::make('title')->label('Feature Title')->required(),
                            Textarea::make('description')->label('Description')->rows(3)->required(),
                            Grid::make(2)->schema([
                                TextInput::make('link_text')->label('Link Text')->default('Learn more →'),
                                TextInput::make('link_url')->label('Destination URL'),
                            ]),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('faq_schema')
                ->label('FAQ Section (Marketing)')
                ->icon('heroicon-o-question-mark-circle')
                ->schema([
                    Tabs::make('FAQ Settings')->schema([
                        Tab::make('Questions')->schema([
                            Repeater::make('faqs')
                                ->schema([
                                    TextInput::make('question')->label('Question')->required(),
                                    Textarea::make('answer')->label('Answer')->rows(3)->required(),
                                ])->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),
        ];
    }
}
