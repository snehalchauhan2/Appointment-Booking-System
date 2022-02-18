<?php

namespace LaraBooking\Policies;

use LaraBooking\Models\User;

/**
 * This trait can be injected in the UserPolicy to validate the User Provider Authorizations
 */
trait ProviderPolicyTrait
{
    
    /**
     * Determine whether the user can view the provider.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Provider  $provider
     * @return mixed
     */
    public function viewProvider(User $user)
    {
        return $user->typeInArray(['admin', 'provider', 'secretary']);
    }

    /**
     * Determine whether the user can create providers.
     *
     * @param  \LaraBooking\Models\User  $user
     * @return mixed
     */
    public function createProvider(User $user)
    {
        return $user->typeInArray(['admin', 'provider', 'secretary']);
    }

    /**
     * Determine whether the user can update the provider.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Provider  $provider
     * @return mixed
     */
    public function updateProvider(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the provider.
     *
     * @param  \LaraBooking\Models\User  $user
     * @param  \LaraBooking\Models\Provider  $provider
     * @return mixed
     */
    public function deleteProvider(User $user)
    {
        return $user->isAdmin();
    }
}
