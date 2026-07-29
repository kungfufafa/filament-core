<?php

namespace App\Filament\Resources\UserSystemPermissions\Pages;

use App\Filament\Resources\UserSystemPermissions\UserSystemPermissionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUserSystemPermission extends EditRecord
{
    protected static string $resource = UserSystemPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
