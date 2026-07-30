<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RolePreset extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function permissions(): HasMany
    {
        return $this->hasMany(RolePresetPermission::class);
    }
}
