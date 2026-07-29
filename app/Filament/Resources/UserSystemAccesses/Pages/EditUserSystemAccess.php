<?php

namespace App\Filament\Resources\UserSystemAccesses\Pages;

use App\Filament\Resources\UserSystemAccesses\UserSystemAccessResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditUserSystemAccess extends EditRecord
{
    protected static string $resource = UserSystemAccessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
