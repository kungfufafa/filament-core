<?php

namespace App\Filament\Resources\UserSystemAccesses\Pages;

use App\Filament\Resources\UserSystemAccesses\UserSystemAccessResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListUserSystemAccesses extends ListRecords
{
    protected static string $resource = UserSystemAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
