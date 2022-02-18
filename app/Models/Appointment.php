<?php

namespace LaraBooking\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    protected $fillable = [
        'start',
        'end',
        'description',
        'status',
        'client_id',
        'service_id',
        'provider_id',
    ];

    protected $dates = [
        'start',
        'end',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'title'
    ];

    public function client() {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function provider() {
        return $this->belongsTo(User::class, 'provider_id');
    }

    /**
     * Get the Appointment Title to show in the calendar, 
     * concatenating the client and service name.
     * @return string Appointment Title
     */
    public function getTitleAttribute() {
        return "{$this->client->name} - {$this->service->name} - {$this->provider->name}";
    }

    /**
     * This scope method filter and return the appointments by the user type
     * @return Query
     */
    public static function scopeFilterByUserType($query) {
        if(Auth::user()->isProvider()) {
            
            $provider_id = Auth::user()->id;
            return $query->where('provider_id', $provider_id);
        
        }else if(Auth::user()->isClient()) {
        
            $client_id = Auth::user()->id;
            return $query->where('client_id', $client_id);
        
        }

        return $query;
    }

}