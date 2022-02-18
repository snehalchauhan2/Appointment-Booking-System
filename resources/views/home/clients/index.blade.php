@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <ol class="breadcrumb">
      <li><a href="/home">Home</a></li>
      <li class="active">Clients</li>
    </ol>

    <div class="panel">
        <div class="panel-heading">
            <h3>Clients</h3>
            <br>
            
            <div class="row">
                <div class="col-sm-2">
                    @can('create-client', LaraBooking\Models\User::class)
                        <a href="{{ route('home.clients.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i> Client</a>
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
                            <th>Email</th>
                            <th class="action"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td class="text-right">
                            {!! Form::open(['route' => ['home.clients.destroy', $client->id], 'method' => 'delete']) !!}
                                <div class='btn-group'>
                                    <a href="{{ route('home.clients.show', $client->id) }}" class="btn btn-sm btn-default"><i class="fa fa-eye"></i></a>

                                    @can('update-client', LaraBooking\Models\User::class)
                                        <a href="{{ route('home.clients.edit', $client->id) }}" class="btn btn-sm btn-default"><i class="fa fa-pencil"></i></a>
                                    @endcan
                                    
                                    @can('delete-client', LaraBooking\Models\User::class)
                                        {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return confirm('Are you sure to delete this clients? This will remove all the client appointments!')"]) !!}
                                    @endcan
                                </div>
                            {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {!! $clients->render() !!}
        </div>
    </div>

</div>
@endsection
