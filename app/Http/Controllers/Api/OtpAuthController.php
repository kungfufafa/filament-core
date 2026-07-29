<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OtpAuthController extends Controller
{
    public function __construct(
        protected OtpService $otpService
    ) {}

    public function request(Request $request)
    {
        $payload = $request->validate([
            'phone' => ['required', 'string'],
        ]);

        $result = $this->otpService->requestOtp($payload['phone']);

        if (! $result['success']) {
            if (isset($result['cooldown'])) {
                return response()->json([
                    'message' => $result['message'],
                    'cooldown' => $result['cooldown'],
                ], 429);
            }

            throw ValidationException::withMessages([
                'phone' => $result['message'],
            ]);
        }

        return response()->json([
            'message' => $result['message'],
            'phone' => $result['phone'],
        ]);
    }

    public function verify(Request $request)
    {
        $payload = $request->validate([
            'phone' => ['required', 'string'],
            'otp' => ['required', 'string'],
        ]);

        $user = $this->otpService->verifyOtp($payload['phone'], $payload['otp']);

        if (! $user) {
            throw ValidationException::withMessages([
                'otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.',
            ]);
        }

        if (! $user->is_active) {
            abort(403, 'This user account is inactive.');
        }

        // Issue Sanctum token just like standard login
        $token = $user->createToken('core-api-login')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'is_active' => $user->is_active,
            ],
        ]);
    }
}
