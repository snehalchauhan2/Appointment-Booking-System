<?php

namespace LaraBooking\Providers;

use LaraBooking\Models\User;
use LaraBooking\Models\Service;
use LaraBooking\Models\Settings;
use LaraBooking\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use LaraBooking\Policies\ServicePolicy;
use LaraBooking\Policies\SettingsPolicy;
use LaraBooking\Policies\ProviderPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Settings::class => SettingsPolicy::class,
        User::class => UserPolicy::class,
        Service::class => ServicePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
