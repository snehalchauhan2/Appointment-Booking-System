<?php

namespace LaraBooking\Policies;

use LaraBooking\Models\User;
use LaraBooking\Models\Settings;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can manage the settings.
     *
     * @param  \LaraBooking\Models\User  $user
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->isAdmin();
    }
}
