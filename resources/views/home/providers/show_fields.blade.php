<div class="form-group">
    {{ Form::label('name', 'Name') }}
    <p>{{ $provider->name }}</p>
</div>

<div class="form-group">
    {{ Form::label('email', 'Email') }}
    <p>{{ $provider->email }}</p>
</div>

<div class="form-group">
    {{ Form::label('phone', 'Phone') }}
    <p>{{ $provider->phone }}</p>
</div>

@if(isset($provider))
        @if($provider->image)
            <div class="form-group">
                {{ Form::label('image', 'Image') }}
            </div>
            <div class="form-group col-xs-12 col-sm-12 text-left">  
                <img src="{{ asset($provider->getImagePath('image', 'thumb')) }}" width="150" style="margin: 10px">
            </div>
    @endif
@endif

<div class="form-group">
    {{ Form::label('description', 'Description') }}
    <p>{{ $provider->description ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('address', 'Address') }}
    <p>{{ $provider->address ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('city', 'City') }}
    <p>{{ $provider->city ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('state', 'State') }}
    <p>{{ $provider->state ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('zip_code', 'ZipCode') }}
    <p>{{ $provider->zip_code ?: '-' }}</p>
</div>

<div class="form-group">
    {{ Form::label('phones', 'Phones') }}
    @forelse($provider->phones as $phone)
    <p>{{ $phone->phone }}</p>
    @empty
    <p>-</p>
    @endforelse
</div>