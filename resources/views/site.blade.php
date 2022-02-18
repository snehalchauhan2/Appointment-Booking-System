@extends('layouts.basic')

@section('content')
<div class="container">
            
    @auth
        @if(Auth::user()->isClient())
            <book-add-appointments></book-add-appointments>
        @else
            <div class="row text-center" style="color: #FFFFFF; margin-bottom: 10px;">
                Hi, {{ Auth::user()->name }}
            </div>
            <div class="row text-center">
                <div class="col-sm-12">
                    <a href="{{ route('home.index') }}" class="btn btn-primary">Go to Admin Panel</a>
                </div>
            </div>    
        @endif
    @endauth

    @guest
    <div class="row text-center">
        <div class="col-sm-12">
            <a href="{{ route('login') }}" class="btn btn-primary">Login to Book Appointments</a>
        </div>
    </div>
    @endguest

</div>
@endsection

@section('scripts')
@include('js.config')
<script src="{{ mix('js/site.js') }}"></script>
@endsection