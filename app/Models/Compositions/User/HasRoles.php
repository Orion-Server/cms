<?php

namespace App\Models\Compositions\User;

trait HasRoles
{
    /**
     * Check if the user has the given role.
     *
     * @param string|array $abilities
     * @param array $arguments
     */
    public function can($abilities, $arguments = []): bool
    {
        if(!$this->relationLoaded('roles')) $this->load('roles');

        return $this->roles->contains('role_name', $abilities);
    }
}
