@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li><a href="{{ route('home.services.index') }}">Services</a></li>
      <li class="active">View Service</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>View Service</h3>
        </div>
        <div class="panel-body">
        
                @include('home.services.show_fields')

                <a href="{{ route('home.services.index') }}" class="btn btn-default">Back</a>
            {!! Form::close() !!}  
        </div>
    </div>

</div>
@endsection