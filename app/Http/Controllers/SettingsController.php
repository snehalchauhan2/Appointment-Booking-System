<?php

namespace LaraBooking\Http\Controllers;

use Illuminate\Http\Request;
use LaraBooking\Models\Settings;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('manage', Settings::class);
        return view('home.settings.index')->with('settings');
    }

    /**
     * Store all the settings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('manage', Settings::class);

        return DB::transaction(function() use ($request) {
        
            $request->validate([
                'company_name' => 'required|max:128',
                'company_email' => 'required|email|max:128',
                'email_notify' => 'required|boolean',
                'appointment_reserved_notify' => 'required|boolean',
                'plans' => 'array',
                'plans.*.daysOfWeek' => 'required|array'
            ]);

            Settings::setValueByName('company_name', $request->get('company_name'));
            Settings::setValueByName('company_email', $request->get('company_email'));
            Settings::setValueByName('email_notify', $request->get('email_notify'));
            Settings::setValueByName('appointment_reserved_notify', $request->get('appointment_reserved_notify'));
            Settings::setValueByName('business_plans', $request->get('plans', []));

            return redirect()->route('home.settings.index')
                ->withSuccess('Saved successfuly!');

        });
    }

}
