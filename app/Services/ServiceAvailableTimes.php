<?php

namespace LaraBooking\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\CarbonInterval;
use LaraBooking\Repositories\AppointmentRepository;

class ServiceAvailableTimes {

    /** Basica date to calculate the available times */
    protected $date;

    /** Service to calculate the available times duration */
    protected $service;

    /** Provider to filter the appointments */
    protected $provider;

    /** Service that manage the business schedule  */
    protected $businessHours;

    /** Reference to the Appointments Repository */
    protected $appointmentRepository;

    /** Used to manage the available time intervals */
    protected $availableTimeIntervals = [];

    public function __construct($date, $service, $provider) {
        $this->businessHours = new BusinessHours;
        $this->appointmentRepository = new AppointmentRepository;

        $this->service = $service;
        $this->provider = $provider;
        $this->date = Carbon::createFromFormat('Y-m-d H:i', $date . ' 00:00');
    }

    /**
     * Get the available times for the date. If the date informed is past, will return a empty array
     */
    public function getAvailableTimes() {
        if($this->date < Carbon::today())
            return [];

        return $this->calculateAvailableTimes();
    }

    private function calculateAvailableTimes() {
        $businessPlans = $this->getBusinessPlans();
        $periods = $this->createPeriodsUsingAppointments($businessPlans);
        $durationPeriods = $this->dividePeriodsByServiceDuration($periods);
        $availableTimes = $this->buildAvailableTimes($durationPeriods);
        return $availableTimes;
    }

    private function getBusinessPlans() {
        $dayOfWeekNumeric = $this->date->dayOfWeek;
        $dayOfWeek = $this->businessHours->getWeekDayByNumericKey($dayOfWeekNumeric);
        
        // Get all the business schedule plans
        $allPlans = settings('business_plans');
        $allPlans = ($allPlans) ? json_decode($allPlans) : [];

        if(empty($allPlans)) {
            array_push($allPlans, $this->businessHours->getBasicPlan());
        }

        $plans = [];
        foreach ($allPlans as $plan) {

            // Get only the business plans with the correct Day of Week and separate the time in hours and minutes
            if(isset($plan->daysOfWeek->{$dayOfWeek}) && ($plan->daysOfWeek->{$dayOfWeek})) {
                $plan->start = $this->separateHourAndMinutes($plan->start);
                $plan->end = $this->separateHourAndMinutes($plan->end);
                $plans[] = $plan;
            }
        }

        return $plans;
    }

    private function createPeriodsUsingAppointments($plans) {
        $periods = [];
        
        // For each business plans, load the appointments inside and split in available periods
        foreach ($plans as $period) {
            $period->start = $this->date->copy()->addHours($period->start->hours)->addMinutes($period->start->minutes);
            $period->end = $this->date->copy()->addHours($period->end->hours)->addMinutes($period->end->minutes);

            $appointmentsFilters = [
                'provider_id' => $this->provider->id
            ];

            $periodAppointments = $this->appointmentRepository->getAppointmentsByPeriod($period->start, $period->end, $appointmentsFilters, false);
            $periods[] = $this->splitPeriodIntoAvailableTimeIntervals($period, $periodAppointments);
        }

        return $periods;
    }

    private function splitPeriodIntoAvailableTimeIntervals($period, $periodAppointments = []) {
        if(count($periodAppointments) > 0) {
            $this->buildFirstAvailableInterval($period, $periodAppointments);
            $this->buildNextAvailableIntervals($periodAppointments);
            $this->buildLastAvailableInterval($period, $periodAppointments);
        }else{
            $this->buildAvailableIntervalWithoutAppointments($period);
        }
        
        return $this->availableTimeIntervals;
    }

    private function buildFirstAvailableInterval($period, $periodAppointments) {
        
        $firstAppointment = $periodAppointments->first();

        if($firstAppointment->start > $period->start) {
            
            $newInterval = $this->createNewInterval( $period->start, $firstAppointment->start );
            array_push($this->availableTimeIntervals, $newInterval);

        }
    }

    private function buildNextAvailableIntervals($periodAppointments = []) {

        for($appointment = 0; $appointment < count($periodAppointments); $appointment++) {
            
            $actualAppointment = $periodAppointments[$appointment];
            $nextAppointment = isset($periodAppointments[$appointment + 1]) ? $periodAppointments[$appointment + 1] : null;

            // If the next appointment start time is greater than the last appointment end time, this means that
            // there is a new available time period in this interval
            if(($nextAppointment) && ($nextAppointment->start > $actualAppointment->end)){

                $newInterval = $this->createNewInterval( $actualAppointment->end, $nextAppointment->start );
                array_push($this->availableTimeIntervals, $newInterval);

            }

        }

    }

    private function buildLastAvailableInterval($period, $periodAppointments) {

        $lastAppointment = $periodAppointments->last();

        if($lastAppointment->end < $period->end) {
            
            $newInterval = $this->createNewInterval( $lastAppointment->end, $period->end );
            array_push($this->availableTimeIntervals, $newInterval);

        }

    }

    private function buildAvailableIntervalWithoutAppointments($period) {

        $newInterval = $this->createNewInterval( $period->start, $period->end );
        array_push($this->availableTimeIntervals, $newInterval);

    }

    private function createNewInterval($start, $end) {
        $newInterval = new \StdClass;
        $newInterval->start = $start->copy();
        $newInterval->end = $end->copy();

        return $newInterval;
    }
    
    private function dividePeriodsByServiceDuration($periods) {
        $durationPeriods = [];

        foreach ($periods as $periodIntervals) {

            foreach($periodIntervals as $periodInterval) {
                
                $durationPeriods[] = new \DatePeriod(
                    $periodInterval->start,
                    new \DateInterval('PT' . $this->service->duration . 'M'),
                    $periodInterval->end
                );

            }

        }

        return $durationPeriods;
    }

    private function buildAvailableTimes($durationPeriods) {
        $availableTimes = [];

        foreach ($durationPeriods as $period) {

            foreach ($period as $interval) {
                
                // Verify if the interval has more time that the service duration and add it to de available times array
                if($this->minutesDifference($interval, $period->end) >= $this->service->duration) {
                    array_push($availableTimes, $interval->format('H:i'));
                }

            }

        }
        
        $availableTimes = array_unique($availableTimes);
        return array_values($availableTimes);
    }

    private function separateHourAndMinutes($time) {
        $separated = new \StdClass();
        
        $time = explode(':', $time);
        $separated->hours = (int) $time[0];
        $separated->minutes = (int) $time[1];

        return $separated;
    }

    private function minutesDifference($firstDate, $secondDate) {
        $difference = $firstDate->diff($secondDate);
        $minutes = $difference->days * 24 * 60;
        $minutes += $difference->h * 60;
        $minutes += $difference->i;

        return $minutes;
    }

}