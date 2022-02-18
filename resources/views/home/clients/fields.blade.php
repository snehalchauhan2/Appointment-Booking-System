
<div class="form-group col-xs-12 col-sm-6 required">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group col-xs-12 col-sm-6 required">
    {!! Form::label('email', 'Email') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('password', 'Password (optional)') !!}
    {!! Form::password('password', ['class' => 'form-control']) !!}
</div>

<div class="form-group col-xs-12 col-sm-6">
    {!! Form::label('password_confirmation', 'Password Confirmation') !!}
    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    <div class="panel">
        <div class="panel-heading">
            <h4>Address Information</h4>
        </div>
        <div class="panel-body">
            <div class="form-group col-xs-12 col-sm-12">
                {!! Form::label('address', 'Address') !!}
                {!! Form::text('address', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-xs-12 col-sm-6">
                {!! Form::label('city', 'City') !!}
                {!! Form::text('city', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-xs-12 col-sm-3">
                {!! Form::label('state', 'State') !!}
                {!! Form::text('state', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group col-xs-12 col-sm-3">
                {!! Form::label('zip_code', 'Zip Code') !!}
                {!! Form::text('zip_code', null, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <h4>Phones</h4>

    <book-user-phones 
        form="client-form" 
        phones="{{ isset($client) ? $client->phones : '[]' }}">
    </book-user-phones>
</div>