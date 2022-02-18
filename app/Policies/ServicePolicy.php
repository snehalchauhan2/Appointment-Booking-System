<?php

namespace LaraBooking\Policies;

use LaraBooking\Models\User;
use LaraBooking\Models\Service;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the service.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Service  $service
     * @return mixed
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create services.
     *
     * @param  \LaraBooking\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the service.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Service  $service
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the service.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Service  $service
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }
}
