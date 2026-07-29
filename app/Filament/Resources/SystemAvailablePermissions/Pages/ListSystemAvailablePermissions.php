<?php

namespace App\Filament\Resources\SystemAvailablePermissions\Pages;

use App\Filament\Resources\SystemAvailablePermissions\SystemAvailablePermissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSystemAvailablePermissions extends ListRecords
{
    protected static string $resource = SystemAvailablePermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
