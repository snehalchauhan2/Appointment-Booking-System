<nav class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav visible-xs">
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

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
            
        </div>
    </div>
</nav>