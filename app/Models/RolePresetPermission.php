<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePresetPermission extends Model
{
    protected $fillable = [
        'role_preset_id',
        'system_id',
        'permission',
    ];

    public function preset(): BelongsTo
    {
        return $this->belongsTo(RolePreset::class, 'role_preset_id');
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }
}
