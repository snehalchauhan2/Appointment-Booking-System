@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li class="active">Services</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>Services</h3>
            <br>
            
            <div class="row">
                <div class="col-sm-2">
                    @can('create', LaraBooking\Models\Service::class)
                        <a href="{{ route('home.services.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Service</a>
                    @endcan
                </div>
                <div class="col-sm-10">
                    <form action="">
                        <div class="input-group">
                          <input type="text" id="search" name="search" class="form-control" placeholder="Search..." value="{{ $search }}">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Search</button>
                          </span>
                        </div>
                    </form>
                </div>
            </div>

            <br>

        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-stripped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="action"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->description }}</td>
                            <td class="text-right">
                            {!! Form::open(['route' => ['home.services.destroy', $service->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{{ route('home.services.show', $service->id) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a>

                                    @can('update', LaraBooking\Models\Service::class)
                                        <a href="{{ route('home.services.edit', $service->id) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>
                                    @endcan
                                    
                                    @can('delete', LaraBooking\Models\Service::class)
                                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure to delete this item?')"]) !!}
                                    @endcan
                                </div>
                            {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {!! $services->render() !!}
        </div>
    </div>

</div>
@endsection
