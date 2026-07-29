<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\SystemAvailablePermission;
use Illuminate\Http\Request;

class AvailablePermissionController extends Controller
{
    public function register(Request $request, System $system)
    {
        $data = $request->validate([
            'permissions' => ['required', 'array'],
            'permissions.*.permission' => ['required', 'string'],
            'permissions.*.label' => ['nullable', 'string'],
        ]);

        $incomingPermissions = collect($data['permissions']);

        foreach ($incomingPermissions as $p) {
            SystemAvailablePermission::updateOrCreate(
                ['system_id' => $system->id, 'permission' => $p['permission']],
                ['label' => $p['label'] ?? null],
            );
        }

        SystemAvailablePermission::query()
            ->where('system_id', $system->id)
            ->whereNotIn('permission', $incomingPermissions->pluck('permission'))
            ->delete();

        return response()->json(['synced' => $incomingPermissions->count()]);
    }
}
