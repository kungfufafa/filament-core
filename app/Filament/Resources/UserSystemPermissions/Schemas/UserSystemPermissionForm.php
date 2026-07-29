<?php

namespace App\Filament\Resources\UserSystemPermissions\Schemas;

use App\Models\SystemAvailablePermission;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Schemas\Schema;

class UserSystemPermissionForm
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
                    ->live()
                    ->required(),
                Select::make('permission')
                    ->options(fn (Get $get) => SystemAvailablePermission::query()
                        ->where('system_id', $get('system_id'))
                        ->pluck('label', 'permission')
                        ->toArray()
                    )
                    ->required(),
            ]);
    }
}
