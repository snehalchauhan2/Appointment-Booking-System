<?php

namespace LaraBooking\Models;

use KingOfCode\Upload\Uploadable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class ProviderService extends Model
{
    use SearchableTrait, Uploadable;

    protected $fillable = [
        'provider_id',
        'service_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function provider() {
        return $this->belongsTo(User::class);
    }

    public function service() {
        return $this->belongsTo(Service::class);
    }


}