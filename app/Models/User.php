<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'phone', 'password', 'is_active'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'bool',
            'password' => 'hashed',
        ];
    }

    public static function findByPhone(string $phone): ?self
    {
        $cleaned = preg_replace('/\D/', '', $phone);
        
        if (str_starts_with($cleaned, '0')) {
            $international = '62'.substr($cleaned, 1);
        } elseif (str_starts_with($cleaned, '8')) {
            $international = '62'.$cleaned;
        } else {
            $international = $cleaned;
        }

        return self::query()->where('phone', $international)->first();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active && $this->hasRole('super_admin');
    }

    public function systemAccesses(): HasMany
    {
        return $this->hasMany(UserSystemAccess::class);
    }

    public function systemRoles(): HasMany
    {
        return $this->hasMany(UserSystemRole::class);
    }

    public function systemPermissions(): HasMany
    {
        return $this->hasMany(UserSystemPermission::class);
    }
}
