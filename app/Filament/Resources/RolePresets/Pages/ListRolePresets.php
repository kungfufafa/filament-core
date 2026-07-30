<?php

namespace App\Filament\Resources\RolePresets\Pages;

use App\Filament\Resources\RolePresets\RolePresetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRolePresets extends ListRecords
{
    protected static string $resource = RolePresetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
