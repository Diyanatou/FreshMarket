<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the admin dashboard.
     */
    public function viewAdminDashboard(User $user): bool
    {
        return $user->role_id == 2;
    }
}
