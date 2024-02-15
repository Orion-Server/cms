<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CommandLog;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommandLogPolicy
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
        return $user->can('view_any::admin::command_log');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CommandLog  $commandLog
     * @return bool
     */
    public function view(User $user, CommandLog $commandLog): bool
    {
        return $user->can('view::admin::command_log');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('create::admin::command_log');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CommandLog  $commandLog
     * @return bool
     */
    public function update(User $user, CommandLog $commandLog): bool
    {
        return $user->can('update::admin::command_log');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CommandLog  $commandLog
     * @return bool
     */
    public function delete(User $user, CommandLog $commandLog): bool
    {
        return $user->can('delete::admin::command_log');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any::admin::command_log');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CommandLog  $commandLog
     * @return bool
     */
    public function forceDelete(User $user, CommandLog $commandLog): bool
    {
        return $user->can('force_delete::admin::command_log');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any::admin::command_log');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CommandLog  $commandLog
     * @return bool
     */
    public function restore(User $user, CommandLog $commandLog): bool
    {
        return $user->can('restore::admin::command_log');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any::admin::command_log');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\CommandLog  $commandLog
     * @return bool
     */
    public function replicate(User $user, CommandLog $commandLog): bool
    {
        return $user->can('replicate::admin::command_log');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder::admin::command_log');
    }

}
