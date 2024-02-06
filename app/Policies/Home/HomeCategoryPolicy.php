<?php

namespace App\Policies\Home;

use App\Models\User;
use App\Models\Home\HomeCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class HomeCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_profile::home::category');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Home\HomeCategory  $homeCategory
     * @return bool
     */
    public function view(User $user, HomeCategory $homeCategory): bool
    {
        return $user->can('view_profile::home::category');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create_profile::home::category');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Home\HomeCategory  $homeCategory
     * @return bool
     */
    public function update(User $user, HomeCategory $homeCategory): bool
    {
        return $user->can('update_profile::home::category');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Home\HomeCategory  $homeCategory
     * @return bool
     */
    public function delete(User $user, HomeCategory $homeCategory): bool
    {
        return $user->can('delete_profile::home::category');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_profile::home::category');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Home\HomeCategory  $homeCategory
     * @return bool
     */
    public function forceDelete(User $user, HomeCategory $homeCategory): bool
    {
        return $user->can('force_delete_profile::home::category');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_profile::home::category');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Home\HomeCategory  $homeCategory
     * @return bool
     */
    public function restore(User $user, HomeCategory $homeCategory): bool
    {
        return $user->can('restore_profile::home::category');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_profile::home::category');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Home\HomeCategory  $homeCategory
     * @return bool
     */
    public function replicate(User $user, HomeCategory $homeCategory): bool
    {
        return $user->can('replicate_profile::home::category');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_profile::home::category');
    }

}
