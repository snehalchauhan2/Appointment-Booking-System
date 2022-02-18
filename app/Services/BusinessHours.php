<?php

namespace LaraBooking\Services;

/**
* This Service will be used to convert the business hours settings
* to a readable front-end JSON
*/
class BusinessHours
{
    /**
     * Get the business plans of the company converted to the Full Callendar Business Hours format
     * @return Array Business Hours
     */
    public function getConvertedToFullCalendarFormat() {
        $plans = settings('business_plans');
        $plans = ($plans) ? json_decode($plans) : [];
        $businessHours = [];

        foreach ($plans as $key => $plan) {
            $businessHours[] = [
                'dow' => $this->convertDaysOfWeek($plan->daysOfWeek),
                'start' => $plan->start,
                'end' => $plan->end
            ];
        }

        return collect($businessHours);
    }

    /**
     * Convert the Days of Week in the Business Plans Settings to the Full Calendar Format
     * @param  Object $daysOfWeek The Days of Week object
     * @return Array            Days of Week in the Full Calendar Format
     */
    private function convertDaysOfWeek($daysOfWeek) {
        $days = $this->getWeekDaysWithNameKey();
        
        $allDays = [];

        foreach ($daysOfWeek as $day => $value) {
            $allDays[] = $days[$day];
        }

        return $allDays;
    }

    /**
     * Get all week days with name keys
     * @return Array
     */
    public function getWeekDaysWithNameKey() {
        return [
            'sunday' => 0, 
            'monday' => 1, 
            'tuesday' => 2, 
            'wednesday' => 3, 
            'thursday' => 4, 
            'friday' => 5, 
            'saturday' => 6
        ];
    }

    /**
     * Get all week days with numeric keys
     * @return Array
     */
    public function getWeekDaysWithNumericKey() {
        return array_flip($this->getWeekDaysWithNameKey());
    }

    public function getWeekDayByNumericKey($key) {
        $days = $this->getWeekDaysWithNumericKey();
        return $days[$key];
    }

    public function getBasicPlan() {
        $plan = new \StdClass;

        $plan->daysOfWeek = new \StdClass;
        $plan->daysOfWeek->sunday = true; 
        $plan->daysOfWeek->monday = true; 
        $plan->daysOfWeek->tuesday = true; 
        $plan->daysOfWeek->wednesday = true; 
        $plan->daysOfWeek->thursday = true;
        $plan->daysOfWeek->friday = true;
        $plan->daysOfWeek->saturday = true;
        
        $plan->start = '00:00';
        $plan->end = '23:59';

        return $plan;
    }

}