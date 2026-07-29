<?php

namespace App\Filament\Resources\SystemAvailablePermissions\Pages;

use App\Filament\Resources\SystemAvailablePermissions\SystemAvailablePermissionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSystemAvailablePermission extends EditRecord
{
    protected static string $resource = SystemAvailablePermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
