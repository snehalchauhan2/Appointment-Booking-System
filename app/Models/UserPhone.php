<?php

namespace LaraBooking\Models;

use KingOfCode\Upload\Uploadable;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class UserPhone extends Model
{
    use SearchableTrait, Uploadable;

    protected $fillable = [
        'phone',
        'user_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }


}