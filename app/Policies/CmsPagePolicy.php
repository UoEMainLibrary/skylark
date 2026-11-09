<?php

namespace App\Policies;

use App\Models\CmsPage;
use App\Models\User;

class CmsPagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isCmsAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CmsPage $cmsPage): bool
    {
        return $user->isCmsAdministrator();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isCmsAdministrator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CmsPage $cmsPage): bool
    {
        return $user->isCmsAdministrator();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CmsPage $cmsPage): bool
    {
        return $user->isCmsAdministrator();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CmsPage $cmsPage): bool
    {
        return $user->isCmsAdministrator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CmsPage $cmsPage): bool
    {
        return $user->isCmsAdministrator();
    }
}
