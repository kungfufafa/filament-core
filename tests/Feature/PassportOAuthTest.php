<?php

namespace Tests\Feature;

use App\Models\System;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Client;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PassportOAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_passport_guard_authenticates_user_and_returns_permissions(): void
    {
        $user = User::factory()->create(['is_active' => true]);

        $client = \Laravel\Passport\Passport::client()->create([
            'name' => 'Talent System Client',
            'redirect_uris' => 'http://talent.test/auth/callback',
            'revoked' => false,
            'grant_types' => ['authorization_code'],
        ]);

        $system = System::create([
            'code' => 'talent',
            'name' => 'Talent System',
            'base_url' => 'http://talent.test',
            'is_active' => true,
            'oauth_client_id' => $client->id,
        ]);

        $user->systemAccesses()->create([
            'system_id' => $system->id,
            'is_active' => true,
            'granted_at' => now(),
        ]);

        $user->systemPermissions()->create([
            'system_id' => $system->id,
            'permission' => 'ViewAny:Employee',
        ]);

        Passport::actingAsClient($client, ['*']);
        Passport::actingAs($user, ['*'], 'api');
        
        // Ensure the simulated token uses the client ID
        $user->token()->client_id = $client->id;

        $response = $this->getJson('/api/oauth/me');

        $response->assertOk()
            ->assertJsonPath('id', $user->id)
            ->assertJsonPath('permissions.0', 'ViewAny:Employee');
    }
}
