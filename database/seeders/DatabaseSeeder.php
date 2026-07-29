<?php

namespace Database\Seeders;

use App\Models\System;
use App\Models\SystemAvailablePermission;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'is_active' => true,
        ]);

        $budi = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'is_active' => true,
        ]);

        $ani = User::factory()->create([
            'name' => 'Ani Wijaya',
            'email' => 'ani@example.com',
            'is_active' => true,
        ]);

        $systems = [
            'shelf' => 'Shelf',
            'helpdesk' => 'Helpdesk',
            'dnd' => 'DnD',
            'talent' => 'Talent',
            'document' => 'Document',
        ];

        $createdSystems = [];

        foreach ($systems as $code => $name) {
            $system = System::query()->updateOrCreate(
                ['code' => $code],
                [
                    'name' => $name,
                    'base_url' => "https://{$code}.test",
                    'is_active' => true,
                ],
            );

            // Register default available permissions for each system
            $permissions = [
                "ViewAny:{$name}Item" => "View Any {$name} Item",
                "Create:{$name}Item" => "Create {$name} Item",
                "Update:{$name}Item" => "Update {$name} Item",
                "Delete:{$name}Item" => "Delete {$name} Item",
            ];

            foreach ($permissions as $perm => $label) {
                SystemAvailablePermission::updateOrCreate(
                    ['system_id' => $system->id, 'permission' => $perm],
                    ['label' => $label]
                );
            }

            $createdSystems[$code] = $system;
        }

        // Admin: full access to ALL systems
        foreach ($createdSystems as $system) {
            $admin->systemAccesses()->updateOrCreate(
                ['system_id' => $system->id],
                ['is_active' => true, 'granted_at' => now()],
            );
            $availablePerms = SystemAvailablePermission::where('system_id', $system->id)->pluck('permission');
            foreach ($availablePerms as $permission) {
                $admin->systemPermissions()->firstOrCreate([
                    'system_id' => $system->id,
                    'permission' => $permission,
                ]);
            }
        }

        // Budi: full access to Shelf, view-only on Helpdesk
        $budi->systemAccesses()->updateOrCreate(
            ['system_id' => $createdSystems['shelf']->id],
            ['is_active' => true, 'granted_at' => now()],
        );
        $shelfPerms = SystemAvailablePermission::where('system_id', $createdSystems['shelf']->id)->pluck('permission');
        foreach ($shelfPerms as $permission) {
            $budi->systemPermissions()->firstOrCreate([
                'system_id' => $createdSystems['shelf']->id,
                'permission' => $permission,
            ]);
        }

        $budi->systemAccesses()->updateOrCreate(
            ['system_id' => $createdSystems['helpdesk']->id],
            ['is_active' => true, 'granted_at' => now()],
        );
        $budi->systemPermissions()->firstOrCreate([
            'system_id' => $createdSystems['helpdesk']->id,
            'permission' => 'ViewAny:HelpdeskItem',
        ]);

        // Ani: view + create on DnD
        $ani->systemAccesses()->updateOrCreate(
            ['system_id' => $createdSystems['dnd']->id],
            ['is_active' => true, 'granted_at' => now()],
        );
        foreach (['ViewAny:DnDItem', 'Create:DnDItem'] as $permission) {
            $ani->systemPermissions()->firstOrCreate([
                'system_id' => $createdSystems['dnd']->id,
                'permission' => $permission,
            ]);
        }
    }
}
