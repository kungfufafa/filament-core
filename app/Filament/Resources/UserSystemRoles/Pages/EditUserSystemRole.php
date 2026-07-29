<?php

namespace App\Filament\Resources\UserSystemRoles\Pages;

use App\Filament\Resources\UserSystemRoles\UserSystemRoleResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUserSystemRole extends EditRecord
{
    protected static string $resource = UserSystemRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
