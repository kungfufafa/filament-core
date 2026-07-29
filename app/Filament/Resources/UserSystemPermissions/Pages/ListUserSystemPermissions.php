<?php

namespace App\Filament\Resources\UserSystemPermissions\Pages;

use App\Filament\Resources\UserSystemPermissions\UserSystemPermissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserSystemPermissions extends ListRecords
{
    protected static string $resource = UserSystemPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
