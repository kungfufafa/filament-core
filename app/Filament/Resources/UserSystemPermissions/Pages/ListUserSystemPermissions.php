<?php

namespace App\Filament\Resources\UserSystemPermissions\Pages;

use App\Filament\Resources\UserSystemPermissions\UserSystemPermissionResource;
use App\Models\RolePreset;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;

class ListUserSystemPermissions extends ListRecords
{
    protected static string $resource = UserSystemPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('applyPreset')
                ->label('Apply Preset')
                ->icon('heroicon-o-swatch')
                ->form([
                    Select::make('user_id')
                        ->label('Target User')
                        ->options(User::query()->pluck('name', 'id'))
                        ->required()
                        ->searchable(),
                    Select::make('preset_id')
                        ->label('Role Preset')
                        ->options(RolePreset::query()->pluck('name', 'id'))
                        ->required()
                        ->searchable(),
                ])
                ->action(function (array $data) {
                    $user = User::findOrFail($data['user_id']);
                    $preset = RolePreset::with('permissions')->findOrFail($data['preset_id']);
                    
                    $count = 0;
                    foreach ($preset->permissions as $presetPerm) {
                        $user->systemAccesses()->firstOrCreate([
                            'system_id' => $presetPerm->system_id,
                        ], ['is_active' => true, 'granted_at' => now()]);

                        $created = $user->systemPermissions()->firstOrCreate([
                            'system_id' => $presetPerm->system_id,
                            'permission' => $presetPerm->permission,
                        ]);
                        
                        if ($created->wasRecentlyCreated) {
                            $count++;
                        }
                    }

                    \Filament\Notifications\Notification::make()
                        ->title("Preset Applied")
                        ->body("Successfully assigned {$count} new permissions to {$user->name}.")
                        ->success()
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
