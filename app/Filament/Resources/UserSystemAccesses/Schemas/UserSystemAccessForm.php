<?php

namespace App\Filament\Resources\UserSystemAccesses\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserSystemAccessForm
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
                Toggle::make('is_active')
                    ->required(),
                DateTimePicker::make('granted_at'),
                TextInput::make('granted_by')
                    ->numeric(),
            ]);
    }
}
