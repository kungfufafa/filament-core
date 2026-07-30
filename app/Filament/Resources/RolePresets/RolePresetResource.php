<?php

namespace App\Filament\Resources\RolePresets;

use App\Filament\Resources\RolePresets\Pages\CreateRolePreset;
use App\Filament\Resources\RolePresets\Pages\EditRolePreset;
use App\Filament\Resources\RolePresets\Pages\ListRolePresets;
use App\Models\RolePreset;
use App\Models\SystemAvailablePermission;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Schemas\Schema;
use UnitEnum;
use BackedEnum;

class RolePresetResource extends Resource
{
    protected static ?string $model = RolePreset::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-swatch';
    protected static string|UnitEnum|null $navigationGroup = 'Access Management';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description')
                    ->maxLength(255),
                Repeater::make('permissions')
                    ->relationship()
                    ->schema([
                        Select::make('system_id')
                            ->relationship('system', 'name')
                            ->required()
                            ->live(),
                        Select::make('permission')
                            ->options(fn (Get $get) => SystemAvailablePermission::query()
                                ->where('system_id', $get('system_id'))
                                ->pluck('label', 'permission')
                                ->toArray()
                            )
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('description'),
                TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label('Permissions'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRolePresets::route('/'),
            'create' => CreateRolePreset::route('/create'),
            'edit' => EditRolePreset::route('/{record}/edit'),
        ];
    }
}
