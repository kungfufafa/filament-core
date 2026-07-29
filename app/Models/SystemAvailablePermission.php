<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SystemAvailablePermission extends Model
{
    protected $table = 'system_available_permissions';

    protected $fillable = [
        'system_id',
        'permission',
        'label',
    ];

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }
}
