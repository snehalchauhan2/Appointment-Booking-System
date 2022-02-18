<div>
    Hi,
    
    <br>
    <br>
    
    A new appointment was reserved in your company:
    
    <br>
    <br>

    <div>
        <div>
            <span><b>Client:</b></span> {{ $appointment->client->name }}
        </div>
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
    </div>

</div>