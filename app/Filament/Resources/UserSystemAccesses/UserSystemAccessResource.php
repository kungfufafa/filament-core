<?php

namespace App\Filament\Resources\UserSystemAccesses;

use App\Filament\Resources\UserSystemAccesses\Pages\CreateUserSystemAccess;
use App\Filament\Resources\UserSystemAccesses\Pages\EditUserSystemAccess;
use App\Filament\Resources\UserSystemAccesses\Pages\ListUserSystemAccesses;
use App\Filament\Resources\UserSystemAccesses\Pages\ViewUserSystemAccess;
use App\Filament\Resources\UserSystemAccesses\Schemas\UserSystemAccessForm;
use App\Filament\Resources\UserSystemAccesses\Schemas\UserSystemAccessInfolist;
use App\Filament\Resources\UserSystemAccesses\Tables\UserSystemAccessesTable;
use App\Models\UserSystemAccess;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UserSystemAccessResource extends Resource
{
    protected static ?string $model = UserSystemAccess::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return UserSystemAccessForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserSystemAccessInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserSystemAccessesTable::configure($table);
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
            'index' => ListUserSystemAccesses::route('/'),
            'create' => CreateUserSystemAccess::route('/create'),
            'view' => ViewUserSystemAccess::route('/{record}'),
            'edit' => EditUserSystemAccess::route('/{record}/edit'),
        ];
    }
}
