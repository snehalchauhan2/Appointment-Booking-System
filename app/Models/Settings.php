<?php

namespace LaraBooking\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'name',
        'value',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public static function getValueByName($name, $defaultValue = '') {
        $setting = Settings::where('name', $name)->first();
        return ($setting) ? $setting->value : $defaultValue;
    }

    public static function setValueByName($name, $value = '') {
        $setting = Settings::where('name', $name)->first();
        
        if(is_array($value)) {
            $value = json_encode($value);
        }
        
        return ($setting) ? $setting->update(['value' => $value]) : Settings::create(compact('name','value'));
    }
}
