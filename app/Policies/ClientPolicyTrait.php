<?php

namespace LaraBooking\Policies;

use LaraBooking\Models\User;

/**
 * This trait can be injected in the UserPolicy to validate the User Client Authorizations
 */
trait ClientPolicyTrait
{
    
    /**
     * Determine whether the user can view the client.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Client  $client
     * @return mixed
     */
    public function viewClient(User $user)
    {
        return $user->typeInArray(['admin', 'provider', 'secretary']);
    }

    /**
     * Determine whether the user can create clients.
     *
     * @param  \LaraBooking\Models\User  $user
     * @return mixed
     */
    public function createClient(User $user)
    {
        return $user->typeInArray(['admin', 'provider', 'secretary']);
    }

    /**
     * Determine whether the user can update the client.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Client  $client
     * @return mixed
     */
    public function updateClient(User $user)
    {
        return $user->typeInArray(['admin', 'provider', 'secretary']);
    }

    /**
     * Determine whether the user can delete the client.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Client  $client
     * @return mixed
     */
    public function deleteClient(User $user)
    {
        return $user->isAdmin();
    }
}
