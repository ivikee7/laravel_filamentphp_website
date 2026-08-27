<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class SeoAnalyzer extends Field
{
    protected string $view = 'filament.forms.components.seo-analyzer';

    public static function make(?string $name = 'seo_analysis'): static
    {
        return parent::make($name);
    }
}
