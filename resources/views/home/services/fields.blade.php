
<div class="form-group col-xs-12 col-sm-10 required">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group col-xs-12 col-sm-2 required">
    {!! Form::label('duration', 'Duration') !!}
    {!! Form::number('duration', null, ['class' => 'form-control', 'required' => 'required', 'step' => '1']) !!}
</div>

<div class="form-group col-xs-12 col-sm-12 required">
    {!! Form::label('description', 'Description') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group col-xs-12 col-sm-12 text-left">
    @if(isset($service))
        @if($service->image)
            <img src="{{ asset($service->getImagePath('image', 'thumb')) }}" width="150" style="margin: 10px">
        @endif
    @endif
</div>

<div class="form-group col-xs-12">
    {!! Form::label('image', 'Image') !!}
    {!! Form::file('image', ['accept' => 'image/*']) !!}
</div>

<div class="col-sm-12">
    <h4>Providers</h4>
    <span class="help-block">These are the providers that can accept appointments with this service</span>
    <div class="panel panel-default">
        <div class="panel-heading">Select the providers</div>
        <div class="panel-body">
            @if(isset($providers))
                <div class="row">
                    @forelse($providers as $provider)
                        <div class="col-sm-6">
                            <input type="checkbox" 
                                name="providers['{{ $loop->index }}'][provider_id]" 
                                value="{{ $provider->id }}" 
                                {{ ($provider->providesThisService) ? 'checked="checked"' : '' }}> {{ $provider->name }}
                        </div>
                    @empty
                    <span>No providers found</span>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</div>

