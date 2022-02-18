@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if(Auth::user()->isProvider())
            <book-calendar provider="{{ Auth::user()->id }}" business-hours="{{ !$businessHours->isEmpty() ? $businessHours : 'false' }}" ref="book-calendar"></book-calendar>
            @else
            <book-calendar business-hours="{{ !$businessHours->isEmpty() ? $businessHours : 'false' }}" ref="book-calendar"></book-calendar>            
            @endif
        </div>
    </div>
</div>
@endsection