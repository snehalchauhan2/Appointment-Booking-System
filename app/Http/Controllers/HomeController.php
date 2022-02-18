<?php

namespace LaraBooking\Http\Controllers;

use Illuminate\Http\Request;
use LaraBooking\Models\Appointment;
use LaraBooking\Services\BusinessHours;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $businessHours = (new BusinessHours)->getConvertedToFullCalendarFormat();
        return view('home', compact('businessHours'));
    }
}
