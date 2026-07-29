<?php

namespace App\Filament\Resources\SystemAvailablePermissions;

use App\Filament\Resources\SystemAvailablePermissions\Pages\CreateSystemAvailablePermission;
use App\Filament\Resources\SystemAvailablePermissions\Pages\EditSystemAvailablePermission;
use App\Filament\Resources\SystemAvailablePermissions\Pages\ListSystemAvailablePermissions;
use App\Filament\Resources\SystemAvailablePermissions\Pages\ViewSystemAvailablePermission;
use App\Filament\Resources\SystemAvailablePermissions\Schemas\SystemAvailablePermissionForm;
use App\Filament\Resources\SystemAvailablePermissions\Schemas\SystemAvailablePermissionInfolist;
use App\Filament\Resources\SystemAvailablePermissions\Tables\SystemAvailablePermissionsTable;
use App\Models\SystemAvailablePermission;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SystemAvailablePermissionResource extends Resource
{
    protected static ?string $model = SystemAvailablePermission::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedKey;

    public static function form(Schema $schema): Schema
    {
        return SystemAvailablePermissionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SystemAvailablePermissionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SystemAvailablePermissionsTable::configure($table);
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
            'index' => ListSystemAvailablePermissions::route('/'),
            'create' => CreateSystemAvailablePermission::route('/create'),
            'view' => ViewSystemAvailablePermission::route('/{record}'),
            'edit' => EditSystemAvailablePermission::route('/{record}/edit'),
        ];
    }
}
