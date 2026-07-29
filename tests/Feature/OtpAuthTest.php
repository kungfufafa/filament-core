<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WhatsappOtp;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class OtpAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_request_otp_for_registered_user(): void
    {
        User::factory()->create([
            'phone' => '628123456789',
            'is_active' => true,
        ]);

        $response = $this->postJson('/api/auth/otp/request', [
            'phone' => '08123456789',
        ]);

        $response->assertOk()
            ->assertJsonPath('message', 'Kode OTP berhasil dikirimkan ke WhatsApp Anda.')
            ->assertJsonPath('phone', '628123456789');

        $this->assertDatabaseHas('whatsapp_otps', [
            'phone' => '628123456789',
        ]);
    }

    public function test_request_otp_respects_cooldown(): void
    {
        User::factory()->create([
            'phone' => '628123456789',
            'is_active' => true,
        ]);

        WhatsappOtp::create([
            'phone' => '628123456789',
            'otp' => '123456',
            'expires_at' => Carbon::now()->addMinutes(5),
            'created_at' => Carbon::now()->subSeconds(30),
        ]);

        $response = $this->postJson('/api/auth/otp/request', [
            'phone' => '08123456789',
        ]);

        $response->assertStatus(429)
            ->assertJsonStructure(['message', 'cooldown']);
    }

    public function test_can_verify_valid_otp_and_receive_token(): void
    {
        $user = User::factory()->create([
            'phone' => '628123456789',
            'is_active' => true,
        ]);

        WhatsappOtp::create([
            'phone' => '628123456789',
            'otp' => '123456',
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);

        $response = $this->postJson('/api/auth/otp/verify', [
            'phone' => '08123456789',
            'otp' => '123456',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'user' => ['id', 'name', 'email', 'phone', 'is_active'],
            ]);

        $this->assertDatabaseHas('whatsapp_otps', [
            'phone' => '628123456789',
            'otp' => '123456',
        ]);
        
        $verifiedOtp = WhatsappOtp::where('phone', '628123456789')->first();
        $this->assertNotNull($verifiedOtp->verified_at);
    }

    public function test_cannot_verify_invalid_or_expired_otp(): void
    {
        User::factory()->create([
            'phone' => '628123456789',
            'is_active' => true,
        ]);

        WhatsappOtp::create([
            'phone' => '628123456789',
            'otp' => '123456',
            'expires_at' => Carbon::now()->subMinutes(5), // Expired
        ]);

        $response = $this->postJson('/api/auth/otp/verify', [
            'phone' => '08123456789',
            'otp' => '123456',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('otp');

        $response2 = $this->postJson('/api/auth/otp/verify', [
            'phone' => '08123456789',
            'otp' => '999999', // Wrong OTP
        ]);

        $response2->assertStatus(422)
            ->assertJsonValidationErrors('otp');
    }
}
