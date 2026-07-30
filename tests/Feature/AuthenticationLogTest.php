<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_logs_successful_api_login(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'secret123',
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@example.com',
            'password' => 'secret123',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas('authentication_logs', [
            'user_id' => $user->id,
            'email_or_phone' => 'test@example.com',
            'event_type' => 'login',
        ]);
    }

    public function test_logs_failed_api_login(): void
    {
        $this->postJson('/api/auth/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrongpass',
        ])->assertStatus(422);

        $this->assertDatabaseHas('authentication_logs', [
            'email_or_phone' => 'wrong@example.com',
            'event_type' => 'failed',
            'description' => 'Invalid credentials',
        ]);
    }
}
