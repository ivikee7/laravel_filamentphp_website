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
     * Recursive layout containers (depth-controlled).
     */
    public static function getBlocks(int $depth = 0, int $maxDepth = 3): array
    {
        if ($depth >= $maxDepth) {
            return static::getLeafBlocks();
        }

        return array_merge(static::getLeafBlocks(), [
            // Container 1: Accordion System
            Block::make('accordion_container')
                ->label('Accordion (Layout)')
                ->icon('heroicon-o-chevron-down')
                ->schema([
                    Tabs::make('Accordion Config')->tabs([
                        Tab::make('Content Items')->schema([
                            Repeater::make('items')
                                ->schema([
                                    TextInput::make('title')->label('Accordion Header')->required(),
                                    Builder::make('blocks')
                                        ->label('Accordion Content')
                                        ->blockIcons()
                                        ->collapsible()
                                        ->blockPickerColumns(4)
                                        ->blocks(static::getBlocks($depth + 1, $maxDepth)),
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
                    Tabs::make('Tabs Config')->tabs([
                        Tab::make('Tab Panes')->schema([
                            Repeater::make('tabs')
                                ->schema([
                                    TextInput::make('tab_title')->label('Tab Trigger Label')->required(),
                                    Builder::make('blocks')
                                        ->label('Tab Content Area')
                                        ->blockIcons()
                                        ->collapsible()
                                        ->blockPickerColumns(4)
                                        ->blocks(static::getBlocks($depth + 1, $maxDepth)),
                                ])->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            // Container 3: Sub-Section Grid Canvas
            Block::make('nested_section')
                ->label('Sub-Section (Layout)')
                ->icon('heroicon-o-rectangle-stack')
                ->schema([
                    Tabs::make('Sub-Section Blueprint')->tabs([
                        Tab::make('Layout Grids')->schema([
                            Repeater::make('rows')
                                ->schema([
                                    Select::make('columns_layout')
                                        ->options([
                                            '1'   => '1 Column (Full Width)',
                                            '2'   => '2 Columns (50 / 50)',
                                            '3'   => '3 Columns (33 / 33 / 33)',
                                            '4'   => '4 Columns (25 / 25 / 25 / 25)',
                                            '1-2' => '2 Columns (33 / 67)',
                                            '2-1' => '2 Columns (67 / 33)',
                                        ])->default('1'),
                                    Repeater::make('columns')
                                        ->schema([
                                            Builder::make('blocks')
                                                ->blockIcons()
                                                ->collapsible()
                                                ->blockPickerColumns(4)
                                                ->blocks(static::getBlocks($depth + 1, $maxDepth)),
                                        ])->grid(1),
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
    protected static function getLeafBlocks(): array
    {
        return [
            // --- 1. HERO & BANNERS ---
            Block::make('hero_section')
                ->label('Hero Banner')
                ->icon('heroicon-o-sparkles')
                ->schema([
                    Tabs::make('Hero Settings')->tabs([
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
                    Tabs::make('Heading Settings')->tabs([
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
                    Tabs::make('Rich Text Settings')->tabs([
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
                    Tabs::make('Callout Settings')->tabs([
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
                    Tabs::make('Notice Settings')->tabs([
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
                    Tabs::make('Image Settings')->tabs([
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
                    Tabs::make('Gallery Settings')->tabs([
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

            Block::make('comparison_slider')
                ->label('Before/After Slider')
                ->icon('heroicon-o-arrows-right-left')
                ->schema([
                    Tabs::make('Slider Settings')->tabs([
                        Tab::make('Images')->schema([
                            Grid::make(2)->schema([
                                FileUpload::make('before_image')->label('Before Image')->disk('public')->directory('comparison')->image()->required(),
                                FileUpload::make('after_image')->label('After Image')->disk('public')->directory('comparison')->image()->required(),
                            ]),
                            Grid::make(2)->schema([
                                TextInput::make('before_label')->label('Before Label')->default('Before'),
                                TextInput::make('after_label')->label('After Label')->default('After'),
                            ]),
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
                    Tabs::make('Video Settings')->tabs([
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

            Block::make('audio_player')
                ->label('Audio / Podcast (Media)')
                ->icon('heroicon-o-speaker-wave')
                ->schema([
                    Tabs::make('Audio Settings')->tabs([
                        Tab::make('Track')->schema([
                            TextInput::make('track_title')->label('Audio Title')->required(),
                            TextInput::make('artist')->label('Host / Artist'),
                            FileUpload::make('audio_file')->label('MP3 File')->disk('public')->directory('audio'),
                            TextInput::make('stream_url')->label('External Audio Stream URL'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('logo_cloud')
                ->label('Logo Cloud (Media)')
                ->icon('heroicon-o-squares-2x2')
                ->schema([
                    Tabs::make('Logo Settings')->tabs([
                        Tab::make('Logos')->schema([
                            TextInput::make('heading')->label('Eyebrow Title')->default('Trusted by top organizations'),
                            Repeater::make('logos')
                                ->schema([
                                    FileUpload::make('image')->disk('public')->directory('logos')->image()->required(),
                                    TextInput::make('alt')->label('Brand Name'),
                                    TextInput::make('link')->label('Link URL'),
                                ])->columns(3)->collapsible(),
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
                    Tabs::make('Button Settings')->tabs([
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
                    Tabs::make('Feature Settings')->tabs([
                        Tab::make('Content')->schema([
                            TextInput::make('icon')->label('Heroicon Name (e.g. academic-cap)')->default('sparkles'),
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

            Block::make('stats_overview')
                ->label('KPI Stats (Marketing)')
                ->icon('heroicon-o-chart-bar')
                ->schema([
                    Tabs::make('Stats Settings')->tabs([
                        Tab::make('Metrics')->schema([
                            Repeater::make('stats')
                                ->schema([
                                    TextInput::make('number')->label('Metric (e.g. 15,000+)')->required(),
                                    TextInput::make('label')->label('Metric Label')->required(),
                                    TextInput::make('description')->label('Detail Subtext'),
                                ])->columns(3)->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('testimonial')
                ->label('Testimonial (Marketing)')
                ->icon('heroicon-o-chat-bubble-bottom-center-text')
                ->schema([
                    Tabs::make('Testimonial Settings')->tabs([
                        Tab::make('Content')->schema([
                            Textarea::make('quote')->label('Quote')->rows(3)->required(),
                            Grid::make(3)->schema([
                                TextInput::make('author_name')->label('Author Name')->required(),
                                TextInput::make('author_title')->label('Role / Company'),
                                FileUpload::make('author_avatar')->disk('public')->directory('testimonials')->image(),
                            ]),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('team_member')
                ->label('Team Member Card')
                ->icon('heroicon-o-user-group')
                ->schema([
                    Tabs::make('Profile Settings')->tabs([
                        Tab::make('Bio')->schema([
                            Grid::make(2)->schema([
                                FileUpload::make('photo')->label('Profile Photo')->disk('public')->directory('team')->image()->required(),
                                TextInput::make('name')->label('Full Name')->required(),
                            ]),
                            Grid::make(2)->schema([
                                TextInput::make('role')->label('Role / Designation')->required(),
                                TextInput::make('department')->label('Department / Wing'),
                            ]),
                            Textarea::make('bio')->label('Short Bio')->rows(2),
                            Repeater::make('social_links')
                                ->schema([
                                    Select::make('platform')->options([
                                        'linkedin' => 'LinkedIn',
                                        'twitter'  => 'Twitter / X',
                                        'email'    => 'Email Address',
                                        'github'   => 'GitHub',
                                    ])->required(),
                                    TextInput::make('url')->label('Profile URL / Mailto')->required(),
                                ])->columns(2)->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('pricing_card')
                ->label('Pricing Tier (Marketing)')
                ->icon('heroicon-o-currency-dollar')
                ->schema([
                    Tabs::make('Pricing Tier')->tabs([
                        Tab::make('Plan Info')->schema([
                            Grid::make(3)->schema([
                                TextInput::make('plan_name')->label('Plan Name')->required(),
                                TextInput::make('price')->label('Price (e.g. $49)')->required(),
                                TextInput::make('billing_cycle')->label('Cycle')->default('/month'),
                            ]),
                            Toggle::make('is_featured')->label('Highlight as Recommended')->default(false),
                            Repeater::make('features')
                                ->schema([
                                    TextInput::make('feature_text')->label('Feature Included'),
                                ])->collapsible(),
                            Grid::make(2)->schema([
                                TextInput::make('button_text')->default('Subscribe Now'),
                                TextInput::make('button_url')->default('#'),
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
                    Tabs::make('FAQ Settings')->tabs([
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

            // --- 5. ACADEMIC & WORKFLOW ---
            Block::make('course_card')
                ->label('Course / Program Card')
                ->icon('heroicon-o-academic-cap')
                ->schema([
                    Tabs::make('Course Settings')->tabs([
                        Tab::make('Overview')->schema([
                            Grid::make(3)->schema([
                                TextInput::make('badge')->label('Grade / Level (e.g. Class 9-12)'),
                                TextInput::make('title')->label('Course Name')->required(),
                                TextInput::make('duration')->label('Duration (e.g. 2 Years)'),
                            ]),
                            Textarea::make('overview')->label('Program Description')->rows(2),
                            Repeater::make('curriculum_highlights')
                                ->schema([
                                    TextInput::make('subject')->label('Subject / Module'),
                                ])->collapsible(),
                            Grid::make(2)->schema([
                                TextInput::make('cta_text')->label('Button Label')->default('View Syllabus'),
                                TextInput::make('cta_url')->label('Button URL')->default('#'),
                            ]),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('process_steps')
                ->label('Step-by-Step Workflow')
                ->icon('heroicon-o-queue-list')
                ->schema([
                    Tabs::make('Workflow Settings')->tabs([
                        Tab::make('Steps')->schema([
                            TextInput::make('workflow_title')->label('Process Title (e.g. 4-Step Admission)'),
                            Repeater::make('steps')
                                ->schema([
                                    TextInput::make('step_number')->label('Step No (e.g. 01)')->required(),
                                    TextInput::make('title')->label('Step Title')->required(),
                                    Textarea::make('description')->label('Step Explanation')->rows(2),
                                ])->columns(3)->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('timeline')
                ->label('Timeline / Roadmap')
                ->icon('heroicon-o-clock')
                ->schema([
                    Tabs::make('Timeline Settings')->tabs([
                        Tab::make('Milestones')->schema([
                            TextInput::make('heading')->label('Timeline Title'),
                            Repeater::make('milestones')
                                ->schema([
                                    TextInput::make('date_or_step')->label('Date / Step / Milestone')->required(),
                                    TextInput::make('title')->label('Milestone Title')->required(),
                                    Textarea::make('description')->label('Description')->rows(2),
                                    TextInput::make('icon')->label('Tag Badge'),
                                ])->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('fee_structure')
                ->label('Fee Schedule Table')
                ->icon('heroicon-o-calculator')
                ->schema([
                    Tabs::make('Fee Schedule')->tabs([
                        Tab::make('Table')->schema([
                            TextInput::make('grade_category')->label('Category (e.g. Primary Wing 2026-27)')->required(),
                            Repeater::make('breakdown')
                                ->schema([
                                    TextInput::make('fee_head')->label('Fee Head (e.g. Tuition)')->required(),
                                    TextInput::make('frequency')->label('Frequency')->default('Quarterly'),
                                    TextInput::make('amount')->label('Amount (e.g. ₹15,000)')->required(),
                                ])->columns(3)->collapsible(),
                            TextInput::make('note')->label('Footnote Note'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('data_table')
                ->label('Responsive Data Table')
                ->icon('heroicon-o-table-cells')
                ->schema([
                    Tabs::make('Table Settings')->tabs([
                        Tab::make('Grid Data')->schema([
                            TextInput::make('table_caption')->label('Table Title / Caption'),
                            Repeater::make('columns')
                                ->schema([
                                    TextInput::make('col_name')->label('Column Header')->required(),
                                ])->columns(1)->collapsible(),
                            Repeater::make('rows')
                                ->schema([
                                    Repeater::make('cells')
                                        ->schema([
                                            TextInput::make('cell_value')->label('Cell Text')->required(),
                                        ])->columns(1),
                                ])->collapsible(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            // --- 6. FORMS, EVENTS & INTERACTION ---
            Block::make('contact_form')
                ->label('Lead Capture Form')
                ->icon('heroicon-o-envelope')
                ->schema([
                    Tabs::make('Form Settings')->tabs([
                        Tab::make('Fields')->schema([
                            TextInput::make('form_title')->label('Form Title')->default('Get in Touch'),
                            Textarea::make('form_subtitle')->label('Form Subtext')->rows(2),
                            TextInput::make('recipient_email')->label('Notification Target Email')->email(),
                            Grid::make(2)->schema([
                                Toggle::make('show_phone')->label('Include Phone Field')->default(true),
                                Toggle::make('show_attachments')->label('Allow File Uploads')->default(false),
                            ]),
                            TextInput::make('submit_btn_label')->label('Submit Button Text')->default('Submit Message'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('event_card')
                ->label('Event / Webinar Card')
                ->icon('heroicon-o-calendar')
                ->schema([
                    Tabs::make('Event Settings')->tabs([
                        Tab::make('Details')->schema([
                            FileUpload::make('event_banner')->disk('public')->directory('events')->image(),
                            Grid::make(3)->schema([
                                TextInput::make('event_date')->label('Date (e.g. Oct 15, 2026)')->required(),
                                TextInput::make('event_time')->label('Time (e.g. 10:00 AM)')->required(),
                                TextInput::make('venue')->label('Location / Online')->required(),
                            ]),
                            TextInput::make('event_title')->label('Event Title')->required(),
                            Textarea::make('description')->label('Summary')->rows(2),
                            TextInput::make('registration_url')->label('Registration Link')->default('#'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('countdown_timer')
                ->label('Countdown Timer')
                ->icon('heroicon-o-calendar-days')
                ->schema([
                    Tabs::make('Countdown Settings')->tabs([
                        Tab::make('Timer')->schema([
                            TextInput::make('event_name')->label('Event Name')->required(),
                            DateTimePicker::make('target_datetime')->label('Target Date & Time')->required(),
                            TextInput::make('completion_message')->label('Expired State Text')->default('This event has started!'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('job_posting')
                ->label('Career / Job Opening')
                ->icon('heroicon-o-briefcase')
                ->schema([
                    Tabs::make('Job Settings')->tabs([
                        Tab::make('Position')->schema([
                            Grid::make(3)->schema([
                                TextInput::make('job_title')->label('Role Title')->required(),
                                TextInput::make('department')->label('Department / Wing'),
                                Select::make('employment_type')
                                    ->options(['Full-time' => 'Full-time', 'Part-time' => 'Part-time', 'Contract' => 'Contract'])
                                    ->default('Full-time'),
                            ]),
                            TextInput::make('experience_required')->label('Experience Required'),
                            Textarea::make('responsibilities')->label('Key Responsibilities')->rows(3),
                            TextInput::make('apply_email_or_link')->label('Apply URL / Email Address')->required(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('download_card')
                ->label('PDF / Document Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->schema([
                    Tabs::make('Download Settings')->tabs([
                        Tab::make('Asset')->schema([
                            TextInput::make('resource_title')->label('Document Title')->required(),
                            TextInput::make('file_meta')->label('File Metadata (e.g. PDF • 4.2 MB)'),
                            FileUpload::make('file_asset')->label('File Asset')->disk('public')->directory('resources')->required(),
                            TextInput::make('cta_label')->label('Download Button Text')->default('Download Resource'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            // --- 7. CODE, EMBEDS & UTILITIES ---
            Block::make('code_block')
                ->label('Code Snippet (Syntax)')
                ->icon('heroicon-o-code-bracket')
                ->schema([
                    Tabs::make('Code Settings')->tabs([
                        Tab::make('Snippet')->schema([
                            Select::make('language')
                                ->options([
                                    'html'       => 'HTML',
                                    'css'        => 'CSS',
                                    'javascript' => 'JavaScript',
                                    'php'        => 'PHP',
                                    'python'     => 'Python',
                                    'json'       => 'JSON',
                                    'sql'        => 'SQL',
                                    'bash'       => 'Bash / Shell',
                                ])
                                ->default('php'),
                            Textarea::make('code')
                                ->label('Source Code')
                                ->rows(8)
                                ->required(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('map_embed')
                ->label('Google Maps Embed')
                ->icon('heroicon-o-map-pin')
                ->schema([
                    Tabs::make('Map Settings')->tabs([
                        Tab::make('Embed')->schema([
                            TextInput::make('location_title')->label('Location Name / Branch'),
                            Textarea::make('iframe_code')->label('Google Maps Embed Iframe Code')->required()->rows(3),
                            Select::make('map_height')->options([
                                'h-64'      => 'Compact (256px)',
                                'h-96'      => 'Standard (384px)',
                                'h-[500px]' => 'Large Canvas (500px)',
                            ])->default('h-96'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('social_feed')
                ->label('Social Proof Embed')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->schema([
                    Tabs::make('Embed Settings')->tabs([
                        Tab::make('Feed Code')->schema([
                            Select::make('network')
                                ->options([
                                    'instagram' => 'Instagram Post/Reel',
                                    'twitter'   => 'Twitter/X Post',
                                    'facebook'  => 'Facebook Post',
                                    'linkedin'  => 'LinkedIn Post',
                                ])->default('instagram'),
                            Textarea::make('embed_html')->label('Direct Embed Code / Iframe')->rows(4)->required(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('raw_html')
                ->label('Raw HTML / Canvas')
                ->icon('heroicon-o-code-bracket-square')
                ->schema([
                    Tabs::make('HTML Settings')->tabs([
                        Tab::make('Code')->schema([
                            Textarea::make('html_code')
                                ->label('Custom HTML / SVG / JS Snippet')
                                ->rows(8)
                                ->required(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

            Block::make('spacer')
                ->label('Spacer / Divider')
                ->icon('heroicon-o-arrows-up-down')
                ->schema([
                    Select::make('height')->options([
                        'h-4'  => 'Small (16px)',
                        'h-8'  => 'Medium (32px)',
                        'h-16' => 'Large (64px)',
                        'h-24' => 'Extra Large (96px)',
                        'h-32' => 'Massive (128px)',
                    ])->default('h-8'),
                    Toggle::make('show_divider')->label('Render Divider Line')->default(false),
                ]),

            // 1. Infinite Scrolling Marquee (Text / Logos / Badges)
            Block::make('marquee')
                ->label('Infinite Marquee Ticker')
                ->icon('heroicon-o-arrow-path')
                ->schema([
                    Tabs::make('Marquee Configuration')->tabs([
                        // Tab 1: Content Items
                        Tab::make('Ticker Items')
                            ->icon('heroicon-o-queue-list')
                            ->schema([
                                Repeater::make('items')
                                    ->label('Ticker Items & Badges')
                                    ->schema([
                                        TextInput::make('text')
                                            ->label('Ticker Headline / Text')
                                            ->required()->columnSpan(3),
                                        TextInput::make('url')
                                            ->label('Destination Link URL (Optional)')->columnSpan(2),
                                    ])
                                    ->columns(5)
                                    ->collapsible(),
                            ]),

                        // Tab 2: Movement & Animation Controls
                        Tab::make('Motion Controls')
                            ->icon('heroicon-o-play')
                            ->schema([
                                Grid::make(3)->schema([
                                    Select::make('direction')
                                        ->label('Scroll Direction')
                                        ->options([
                                            'left'  => 'Scroll Left (Standard)',
                                            'right' => 'Scroll Right (Reverse)',
                                        ])
                                        ->default('left'),

                                    Select::make('speed')
                                        ->label('Scroll Velocity')
                                        ->options([
                                            'slow'   => 'Slow (45s)',
                                            'normal' => 'Standard (25s)',
                                            'fast'   => 'Fast (12s)',
                                        ])
                                        ->default('normal'),

                                    Select::make('gap')
                                        ->label('Spacing Between Items')
                                        ->options([
                                            'gap-6'  => 'Compact (24px)',
                                            'gap-10' => 'Standard (40px)',
                                            'gap-16' => 'Spacious (64px)',
                                        ])
                                        ->default('gap-10'),
                                ]),

                                Toggle::make('pause_on_hover')
                                    ->label('Pause scrolling when hovered by mouse')
                                    ->default(true),
                            ]),

                        // Tab 3: Universal Styling Suite
                        Tab::make('Design & Surface')
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                StyleHelper::makeStyleEngine('styles'),
                            ]),
                    ]),
                ]),

// 2. Animated Number / KPI Counter (Rolls up on scroll)
            Block::make('animated_counter')
                ->label('Animated KPI Roll-Up')
                ->icon('heroicon-o-variable')
                ->schema([
                    Tabs::make('Counter Settings')->tabs([
                        Tab::make('Metrics')->schema([
                            Grid::make(3)->schema([
                                TextInput::make('start_number')->label('Start Value')->default('0')->numeric(),
                                TextInput::make('target_number')->label('Target Value (e.g. 500)')->required()->numeric(),
                                TextInput::make('suffix')->label('Suffix (e.g. +, %, M, k)')->default('+'),
                            ]),
                            TextInput::make('title')->label('Metric Headline')->required(),
                            TextInput::make('description')->label('Supporting Text'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

// 3. Lottie / Vector JSON Animation Player
            Block::make('lottie_animation')
                ->label('Lottie Animation Player')
                ->icon('heroicon-o-film')
                ->schema([
                    Tabs::make('Animation Settings')->tabs([
                        Tab::make('Source')->schema([
                            TextInput::make('lottie_url')->label('Lottie JSON Asset URL')->placeholder('https://assets.lottiefiles.com/.../data.json')->required(),
                            Grid::make(3)->schema([
                                Toggle::make('autoplay')->label('Autoplay')->default(true),
                                Toggle::make('loop')->label('Loop Continuously')->default(true),
                                Select::make('max_width')->options(['max-w-xs' => 'Small', 'max-w-md' => 'Medium', 'max-w-xl' => 'Large'])->default('max-w-md'),
                            ]),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

// 4. Modal / Lightbox Trigger Button
            Block::make('modal_trigger')
                ->label('Popup Modal Box')
                ->icon('heroicon-o-window')
                ->schema([
                    Tabs::make('Modal Settings')->tabs([
                        Tab::make('Trigger & Dialog')->schema([
                            TextInput::make('button_label')->label('Trigger Button Label')->default('Open Details')->required(),
                            TextInput::make('modal_title')->label('Modal Header Title')->required(),
                            RichEditor::make('modal_content')->label('Modal Window Content')->required(),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

// 5. Star Rating & Customer Review Card
            Block::make('star_rating')
                ->label('Star Rating / Badge')
                ->icon('heroicon-o-star')
                ->schema([
                    Tabs::make('Rating Settings')->tabs([
                        Tab::make('Content')->schema([
                            Select::make('rating')
                                ->options(['5' => '5 Stars ★★★★★', '4.5' => '4.5 Stars', '4' => '4 Stars ★★★★☆'])
                                ->default('5'),
                            TextInput::make('headline')->label('Review Summary Headline')->required(),
                            Textarea::make('review_text')->label('Review Body')->rows(2),
                            TextInput::make('reviewer')->label('Customer / Organization Name'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),

// 6. Responsive PDF / Document Embedder (In-page Viewer)
            Block::make('pdf_viewer')
                ->label('Inline PDF Viewer Frame')
                ->icon('heroicon-o-document-text')
                ->schema([
                    Tabs::make('PDF Settings')->tabs([
                        Tab::make('File')->schema([
                            FileUpload::make('pdf_file')->label('Upload PDF Document')->disk('public')->directory('documents')->required(),
                            Select::make('frame_height')->options(['h-96' => 'Medium (384px)', 'h-[600px]' => 'Large (600px)', 'h-[800px]' => 'Full Screen (800px)'])->default('h-[600px]'),
                        ]),
                        Tab::make('Design')->schema([
                            StyleHelper::makeStyleEngine('styles'),
                        ]),
                    ]),
                ]),
        ];
    }
}
