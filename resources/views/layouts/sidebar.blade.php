<div class="sidebar-header">
    <!-- Branding Image -->
    <a href="{{ route('home.index') }}">
        <img src="{{ asset('assets/images/logo.png') }}" alt="">
    </a>
</div>
<div class="sidebar-inner">
    <ul class="nav nav-sidebar">
        @auth
            <li class="{{ isActiveRoute('home.index') }}">
                <a href="{{ route('home.index') }}">
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    Calendar
                </a>
            </li>

            @can('view-client', LaraBooking\Models\User::class)
                <li class="{{ areActiveRoutes(['home.clients.index', 'home.clients.create', 'home.clients.edit', 'home.clients.show']) }}">
                    <a href="{{ route('home.clients.index') }}">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        Clients
                    </a>
                </li>
            @endcan
            
            @can('view-provider', LaraBooking\Models\User::class)
                <li class="{{ areActiveRoutes(['home.providers.index', 'home.providers.create', 'home.providers.edit', 'home.providers.show']) }}">
                    <a href="{{ route('home.providers.index') }}">
                        <i class="fa fa-user-md" aria-hidden="true"></i>
                        Providers
                    </a>
                </li>
            @endcan

            @can('view', LaraBooking\Models\Service::class)
                <li class="{{ areActiveRoutes(['home.services.index', 'home.services.create', 'home.services.edit', 'home.services.show']) }}">
                    <a href="{{ route('home.services.index') }}">
                        <i class="fa fa-wrench" aria-hidden="true"></i>
                        Services
                    </a>
                </li>
            @endcan
            
            @can('manage', LaraBooking\Models\User::class)
                <li class="{{ areActiveRoutes(['home.users.index', 'home.users.create', 'home.users.edit', 'home.users.show']) }}">
                    <a href="{{ route('home.users.index') }}">
                        <i class="fa fa-users" aria-hidden="true"></i>
                        Users
                    </a>
                </li>
            @endcan

            @can('manage', LaraBooking\Models\Settings::class)
                <li class="{{ isActiveRoute('home.settings.index') }}">
                    <a href="{{ route('home.settings.index') }}">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                        Settings
                    </a>
                </li>
            @endcan
        @endauth
    </ul>
</div>
<div class="sidebar-background" style="background-image: url({{ asset('assets/images/sidebar-back.jpg') }});"></div>