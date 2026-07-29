<?php

namespace App\Filament\Resources\UserSystemRoles;

use App\Filament\Resources\UserSystemRoles\Pages\CreateUserSystemRole;
use App\Filament\Resources\UserSystemRoles\Pages\EditUserSystemRole;
use App\Filament\Resources\UserSystemRoles\Pages\ListUserSystemRoles;
use App\Filament\Resources\UserSystemRoles\Pages\ViewUserSystemRole;
use App\Filament\Resources\UserSystemRoles\Schemas\UserSystemRoleForm;
use App\Filament\Resources\UserSystemRoles\Schemas\UserSystemRoleInfolist;
use App\Filament\Resources\UserSystemRoles\Tables\UserSystemRolesTable;
use App\Models\UserSystemRole;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserSystemRoleResource extends Resource
{
    protected static ?string $model = UserSystemRole::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UserSystemRoleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserSystemRoleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserSystemRolesTable::configure($table);
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
            'index' => ListUserSystemRoles::route('/'),
            'create' => CreateUserSystemRole::route('/create'),
            'view' => ViewUserSystemRole::route('/{record}'),
            'edit' => EditUserSystemRole::route('/{record}/edit'),
        ];
    }
}
