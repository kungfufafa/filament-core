<?php

namespace App\Http\Controllers\Api;

use App\Models\System;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemAccessController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $systems = $user->systemAccesses()
            ->where('is_active', true)
            ->with('system')
            ->get()
            ->pluck('system')
            ->filter(fn (?System $system): bool => $system !== null && $system->is_active)
            ->values()
            ->map(fn (System $system): array => [
                'id' => $system->id,
                'code' => $system->code,
                'name' => $system->name,
                'base_url' => $system->base_url,
            ]);

        return response()->json([
            'data' => $systems,
        ]);
    }

    public function check(Request $request)
    {
        $user = $request->user();

        if (! $user->is_active) {
            abort(403, 'This user account is inactive.');
        }

        $payload = $request->validate([
            'system_code' => ['required', 'string'],
        ]);

        $system = System::query()->where('code', $payload['system_code'])->firstOrFail();

        $access = $user->systemAccesses()
            ->where('system_id', $system->id)
            ->where('is_active', true)
            ->first();

        if (! $system->is_active || ! $access) {
            abort(403, 'This user cannot access the requested system.');
        }

        $role = $user->systemRoles()
            ->where('system_id', $system->id)
            ->orderBy('role_code')
            ->first();

        $permissions = $user->systemPermissions()
            ->where('system_id', $system->id)
            ->pluck('permission')
            ->values()
            ->all();

        return response()->json([
            'allowed' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'is_active' => $user->is_active,
            ],
            'system_role' => $role?->role_code,
            'permissions' => $permissions,
        ]);
    }
}
