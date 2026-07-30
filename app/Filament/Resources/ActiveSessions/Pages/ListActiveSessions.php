<?php

namespace App\Filament\Resources\ActiveSessions\Pages;

use App\Filament\Resources\ActiveSessions\ActiveSessionResource;
use Filament\Resources\Pages\ListRecords;

class ListActiveSessions extends ListRecords
{
    protected static string $resource = ActiveSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
