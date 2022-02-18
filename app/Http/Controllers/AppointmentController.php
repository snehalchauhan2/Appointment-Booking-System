<?php

namespace LaraBooking\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaraBooking\Models\Appointment;
use LaraBooking\Http\Requests\StoreAppointment;
use LaraBooking\Repositories\ServiceRepository;
use LaraBooking\Repositories\AppointmentRepository;
use LaraBooking\Http\Requests\StoreClientAppointment;

class AppointmentController extends Controller
{
    /**
     * @var AppointmentRepository
     */
    protected $appointmentRepository;

    /**
     * @var ServiceRepository
     */
    protected $serviceRepository;

    public function __construct(AppointmentRepository $repository, ServiceRepository $serviceRepository){
        $this->appointmentRepository = $repository;
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $start = $request->get('start', '');
        $end = $request->get('end', '');
        
        $appointments = $this->appointmentRepository->getAppointmentsByPeriod($start, $end);

        return response()->json(compact('appointments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAppointment $request)
    {
        return DB::transaction(function() use ($request) {

            $data = $request->all();
            $appointment = $this->appointmentRepository->saveAppointment($data);
            
            return response()->json(compact('appointment'));

        });
    }

    /**
     * Store a newly appointment created by the client.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeClientAppointment(StoreClientAppointment $request)
    {
        return DB::transaction(function() use ($request) {

            $data = $request->all();

            $service = $this->serviceRepository->findByID($data['service_id']);
            $appointment = $this->appointmentRepository->saveClientAppointment($data, $service);
            
            return response()->json(true);

        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \LaraBooking\Models\Appointment  appointment
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAppointment $request, Appointment $appointment)
    {
        return DB::transaction(function() use ($request, $appointment) {

            $data = $request->all();
            $appointment = $this->appointmentRepository->updateAppointment($appointment, $data);
            
            return response()->json(compact('appointment'));

        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \LaraBooking\Models\Appointment  appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        return DB::transaction(function() use ($appointment) {

            $this->appointmentRepository->delete($appointment);
            return response()->json(true);
            
        });

    }
}
