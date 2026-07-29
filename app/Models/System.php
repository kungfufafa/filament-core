<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $fillable = [
        'code',
        'name',
        'base_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'bool',
        ];
    }

    public function userAccesses(): HasMany
    {
        return $this->hasMany(UserSystemAccess::class);
    }

    public function userRoles(): HasMany
    {
        return $this->hasMany(UserSystemRole::class);
    }

    public function userPermissions(): HasMany
    {
        return $this->hasMany(UserSystemPermission::class);
    }

    public function availablePermissions(): HasMany
    {
        return $this->hasMany(SystemAvailablePermission::class);
    }
}
