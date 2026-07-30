<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->artisan('migrate');

        if (!\Laravel\Passport\Passport::client()->where('name', 'Test Personal Access Client')->exists()) {
            $clientId = (string) Str::uuid();
            \Illuminate\Support\Facades\DB::table('oauth_clients')->insert([
                'id' => $clientId,
                'name' => 'Test Personal Access Client',
                'secret' => Str::random(40),
                'redirect_uris' => '["http://localhost"]',
                'grant_types' => '["personal_access"]',
                'revoked' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
