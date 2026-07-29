<?php

namespace App\Filament\Resources\UserSystemPermissions\Pages;

use App\Filament\Resources\UserSystemPermissions\UserSystemPermissionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserSystemPermission extends ViewRecord
{
    protected static string $resource = UserSystemPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
