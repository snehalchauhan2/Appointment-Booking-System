<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LaraBooking - Appointments System</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/basic.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <style>
        body {
            background-image: url({{ asset('assets/images/sidebar-back.jpg') }});
        }
    </style>

    @yield('styles')

</head>

<body>
    <div class="loader-overlay">
        <div class="loader"></div>
    </div>
    
    <div class="app-wrapper" id="app">
        @include('layouts.alerts')

        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    @if(!Auth::user()->isClient())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        @endif
        
        <div class="container text-center">
            <div class="main-logo">
                <a href="{{ route('site') }}">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="">
                </a>
            </div>
        </div>

        @yield('content')
        <div class="background-opacity"></div>

    </div>
    
    @yield('scripts')
</body>
</html>
