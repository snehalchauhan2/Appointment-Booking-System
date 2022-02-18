@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li><a href="{{ route('home.providers.index') }}">Providers</a></li>
      <li class="active">View Provider</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>View Provider</h3>
        </div>
        <div class="panel-body">
        
                @include('home.providers.show_fields')

                <a href="{{ route('home.providers.index') }}" class="btn btn-default">Back</a>
            {!! Form::close() !!}  
        </div>
    </div>

</div>
@endsection