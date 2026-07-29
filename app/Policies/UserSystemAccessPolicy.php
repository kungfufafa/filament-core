<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\UserSystemAccess;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserSystemAccessPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:UserSystemAccess');
    }

    public function view(AuthUser $authUser, UserSystemAccess $userSystemAccess): bool
    {
        return $authUser->can('View:UserSystemAccess');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:UserSystemAccess');
    }

    public function update(AuthUser $authUser, UserSystemAccess $userSystemAccess): bool
    {
        return $authUser->can('Update:UserSystemAccess');
    }

    public function delete(AuthUser $authUser, UserSystemAccess $userSystemAccess): bool
    {
        return $authUser->can('Delete:UserSystemAccess');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:UserSystemAccess');
    }

    public function restore(AuthUser $authUser, UserSystemAccess $userSystemAccess): bool
    {
        return $authUser->can('Restore:UserSystemAccess');
    }

    public function forceDelete(AuthUser $authUser, UserSystemAccess $userSystemAccess): bool
    {
        return $authUser->can('ForceDelete:UserSystemAccess');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:UserSystemAccess');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:UserSystemAccess');
    }

    public function replicate(AuthUser $authUser, UserSystemAccess $userSystemAccess): bool
    {
        return $authUser->can('Replicate:UserSystemAccess');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:UserSystemAccess');
    }

}