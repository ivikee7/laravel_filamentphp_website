<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Callout;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;

class PageBuilderSchema
{
    /**
     * Get core modular content blocks.
     */
    public static function getContentBlocks(): array
    {
        return [
            // --- Typography & Content ---
            Block::make('heading')
                ->icon('heroicon-o-h1')
                ->schema([
                    Select::make('level')
                        ->options(['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4', 'h5' => 'H5', 'h6' => 'H6'])
                        ->default('h2')
                        ->required(),
                    TextInput::make('content')
                        ->label('Heading Text')
                        ->required()
                        ->columnSpan(3),
                ])->columns(4),

            Block::make('paragraph')
                ->icon('heroicon-o-document-text')
                ->schema([
                    Textarea::make('content')->label('Paragraph Text')->required(),
                ]),

            Block::make('richText')
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    RichEditor::make('content')->label('Rich Text Content')->required(),
                ]),

            Block::make('quote')
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->schema([
                    Textarea::make('text')->label('Quote Text')->required(),
                    TextInput::make('author')->label('Author / Source'),
                    TextInput::make('cite')->label('Citation URL')->url(),
                ]),

            // Native Callout Component (Introduced in Filament v5)
            Block::make('callout')
                ->icon('heroicon-o-exclamation-triangle')
                ->schema([
                    Select::make('type')
                        ->options(['info' => 'Info', 'success' => 'Success', 'warning' => 'Warning', 'danger' => 'Danger'])
                        ->default('info')
                        ->required(),
                    Textarea::make('message')->required(),
                ]),

            Block::make('code')
                ->icon('heroicon-o-code-bracket-square')
                ->schema([
                    Select::make('language')
                        ->options(['php' => 'PHP', 'js' => 'JS', 'html' => 'HTML', 'css' => 'CSS', 'json' => 'JSON'])
                        ->default('php'),
                    CodeEditor::make('content')->label('Code Snippet')->required(),
                ]),

            Block::make('rawHtml')
                ->icon('heroicon-o-code-bracket')
                ->schema([
                    Textarea::make('html')->label('Raw HTML')->rows(6)->required(),
                ]),

            // --- Media ---
            Block::make('image')
                ->icon('heroicon-o-photo')
                ->schema([
                    FileUpload::make('url')->label('Image')->image()->required(),
                    TextInput::make('alt')->label('Alt Text')->required(),
                    TextInput::make('caption')->label('Caption'),
                ]),

            Block::make('gallery')
                ->icon('heroicon-o-squares-2x2')
                ->schema([
                    FileUpload::make('images')->multiple()->image()->reorderable()->required(),
                    Select::make('columns')->options([2 => '2 Cols', 3 => '3 Cols', 4 => '4 Cols'])->default(3)->required(),
                ])->columns(2),

            Block::make('imageComparison')
                ->icon('heroicon-o-arrows-right-left')
                ->schema([
                    FileUpload::make('before_image')->label('Before')->image()->required(),
                    FileUpload::make('after_image')->label('After')->image()->required(),
                ])->columns(2),

            Block::make('videoEmbed')
                ->icon('heroicon-o-video-camera')
                ->schema([
                    TextInput::make('url')->label('Video URL')->url()->required(),
                    TextInput::make('aspect_ratio')->default('16:9'),
                ]),

            Block::make('audioPlayer')
                ->icon('heroicon-o-musical-note')
                ->schema([
                    FileUpload::make('file_path')->label('Audio File')->acceptedFileTypes(['audio/mpeg', 'audio/wav'])->required(),
                    TextInput::make('title')->label('Track Title'),
                ]),

            Block::make('fileDownload')
                ->icon('heroicon-o-document-arrow-down')
                ->schema([
                    FileUpload::make('file')->preserveFilenames()->required(),
                    TextInput::make('label')->placeholder('Download PDF')->required(),
                ]),

            // --- Layout & Elements ---
            Block::make('accordion')
                ->icon('heroicon-o-chevron-down')
                ->schema([
                    Repeater::make('items')
                        ->schema([
                            TextInput::make('title')->required(),
                            RichEditor::make('content')->required(),
                        ])->collapsible()->required(),
                ]),

            Block::make('tabs')
                ->icon('heroicon-o-folder')
                ->schema([
                    Repeater::make('items')
                        ->schema([
                            TextInput::make('label')->required(),
                            RichEditor::make('content')->required(),
                        ])->collapsible()->required(),
                ]),

            Block::make('cardsList')
                ->icon('heroicon-o-squares-plus')
                ->schema([
                    Repeater::make('cards')
                        ->schema([
                            FileUpload::make('image')->image(),
                            TextInput::make('title')->required(),
                            Textarea::make('description')->required(),
                            TextInput::make('button_url')->url(),
                        ])->grid(2)->collapsible(),
                ]),

            Block::make('timeline')
                ->icon('heroicon-o-clock')
                ->schema([
                    Repeater::make('events')
                        ->schema([
                            TextInput::make('date_or_step')->required(),
                            TextInput::make('title')->required(),
                            Textarea::make('description')->required(),
                        ])->collapsible(),
                ]),

            Block::make('marquee')
                ->icon('heroicon-o-view-columns')
                ->schema([
                    Textarea::make('content')->rows(2)->required()->columnSpanFull(),
                    Select::make('direction')->options(['left' => 'Left', 'right' => 'Right', 'up' => 'Up', 'down' => 'Down'])->default('left'),
                    Select::make('speed')->options(['slow' => 'Slow', 'normal' => 'Normal', 'fast' => 'Fast'])->default('normal'),
                    Toggle::make('pause_on_hover')->default(true),
                ])->columns(3),

            Block::make('divider')
                ->icon('heroicon-o-minus')
                ->schema([
                    Select::make('style')->options(['solid' => 'Solid', 'dashed' => 'Dashed', 'dotted' => 'Dotted'])->default('solid'),
                    Select::make('spacing')->options(['sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large'])->default('md'),
                ])->columns(2),

            Block::make('spacer')
                ->icon('heroicon-o-arrows-up-down')
                ->schema([
                    Select::make('height')->options(['small' => '24px', 'medium' => '48px', 'large' => '96px'])->default('medium'),
                ]),

            // --- Marketing & Proof ---
            Block::make('button')
                ->icon('heroicon-o-rectangle-stack')
                ->schema([
                    TextInput::make('text')->label('Button Text')->required(),
                    TextInput::make('url')->label('Redirect URL')->url()->required(),
                    Select::make('style')->options(['primary' => 'Primary', 'secondary' => 'Secondary', 'danger' => 'Danger'])->default('primary'),
                    Toggle::make('open_in_new_tab')->default(false),
                ])->columns(2),

            Block::make('pricingCard')
                ->icon('heroicon-o-currency-dollar')
                ->schema([
                    TextInput::make('tier_name')->required(),
                    TextInput::make('price')->placeholder('$29/mo')->required(),
                    Textarea::make('description'),
                    TagsInput::make('features')->placeholder('Add feature...'),
                    TextInput::make('cta_text')->default('Get Started'),
                    TextInput::make('cta_url')->url(),
                    Toggle::make('is_featured')->label('Highlight Tier'),
                ])->columns(2),

            Block::make('statsOverview')
                ->icon('heroicon-o-chart-bar')
                ->schema([
                    Repeater::make('stats')
                        ->schema([
                            TextInput::make('value')->placeholder('99.9%')->required(),
                            TextInput::make('label')->placeholder('Uptime Guarantee')->required(),
                            TextInput::make('description'),
                        ])->grid(3),
                ]),

            Block::make('testimonial')
                ->icon('heroicon-o-user-circle')
                ->schema([
                    Textarea::make('quote')->required(),
                    TextInput::make('author_name')->required(),
                    TextInput::make('author_title')->placeholder('CEO, Acme Corp'),
                    FileUpload::make('author_avatar')->image()->avatar(),
                ])->columns(2),

            Block::make('logoCloud')
                ->icon('heroicon-o-building-office-2')
                ->schema([
                    TextInput::make('title')->placeholder('Trusted by companies worldwide'),
                    FileUpload::make('logos')->multiple()->image()->required(),
                ]),

            Block::make('socialShare')
                ->icon('heroicon-o-share')
                ->schema([
                    CheckboxList::make('platforms')
                        ->options(['x' => 'X', 'linkedin' => 'LinkedIn', 'facebook' => 'Facebook', 'whatsapp' => 'WhatsApp'])
                        ->required(),
                ]),

            // --- Forms & Tables ---
            Block::make('dataTable')
                ->icon('heroicon-o-table-cells')
                ->schema([
                    KeyValue::make('data')->keyLabel('Label')->valueLabel('Description')->required(),
                ]),

            Block::make('contactForm')
                ->icon('heroicon-o-envelope')
                ->schema([
                    TextInput::make('form_identifier')->required(),
                    Toggle::make('enable_recaptcha')->default(true),
                ]),

            Block::make('newsletterSignup')
                ->icon('heroicon-o-envelope-open')
                ->schema([
                    TextInput::make('heading')->default('Subscribe to our newsletter'),
                    TextInput::make('subheading'),
                    TextInput::make('placeholder')->default('Enter your email'),
                    TextInput::make('button_text')->default('Subscribe'),
                ]),

            Block::make('faqSchema')
                ->icon('heroicon-o-question-mark-circle')
                ->schema([
                    Repeater::make('qa_pairs')
                        ->schema([
                            TextInput::make('question')->required(),
                            Textarea::make('answer')->required(),
                        ])->collapsible(),
                ]),
        ];
    }

    /**
     * Filament v5 Section & Multi-Column Page Schema
     */
    public static function make(): Section
    {
        return Section::make('Modular Page Content')
            ->schema([
                Builder::make('content_sections')
                    ->label('Page Sections')
                    ->blockIcons()
                    ->collapsible()
                    ->cloneable()
                    ->blocks([

                        // Section Wrapper Block
                        Block::make('page_section')
                            ->label('Page Section')
                            ->icon('heroicon-o-rectangle-group')
                            ->schema([
                                Group::make([
                                    TextInput::make('section_id')
                                        ->label('Section Anchor / DOM ID')
                                        ->placeholder('e.g., hero-section'),

                                    Select::make('background_style')
                                        ->options([
                                            'transparent' => 'Transparent',
                                            'light' => 'Light Gray',
                                            'dark' => 'Dark Theme',
                                            'custom' => 'Custom Accent',
                                        ])
                                        ->default('transparent'),

                                    ColorPicker::make('custom_bg')
                                        ->label('Background Color')
                                        ->visible(fn($get) => $get('background_style') === 'custom'),

                                    Select::make('padding')
                                        ->options(['none' => 'None', 'sm' => 'Small', 'md' => 'Medium', 'lg' => 'Large'])
                                        ->default('md'),
                                ])->columns(4),

                                // Multi-Column Layout Grid inside Section
                                Builder::make('section_grids')
                                    ->label('Grid Layout Rows')
                                    ->blockIcons()
                                    ->collapsible()
                                    ->blocks([
                                        Block::make('column_layout')
                                            ->label('Multi-Column Layout')
                                            ->icon('heroicon-o-view-columns')
                                            ->schema([
                                                Select::make('split')
                                                    ->label('Layout Ratio')
                                                    ->options([
                                                        '1' => '1 Column (Full Width)',
                                                        '2' => '2 Columns (50 / 50)',
                                                        '3' => '3 Columns (33 / 33 / 33)',
                                                        '4' => '4 Columns (25 / 25 / 25 / 25)',
                                                        '1-2' => '2 Columns (33 / 67)',
                                                        '2-1' => '2 Columns (67 / 33)',
                                                    ])
                                                    ->default('1')
                                                    ->required(),

                                                Repeater::make('columns')
                                                    ->label('Columns')
                                                    ->schema([
                                                        Builder::make('blocks')
                                                            ->label('Column Content')
                                                            ->blockIcons()
                                                            ->collapsible()
                                                            ->blocks(static::getContentBlocks()),
                                                    ])
                                                    ->collapsible()
                                                    ->grid(2),
                                            ]),
                                    ]),
                            ]),

                        // Top-level Standalone Hero Section
                        Block::make('heroSection')
                            ->label('Hero Banner')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                TextInput::make('badge')->placeholder('New Release'),
                                TextInput::make('title')->required(),
                                Textarea::make('subtitle'),
                                FileUpload::make('background_image')->image(),
                                TextInput::make('cta_text'),
                                TextInput::make('cta_url')->url(),
                            ]),
                    ]),
            ])
            ->columnSpanFull();
    }
}
