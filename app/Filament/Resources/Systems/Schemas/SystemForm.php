<?php

namespace App\Filament\Resources\Systems\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SystemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('base_url')
                    ->url(),
                TextInput::make('oauth_client_id')
                    ->label('OAuth Client ID')
                    ->helperText('Client ID generated from Laravel Passport for this System'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
