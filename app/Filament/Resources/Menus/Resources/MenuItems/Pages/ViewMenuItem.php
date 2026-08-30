<?php

namespace App\Filament\Resources\Menus\Resources\MenuItems\Pages;

use App\Filament\Resources\Menus\Resources\MenuItems\MenuItemResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMenuItem extends ViewRecord
{
    protected static string $resource = MenuItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
