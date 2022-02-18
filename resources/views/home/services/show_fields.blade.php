<div class="form-group">
    {{ Form::label('name', 'Name') }}
    <p>{{ $service->name }}</p>
</div>

<div class="form-group">
    {{ Form::label('description', 'Description') }}
    <p>{{ $service->description }}</p>
</div>

@if(isset($service))
        @if($service->image)
            <div class="form-group">
                {{ Form::label('image', 'Image') }}
            </div>
            <div class="form-group col-xs-12 col-sm-12 text-left">  
                <img src="{{ asset($service->getImagePath('image', 'thumb')) }}" width="150" style="margin: 10px">
            </div>
    @endif
@endif
