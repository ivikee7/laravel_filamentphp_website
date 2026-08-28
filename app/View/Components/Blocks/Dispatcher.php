<?php

namespace App\View\Components\Blocks;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dispatcher extends Component
{
    public function __construct(
        public array|null $blocks = []
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.blocks.dispatcher');
    }
}
