<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Token;

class OAuthSessionController extends Controller
{
    public function index(Request $request)
    {
        $tokens = $request->user()->tokens()
            ->with('client')
            ->where('revoked', false)
            ->get()
            ->map(function (Token $token) {
                return [
                    'id' => $token->id,
                    'client_id' => $token->client_id,
                    'client_name' => $token->client->name ?? 'Unknown Client',
                    'created_at' => $token->created_at,
                    'expires_at' => $token->expires_at,
                ];
            });

        return response()->json([
            'sessions' => $tokens,
        ]);
    }

    public function destroy(Request $request, string $tokenId)
    {
        $token = $request->user()->tokens()
            ->where('id', $tokenId)
            ->firstOrFail();

        $token->revoke();

        // Optional: In a full implementation, we'd trigger a Webhook to the Satellite
        // to invalidate the local Laravel session corresponding to this token.
        
        return response()->json([
            'message' => 'Session revoked successfully.',
        ]);
    }
}
