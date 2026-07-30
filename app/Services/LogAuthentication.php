<?php

namespace App\Services;

use App\Models\AuthenticationLog;
use Illuminate\Http\Request;

class LogAuthentication
{
    public static function record(Request $request, string $eventType, ?string $emailOrPhone = null, ?int $userId = null, ?string $description = null): void
    {
        AuthenticationLog::create([
            'user_id' => $userId ?? $request->user()?->id,
            'email_or_phone' => $emailOrPhone ?? $request->user()?->email ?? $request->user()?->phone,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'event_type' => $eventType,
            'description' => $description,
        ]);
    }
}
