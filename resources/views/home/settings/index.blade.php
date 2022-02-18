@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li class="active">Settings</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>Settings</h3>
        </div>
        <div class="panel-body">
            {!! Form::open(['route' => 'home.settings.store', 'id' => 'settings-form']) !!}    
        
                @include('home.settings.fields')

                <div class="form-group col-xs-12 col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                </div>

            {!! Form::close() !!}  
        </div>
    </div>

</div>
@endsection