<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WriteableBox;
use Illuminate\Auth\Access\HandlesAuthorization;

class WriteableBoxPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any::admin::writeable_box');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param WriteableBox $writeableBox
     * @return bool
     */
    public function view(User $user, WriteableBox $writeableBox): bool
    {
        return $user->can('view::admin::writeable_box');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create::admin::writeable_box');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param WriteableBox $writeableBox
     * @return bool
     */
    public function update(User $user, WriteableBox $writeableBox): bool
    {
        return $user->can('update::admin::writeable_box');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param WriteableBox $writeableBox
     * @return bool
     */
    public function delete(User $user, WriteableBox $writeableBox): bool
    {
        return $user->can('delete::admin::writeable_box');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param User $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any::admin::writeable_box');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param User $user
     * @param WriteableBox $writeableBox
     * @return bool
     */
    public function forceDelete(User $user, WriteableBox $writeableBox): bool
    {
        return $user->can('force_delete::admin::writeable_box');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param User $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any::admin::writeable_box');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param User $user
     * @param WriteableBox $writeableBox
     * @return bool
     */
    public function restore(User $user, WriteableBox $writeableBox): bool
    {
        return $user->can('restore::admin::writeable_box');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param User $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any::admin::writeable_box');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param User $user
     * @param WriteableBox $writeableBox
     * @return bool
     */
    public function replicate(User $user, WriteableBox $writeableBox): bool
    {
        return $user->can('replicate::admin::writeable_box');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param User $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder::admin::writeable_box');
    }

}
