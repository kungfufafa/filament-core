<?php

namespace App\Filament\Resources\ActiveSessions;

use App\Filament\Resources\ActiveSessions\Pages\ListActiveSessions;
use Laravel\Passport\Token;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

class ActiveSessionResource extends Resource
{
    protected static ?string $model = Token::class;
    
    protected static ?string $modelLabel = 'Active Session';
    protected static ?string $pluralModelLabel = 'Active Sessions';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;
    protected static \UnitEnum|string|null $navigationGroup = 'Security';
    protected static ?int $navigationSort = 11;

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->where('revoked', false))
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('client.name')
                    ->label('Application (Client)')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Login Time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->label('Expires')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Action::make('revoke')
                    ->label('Revoke (Kick Out)')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (Token $record) => $record->revoke())
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActiveSessions::route('/'),
        ];
    }
}
