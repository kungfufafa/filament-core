<?php

namespace App\Filament\Resources\UserSystemRoles\Pages;

use App\Filament\Resources\UserSystemRoles\UserSystemRoleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserSystemRole extends ViewRecord
{
    protected static string $resource = UserSystemRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
