<?php

namespace LaraBooking\Models;

use KingOfCode\Upload\Uploadable;
use Illuminate\Notifications\Notifiable;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Uploadable, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'name',
        'email',
        'type',
        'password',
        'description',
        'address',
        'city',
        'state',
        'zip_code'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $searchable = [
        'columns' => [
            'email' => 10,
            'name' => 9,
            'description' => 7,
            'address' => 6,
            'city' => 5,
            'state' => 5
        ]
    ];

    protected $uploadableImages = [
        'image'
    ];

    public function services() {
        return $this->belongsToMany(Service::class, 'provider_service', 'provider_id', 'service_id');
    }

    public function phones() {
        return $this->hasMany(UserPhone::class);
    }

    public function clientAppointments() {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    public function providerAppointments() {
        return $this->hasMany(Appointment::class, 'provider_id');
    }

    public function isClient() {
        return $this->type == 'client';
    }

    public function isSecretary() {
        return $this->type == 'secretary';
    }

    public function isProvider() {
        return $this->type == 'provider';
    }

    public function isAdmin() {
        return $this->type == 'admin';
    }

    public function typeInArray($typesArray = []) {
        return in_array($this->type, $typesArray);
    }
}
