<?php

namespace App\Filament\Resources\UserSystemRoles\Pages;

use App\Filament\Resources\UserSystemRoles\UserSystemRoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserSystemRoles extends ListRecords
{
    protected static string $resource = UserSystemRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
