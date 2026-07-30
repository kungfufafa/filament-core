<?php

namespace Tests\Feature;

use App\Models\RolePreset;
use App\Models\System;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePresetTest extends TestCase
{
    use RefreshDatabase;

    public function test_applies_preset_to_user(): void
    {
        $user = User::factory()->create();
        $system = System::create(['code' => 'sys1', 'name' => 'Sys1', 'is_active' => true]);
        
        $preset = RolePreset::create(['name' => 'Manager']);
        $preset->permissions()->createMany([
            ['system_id' => $system->id, 'permission' => 'View:Report'],
            ['system_id' => $system->id, 'permission' => 'Create:Report'],
        ]);

        // Action simulating the Apply Preset process
        foreach ($preset->permissions as $presetPerm) {
            $user->systemPermissions()->firstOrCreate([
                'system_id' => $presetPerm->system_id,
                'permission' => $presetPerm->permission,
            ]);
        }

        $this->assertDatabaseCount('user_system_permissions', 2);
        $this->assertDatabaseHas('user_system_permissions', [
            'user_id' => $user->id,
            'system_id' => $system->id,
            'permission' => 'View:Report',
        ]);
        $this->assertDatabaseHas('user_system_permissions', [
            'user_id' => $user->id,
            'system_id' => $system->id,
            'permission' => 'Create:Report',
        ]);
    }
}
