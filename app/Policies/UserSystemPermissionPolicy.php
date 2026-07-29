<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\UserSystemPermission;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSystemPermissionPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:UserSystemPermission');
    }

    public function view(AuthUser $authUser, UserSystemPermission $userSystemPermission): bool
    {
        return $authUser->can('View:UserSystemPermission');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:UserSystemPermission');
    }

    public function update(AuthUser $authUser, UserSystemPermission $userSystemPermission): bool
    {
        return $authUser->can('Update:UserSystemPermission');
    }

    public function delete(AuthUser $authUser, UserSystemPermission $userSystemPermission): bool
    {
        return $authUser->can('Delete:UserSystemPermission');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:UserSystemPermission');
    }

    public function restore(AuthUser $authUser, UserSystemPermission $userSystemPermission): bool
    {
        return $authUser->can('Restore:UserSystemPermission');
    }

    public function forceDelete(AuthUser $authUser, UserSystemPermission $userSystemPermission): bool
    {
        return $authUser->can('ForceDelete:UserSystemPermission');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:UserSystemPermission');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:UserSystemPermission');
    }

    public function replicate(AuthUser $authUser, UserSystemPermission $userSystemPermission): bool
    {
        return $authUser->can('Replicate:UserSystemPermission');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:UserSystemPermission');
    }

}
