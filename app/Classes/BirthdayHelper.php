<?php

namespace App\Classes;

use Carbon\Carbon;
use App\Models\Person;

/**
 * Class DateHelper
 * @package App\Classes
 * Simple class to compare two dates
 */

class BirthdayHelper {

    private $person;
    private $birthdate;
    private $birthdateThisYear;
    private $endDate = null;

    public function __construct($person)
    {
        $this->birthdate = Carbon::parse($person->birthdate)
            ->tz('GMT'); //GMT is how we store the dates in the DB
        $this->birthdate->setTimezone($person->timezone);

        $birthdateThisYear = Carbon::create(null, $this->birthdate->format('m'), $this->birthdate->format('d'), 0,0,0,$person->timezone);

        $this->birthdateThisYear = $birthdateThisYear; //create birthday this year in user's timezone


    }


    public function getBirthdate() : Carbon
    {
        return $this->birthdate;
    }

    /**
     * Returns Carbon object of end date. Sets to now() if date is null
     * @return Carbon
     */
    private function getEndDate() {
        if (is_null($this->endDate)) {
            $this->endDate = Carbon::now($this->birthdate->tz());
        }
        return $this->endDate;
    }

    /**
     * This allows us to override what the "end date" is. Default is today
     * @param Carbon $date
     */
    public function setEndDate(Carbon $date) {

        $this->endDate = $date;
        /**
         * This is needed in case the end date has a different time zone than the birth date.
         * This will normalize the two so they can be more easily compared.
         */
        $this->endDate->setTimezone($this->birthdate->tz());

    }


    /**
     * determines if start and end date are the same calendar day
     * @return bool
     */
    public function isBirthdayToday()
    {
         return ($this->getEndDate()->format('Y-m-d') == $this->birthdateThisYear->format('Y-m-d'));
    }


    /**
     * returns Carbon interval between two dates
     * Default to birthdate this year
     * Default to $this->enddate if no 2nd date specified
     * @return \Carbon\CarbonInterval
     */
    public function getInterval(Carbon $startDate = null, Carbon $endDate = null) {
        $startDate = !$startDate ? $this->birthdateThisYear : $startDate;
        $endDate = !$endDate ? $this->getEndDate() : $endDate;

        return  $startDate->diffAsCarbonInterval($endDate);
    }

    /**
     * returns human-readable message for interval until birthday
     * @param $name
     */
    public function getIntervalMessage($name) {
        $message = $name;
        $message .= ' is '. $this->birthdate->diffInYears($this->birthdateThisYear). ' years old ';

        $interval = $this->getInterval($this->getEndDate(), $this->birthdateThisYear);

        if ($this->isBirthdayToday()) {
            $message .= 'today.';
            $message .= ' Birthday ends in ';
            if ($interval->h > 0) {
                $message .= $interval->h. ' hours ';
            } else {
                $message .= $interval->m. ' minutes ';
            }
        } else {

            $message .= 'in ' .$interval->m. ' months, '. $interval->d. ' days ';

        }
        $message .= 'in '. $this->birthdate->tz();
        return $message;
    }


}