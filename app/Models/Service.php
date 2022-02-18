<?php

namespace LaraBooking\Models;

use KingOfCode\Upload\Uploadable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Service extends Model
{
    use SearchableTrait, Uploadable;

    protected $fillable = [
        'name',
        'description',
        'duration'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
    ];

    protected $searchable = [
        'columns' => [
            'name' => 10,
            'description' => 7,
        ]
    ];

    protected $uploadableImages = [
        'image',
    ];

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }

    public function providers() {
        return $this->belongsToMany(User::class, 'provider_service', 'service_id', 'provider_id');
    }

    /**
     * This method filter and return, for providers, only the services that his provides
     * @return Query 
     */
    public static function scopeFilterByUserType($query) {
        if(Auth::user()->isProvider()) {
            
            $provider_id = Auth::user()->id;
            return $query->whereHas('providers', function($query) use ($provider_id) {
                $query->where('provider_id', $provider_id);
            });
        
        }

        return $query;
    }
}