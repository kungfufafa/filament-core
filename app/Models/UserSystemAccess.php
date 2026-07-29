<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class UserSystemAccess extends Model
{
    protected $table = 'user_system_access';

    protected $fillable = [
        'user_id',
        'system_id',
        'is_active',
        'granted_at',
        'granted_by',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'bool',
            'granted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }
}
