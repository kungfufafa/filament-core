<?php

namespace Tests\Feature;

use App\Models\System;
use App\Models\SystemAvailablePermission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CoreAccessManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_core_creates_the_access_management_tables(): void
    {
        $this->assertTrue(Schema::hasTable('systems'));
        $this->assertTrue(Schema::hasTable('user_system_access'));
        $this->assertTrue(Schema::hasTable('user_system_roles'));
        $this->assertTrue(Schema::hasTable('system_available_permissions'));
    }

    public function test_database_seeder_registers_the_shelf_system(): void
    {
        Artisan::call('db:seed');

        $this->assertDatabaseHas('systems', [
            'code' => 'shelf',
            'is_active' => true,
        ]);
    }

    public function test_user_can_be_assigned_access_and_a_role_for_a_system(): void
    {
        $user = User::factory()->create();
        $system = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);

        $access = $user->systemAccesses()->create([
            'system_id' => $system->id,
            'is_active' => true,
            'granted_at' => now(),
        ]);

        $role = $user->systemRoles()->create([
            'system_id' => $system->id,
            'role_code' => 'manager',
        ]);

        $this->assertTrue($access->system->is($system));
        $this->assertTrue($role->system->is($system));
        $this->assertSame('manager', $user->systemRoles->sole()->role_code);
    }

    public function test_core_registers_admin_resources_for_system_access_management(): void
    {
        $this->assertTrue(Route::has('filament.admin.resources.systems.index'));
        $this->assertTrue(Route::has('filament.admin.resources.user-system-accesses.index'));
        $this->assertTrue(Route::has('filament.admin.resources.user-system-roles.index'));
        $this->assertTrue(Route::has('filament.admin.resources.user-system-permissions.index'));
        $this->assertTrue(Route::has('filament.admin.resources.system-available-permissions.index'));
    }

    public function test_satellite_can_register_permissions(): void
    {
        $system = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);

        $user = User::factory()->create(['is_active' => true]);
        Sanctum::actingAs($user);

        $this->postJson("/api/systems/shelf/permissions", [
            'permissions' => [
                ['permission' => 'ViewAny:ShelfItem', 'label' => 'View Any Shelf Item'],
                ['permission' => 'Create:ShelfItem', 'label' => 'Create Shelf Item'],
                ['permission' => 'Update:ShelfItem', 'label' => 'Update Shelf Item'],
            ],
        ])
            ->assertOk()
            ->assertJsonPath('synced', 3);

        $this->assertDatabaseCount('system_available_permissions', 3);
        $this->assertDatabaseHas('system_available_permissions', [
            'system_id' => $system->id,
            'permission' => 'ViewAny:ShelfItem',
            'label' => 'View Any Shelf Item',
        ]);
    }

    public function test_satellite_reregistration_removes_stale_permissions(): void
    {
        $system = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);

        SystemAvailablePermission::create([
            'system_id' => $system->id,
            'permission' => 'OldPermission:Removed',
            'label' => 'Old Permission',
        ]);

        $user = User::factory()->create(['is_active' => true]);
        Sanctum::actingAs($user);

        $this->postJson("/api/systems/shelf/permissions", [
            'permissions' => [
                ['permission' => 'ViewAny:ShelfItem', 'label' => 'View Any Shelf Item'],
            ],
        ])->assertOk();

        $this->assertDatabaseCount('system_available_permissions', 1);
        $this->assertDatabaseMissing('system_available_permissions', [
            'permission' => 'OldPermission:Removed',
        ]);
        $this->assertDatabaseHas('system_available_permissions', [
            'permission' => 'ViewAny:ShelfItem',
        ]);
    }

    public function test_seeder_creates_all_five_systems(): void
    {
        Artisan::call('db:seed');

        foreach (['shelf', 'helpdesk', 'dnd', 'talent', 'document'] as $code) {
            $this->assertDatabaseHas('systems', ['code' => $code, 'is_active' => true]);
        }
    }
}
