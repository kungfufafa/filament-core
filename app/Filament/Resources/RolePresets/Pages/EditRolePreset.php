<?php

namespace App\Filament\Resources\RolePresets\Pages;

use App\Filament\Resources\RolePresets\RolePresetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRolePreset extends EditRecord
{
    protected static string $resource = RolePresetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
