<?php

namespace App\Filament\Resources\UserSystemAccesses\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserSystemAccessInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('system.name')
                    ->label('System'),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('granted_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('granted_by')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
