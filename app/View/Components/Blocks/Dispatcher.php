<?php

namespace App\View\Components\Blocks;

use Illuminate\View\Component;
use Illuminate\View\View;

class Dispatcher extends Component
{
    public array $block;

    public function __construct(array $block)
    {
        $this->block = $block;
    }

    public function render(): View|string
    {
        $type = $this->block['type'] ?? null;
        $data = $this->block['data'] ?? [];

        // Converts camelCase (e.g. logoCloud, videoEmbed) to kebab-case (e.g. logo-cloud, video-embed)
        $kebabType = str()->kebab($type);

        if (view()->exists("components.blocks.{$kebabType}")) {
            return view("components.blocks.{$kebabType}", ['data' => $data]);
        }

        return '';
    }
}
