<?php

namespace App\Filament\Resources\SystemAvailablePermissions\Pages;

use App\Filament\Resources\SystemAvailablePermissions\SystemAvailablePermissionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSystemAvailablePermission extends ViewRecord
{
    protected static string $resource = SystemAvailablePermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
