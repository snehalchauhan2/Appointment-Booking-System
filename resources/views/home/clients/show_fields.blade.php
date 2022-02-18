<div class="form-group">
    {{ Form::label('name', 'Name') }}
    <p>{{ $client->name }}</p>
</div>

<div class="form-group">
    {{ Form::label('email', 'Email') }}
    <p>{{ $client->email }}</p>
</div>

<div class="form-group">
    {{ Form::label('address', 'Address') }}
    <p>{{ $client->address ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('city', 'City') }}
    <p>{{ $client->city ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('state', 'State') }}
    <p>{{ $client->state ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('zip_code', 'ZipCode') }}
    <p>{{ $client->zip_code ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('phones', 'Phones') }}
    @forelse($client->phones as $phone)
    <p>{{ $phone->phone }}</p>
    @empty
    <p>-</p>
    @endforelse
</div>