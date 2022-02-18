@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li><a href="{{ route('home.providers.index') }}">Providers</a></li>
      <li class="active">Edit Provider</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>Edit Provider</h3>
        </div>
        <div class="panel-body">
            {!! Form::model($provider, ['route' => ['home.providers.update', $provider->id], 'method' => 'patch', 'files' => true, 'id' => 'provider-form']) !!}    
        
                @include('home.providers.fields')

                <div class="form-group col-xs-12 col-sm-12">
                    {!! Form::submit('Save', ['class' => 'btn btn-success']) !!}
                </div>

            {!! Form::close() !!}  
        </div>
    </div>

</div>
@endsection