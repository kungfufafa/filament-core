<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\UserSystemRole;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSystemRolePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:UserSystemRole');
    }

    public function view(AuthUser $authUser, UserSystemRole $userSystemRole): bool
    {
        return $authUser->can('View:UserSystemRole');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:UserSystemRole');
    }

    public function update(AuthUser $authUser, UserSystemRole $userSystemRole): bool
    {
        return $authUser->can('Update:UserSystemRole');
    }

    public function delete(AuthUser $authUser, UserSystemRole $userSystemRole): bool
    {
        return $authUser->can('Delete:UserSystemRole');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:UserSystemRole');
    }

    public function restore(AuthUser $authUser, UserSystemRole $userSystemRole): bool
    {
        return $authUser->can('Restore:UserSystemRole');
    }

    public function forceDelete(AuthUser $authUser, UserSystemRole $userSystemRole): bool
    {
        return $authUser->can('ForceDelete:UserSystemRole');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:UserSystemRole');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:UserSystemRole');
    }

    public function replicate(AuthUser $authUser, UserSystemRole $userSystemRole): bool
    {
        return $authUser->can('Replicate:UserSystemRole');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:UserSystemRole');
    }

}