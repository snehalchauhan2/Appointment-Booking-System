<?php

namespace LaraBooking\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaraBooking\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * Display the site index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('site');
    }

    /**
     * Display the appointment success screen.
     *
     * @return \Illuminate\Http\Response
     */
    public function appointmentSuccess(Request $request)
    {
        return view('site.appointment_success');
    }

}