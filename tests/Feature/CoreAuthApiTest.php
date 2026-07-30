<?php

namespace Tests\Feature;

use App\Models\System;
use App\Models\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoreAuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_a_token_for_an_active_user_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'budi@example.com',
            'password' => 'secret-password',
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'secret-password',
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user' => ['id', 'name', 'email', 'is_active'],
            ]);
    }

    public function test_login_rejects_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'budi@example.com',
            'password' => 'secret-password',
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'budi@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }

    public function test_me_returns_the_authenticated_user(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        Passport::actingAs($user);

        $this->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.email', $user->email);
    }

    public function test_my_systems_returns_only_active_system_accesses(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $allowedSystem = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);
        $inactiveMembershipSystem = System::create([
            'code' => 'helpdesk',
            'name' => 'Helpdesk',
            'base_url' => 'https://helpdesk.test',
            'is_active' => true,
        ]);

        $user->systemAccesses()->create([
            'system_id' => $allowedSystem->id,
            'is_active' => true,
            'granted_at' => now(),
        ]);

        $user->systemAccesses()->create([
            'system_id' => $inactiveMembershipSystem->id,
            'is_active' => false,
            'granted_at' => now(),
        ]);

        Passport::actingAs($user);

        $this->getJson('/api/my-systems')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.code', 'shelf');
    }

    public function test_system_access_check_returns_allowed_state_and_role_for_an_active_user(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $system = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);

        $user->systemAccesses()->create([
            'system_id' => $system->id,
            'is_active' => true,
            'granted_at' => now(),
        ]);

        $user->systemRoles()->create([
            'system_id' => $system->id,
            'role_code' => 'manager',
        ]);

        Passport::actingAs($user);

        $this->postJson('/api/system-access/check', [
            'system_code' => 'shelf',
        ])
            ->assertOk()
            ->assertJsonPath('allowed', true)
            ->assertJsonPath('system_role', 'manager')
            ->assertJsonPath('user.id', $user->id);
    }

    public function test_system_access_check_returns_permissions_for_active_user(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $system = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);

        $user->systemAccesses()->create([
            'system_id' => $system->id,
            'is_active' => true,
            'granted_at' => now(),
        ]);

        $user->systemPermissions()->createMany([
            ['system_id' => $system->id, 'permission' => 'view'],
            ['system_id' => $system->id, 'permission' => 'create'],
            ['system_id' => $system->id, 'permission' => 'update'],
        ]);

        Passport::actingAs($user);

        $this->postJson('/api/system-access/check', [
            'system_code' => 'shelf',
        ])
            ->assertOk()
            ->assertJsonPath('allowed', true)
            ->assertJsonStructure(['permissions'])
            ->assertJsonCount(3, 'permissions')
            ->assertJsonFragment(['permissions' => ['view', 'create', 'update']]);
    }

    public function test_system_access_check_returns_empty_permissions_when_none_assigned(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $system = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);

        $user->systemAccesses()->create([
            'system_id' => $system->id,
            'is_active' => true,
            'granted_at' => now(),
        ]);

        Passport::actingAs($user);

        $this->postJson('/api/system-access/check', [
            'system_code' => 'shelf',
        ])
            ->assertOk()
            ->assertJsonPath('permissions', []);
    }

    public function test_system_access_check_returns_only_assigned_permissions(): void
    {
        $user = User::factory()->create(['is_active' => true]);
        $system = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);

        $user->systemAccesses()->create([
            'system_id' => $system->id,
            'is_active' => true,
            'granted_at' => now(),
        ]);

        $user->systemPermissions()->create([
            'system_id' => $system->id,
            'permission' => 'view',
        ]);

        Passport::actingAs($user);

        $response = $this->postJson('/api/system-access/check', [
            'system_code' => 'shelf',
        ]);

        $response->assertOk();
        $response->assertJsonPath('permissions', ['view']);
    }

    public function test_logout_revokes_current_token(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        Passport::actingAs($user);

        $this->postJson('/api/auth/logout')
            ->assertOk()
            ->assertJsonPath('message', 'Logged out successfully.');
    }

    public function test_system_access_check_rejects_inactive_users_even_if_membership_exists(): void
    {
        $user = User::factory()->create(['is_active' => false]);
        $system = System::create([
            'code' => 'shelf',
            'name' => 'Shelf',
            'base_url' => 'https://shelf.test',
            'is_active' => true,
        ]);

        $user->systemAccesses()->create([
            'system_id' => $system->id,
            'is_active' => true,
            'granted_at' => now(),
        ]);

        Passport::actingAs($user);

        $this->postJson('/api/system-access/check', [
            'system_code' => 'shelf',
        ])->assertForbidden();
    }
}
