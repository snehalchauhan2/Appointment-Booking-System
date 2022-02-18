<div class="form-group">
    {{ Form::label('name', 'Name') }}
    <p>{{ $user->name }}</p>
</div>

<div class="form-group">
    {{ Form::label('email', 'Email') }}
    <p>{{ $user->email }}</p>
</div>

<div class="form-group">
    {{ Form::label('address', 'Address') }}
    <p>{{ $user->address ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('city', 'City') }}
    <p>{{ $user->city ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('state', 'State') }}
    <p>{{ $user->state ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('zip_code', 'ZipCode') }}
    <p>{{ $user->zip_code ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('phones', 'Phones') }}
    @forelse($user->phones as $phone)
    <p>{{ $phone->phone }}</p>
    @empty
    <p>-</p>
    @endforelse
</div>