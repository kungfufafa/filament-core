<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SystemAvailablePermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class SystemAvailablePermissionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SystemAvailablePermission');
    }

    public function view(AuthUser $authUser, SystemAvailablePermission $systemAvailablePermission): bool
    {
        return $authUser->can('View:SystemAvailablePermission');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SystemAvailablePermission');
    }

    public function update(AuthUser $authUser, SystemAvailablePermission $systemAvailablePermission): bool
    {
        return $authUser->can('Update:SystemAvailablePermission');
    }

    public function delete(AuthUser $authUser, SystemAvailablePermission $systemAvailablePermission): bool
    {
        return $authUser->can('Delete:SystemAvailablePermission');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:SystemAvailablePermission');
    }

    public function restore(AuthUser $authUser, SystemAvailablePermission $systemAvailablePermission): bool
    {
        return $authUser->can('Restore:SystemAvailablePermission');
    }

    public function forceDelete(AuthUser $authUser, SystemAvailablePermission $systemAvailablePermission): bool
    {
        return $authUser->can('ForceDelete:SystemAvailablePermission');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SystemAvailablePermission');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SystemAvailablePermission');
    }

    public function replicate(AuthUser $authUser, SystemAvailablePermission $systemAvailablePermission): bool
    {
        return $authUser->can('Replicate:SystemAvailablePermission');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SystemAvailablePermission');
    }
}
