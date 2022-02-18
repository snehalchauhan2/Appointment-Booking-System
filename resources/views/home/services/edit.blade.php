@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li><a href="{{ route('home.services.index') }}">Services</a></li>
      <li class="active">Edit Service</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>Edit Service</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($service, ['route' => ['home.services.update', $service->id], 'method' => 'patch', 'files' => true, 'id' => 'service-form']) !!}    
        
                @include('home.services.fields')

                <div class="form-group col-xs-12 col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                </div>

            {!! Form::close() !!}  
        </div>
    </div>

</div>
@endsection