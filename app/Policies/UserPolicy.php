<?php

namespace LaraBooking\Policies;

use LaraBooking\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization, ClientPolicyTrait, ProviderPolicyTrait;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can manage the other users.
     *
     * @param  \LaraBooking\Models\User  $user
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->isAdmin();
    }
}
