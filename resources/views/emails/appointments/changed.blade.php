<div>
    Hi, {{ $appointment->client->name }}
    
    <br>
    <br>
    
    Your appointment with <b>{{ settings('company_name') }}</b> has been modified:
    
    <br>
    <br>

    <div>
        <div>
            <span><b>Service:</b></span> {{ $appointment->service->name }}
        </div>
        <div>
            <span><b>Provider:</b></span> {{ $appointment->provider->name }}
        </div>
        <div>
            <span><b>Start:</b></span> {{ date('m/d/Y H:i', strtotime($appointment->start)) }}
        </div>
        <div>
            <span><b>End:</b></span> {{ date('m/d/Y H:i', strtotime($appointment->end)) }}
        </div>
        <div>
            <span><b>Description:</b></span> {{ $appointment->description }}
        </div>
        <div>
            <span><b>Status:</b></span> {{ $appointment->status }}
        </div>
    </div>
    
    <br>
    Any question, please contact us.
    
    <br>
    <br>
    
    {{ settings('company_name') }} Team

</div>