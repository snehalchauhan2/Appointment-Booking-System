<?php

namespace LaraBooking\Repositories;

use LaraBooking\Models\User;
use Illuminate\Support\Carbon;
use LaraBooking\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use LaraBooking\Mail\AppointmentChanged;
use LaraBooking\Mail\AppointmentReserved;
use LaraBooking\Repositories\Base\CrudRepository;

class AppointmentRepository extends CrudRepository {

    /**
     * Specify Model class name
     *
     */
    protected $modelClass = Appointment::class;

    public function getAppointmentsByPeriod($start, $end, $filters = [], $filterByUserType = true) {
        $query = $this->newQuery();

        if($filterByUserType)
            $query->filterByUserType();

        if($start && $end) {
            $query->where(function($query) use ($start, $end) {
                $query->where(function($query) use ($start, $end) {
                    $query->where('start', '>=', $start);
                    $query->where('start', '<=', $end);
                });
    
                $query->orWhere(function($query) use ($start, $end) {
                    $query->where('end', '>=', $start);
                    $query->where('end', '<=', $end);
                });
            });
        }

        if(isset($filters['provider_id'])) {
            $query->where('provider_id', $filters['provider_id']);
        }

        if(isset($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }

        $query->orderBy('start');

        return $this->doQueryWithoutPagination($query);
    }

    public function saveAppointment($data) {
        $data = $this->treatAppointmentData($data);
        $appointment = $this->create($data);

        return $appointment;
    }

    public function saveClientAppointment($data, $service) {
        $start = Carbon::createFromFormat('Y-m-d H:i', $data['start']);
        $end = $start->copy()->addMinutes($service->duration);
        
        $data['start'] = $start->toDateTimeString();
        $data['end'] = $end->toDateTimeString();

        $client = Auth::user();
        $data['client_id'] = $client->id;

        $appointment = $this->create($data);

        if(settings('appointment_reserved_notify')) {
            Mail::send(new AppointmentReserved($appointment));
        }

        return $appointment;
    }

    public function updateAppointment($appointment, $data) {
        $data = $this->treatAppointmentData($data);
        $this->update($appointment, $data);

        if(settings('email_notify')) {
            Mail::to($appointment->client)->send(new AppointmentChanged($appointment));
        }

        return $appointment;
    }

    private function treatAppointmentData($data) {
        $data['start'] = Carbon::createFromFormat('Y-m-d H:i', $data['start'])->toDateTimeString();
        $data['end'] = Carbon::createFromFormat('Y-m-d H:i', $data['end'])->toDateTimeString();

        return $data;
    }
}

