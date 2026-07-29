<?php

namespace App\Filament\Resources\UserSystemRoles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserSystemRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('system_id')
                    ->relationship('system', 'name')
                    ->required(),
                TextInput::make('role_code')
                    ->required(),
            ]);
    }
}
