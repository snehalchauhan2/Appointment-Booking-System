<div class="form-group col-sm-6 required">
    {!! Form::label('company_name', 'Company Name') !!}
    {!! Form::text('company_name', settings('company_name'), ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6 required">
    {!! Form::label('company_email', 'Company Email') !!}
    {!! Form::email('company_email', settings('company_email'), ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('email_notify', 'E-mail Notification') !!}
    <span class="help-block">
        Send a notification to the customer when the appointment is changed
    </span>
    {!! Form::select('email_notify', ['0' => 'No', '1' => 'Yes, send the e-mail'], settings('email_notify'), ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('appointment_reserved_notify', 'Appointment Reserved Notification') !!}
    <span class="help-block">
        Send a notification to the company email when a client adds an appointment
    </span>
    {!! Form::select('appointment_reserved_notify', ['0' => 'No', '1' => 'Yes, send the e-mail'], settings('appointment_reserved_notify'), ['class' => 'form-control']) !!}
</div>

<div class="col-sm-12">
    <h4>Business Logic</h4>
    <book-business-hours form="settings-form" plans="{{ (!empty(settings('business_plans'))) ? settings('business_plans') : '[]' }}"></book-business-hours>
</div>