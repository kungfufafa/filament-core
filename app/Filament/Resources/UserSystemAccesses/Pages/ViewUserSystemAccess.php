<?php

namespace App\Filament\Resources\UserSystemAccesses\Pages;

use App\Filament\Resources\UserSystemAccesses\UserSystemAccessResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewUserSystemAccess extends ViewRecord
{
    protected static string $resource = UserSystemAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
