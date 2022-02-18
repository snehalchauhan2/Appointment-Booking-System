<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LaraBooking</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
</head>
<body>
    
    <div class="loader-overlay">
        <div class="loader"></div>
    </div>

    <div id="app">
        <div class="sidebar">
            @include('layouts.sidebar')
        </div>
        <div class="main">
            @include('layouts.navbar')

            <div class="content">
                @include('layouts.alerts')
                @yield('content')
            </div>
        </div>  
    </div>

    @include('js.config')
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>
