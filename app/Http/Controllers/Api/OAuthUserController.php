<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Http\Request;

class OAuthUserController extends Controller
{
    public function me(Request $request)
    {
        $user = $request->user();
        $token = $user->token(); // Passport token

        if (!$token) {
            abort(401, 'Unauthenticated');
        }

        // Find the system tied to this OAuth client
        $system = System::query()->where('oauth_client_id', $token->client_id)->first();

        $permissions = [];
        $roleCode = null;

        if ($system && $system->is_active) {
            // Ensure the user has active access to this system
            $access = $user->systemAccesses()
                ->where('system_id', $system->id)
                ->where('is_active', true)
                ->first();

            if ($access) {
                $permissions = $user->systemPermissions()
                    ->where('system_id', $system->id)
                    ->pluck('permission')
                    ->values()
                    ->all();

                $role = $user->systemRoles()
                    ->where('system_id', $system->id)
                    ->orderBy('role_code')
                    ->first();
                $roleCode = $role?->role_code;
            } else {
                abort(403, 'User does not have access to this system.');
            }
        }

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'is_active' => $user->is_active,
            'system_role' => $roleCode,
            'permissions' => $permissions,
        ]);
    }
}
