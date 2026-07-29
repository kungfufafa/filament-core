<?php

namespace App\Filament\Resources\UserSystemPermissions;

use App\Filament\Resources\UserSystemPermissions\Pages\CreateUserSystemPermission;
use App\Filament\Resources\UserSystemPermissions\Pages\EditUserSystemPermission;
use App\Filament\Resources\UserSystemPermissions\Pages\ListUserSystemPermissions;
use App\Filament\Resources\UserSystemPermissions\Pages\ViewUserSystemPermission;
use App\Filament\Resources\UserSystemPermissions\Schemas\UserSystemPermissionForm;
use App\Filament\Resources\UserSystemPermissions\Schemas\UserSystemPermissionInfolist;
use App\Filament\Resources\UserSystemPermissions\Tables\UserSystemPermissionsTable;
use App\Models\UserSystemPermission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserSystemPermissionResource extends Resource
{
    protected static ?string $model = UserSystemPermission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    public static function form(Schema $schema): Schema
    {
        return UserSystemPermissionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserSystemPermissionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserSystemPermissionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserSystemPermissions::route('/'),
            'create' => CreateUserSystemPermission::route('/create'),
            'view' => ViewUserSystemPermission::route('/{record}'),
            'edit' => EditUserSystemPermission::route('/{record}/edit'),
        ];
    }
}
