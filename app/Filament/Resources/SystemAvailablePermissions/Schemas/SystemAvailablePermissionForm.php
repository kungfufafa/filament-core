<?php

namespace App\Filament\Resources\SystemAvailablePermissions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SystemAvailablePermissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('system_id')
                    ->relationship('system', 'name')
                    ->required(),
                TextInput::make('permission')
                    ->required()
                    ->maxLength(255),
                TextInput::make('label')
                    ->maxLength(255),
            ]);
    }
}
