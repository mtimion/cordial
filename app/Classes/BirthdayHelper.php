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

    private $birthdate;
    private $nextBirthday;
    private $endDate = null;

    public function __construct($person)
    {
        $this->birthdate = Carbon::parse($person->birthdate)
            ->tz('GMT'); //GMT is how we store the dates in the DB
        $this->birthdate->setTimezone($person->timezone);

        $this->nextBirthday = $this->getNextBirthday();
    }


    public function getBirthdate() : Carbon
    {
        return $this->birthdate;
    }

    /**
     * Returns the next birthday.
     * Calculates the birthday this year, and then see if it has already occured. If so, give next year's date.
     * @return Carbon
     */
    private function getNextBirthday() {
        //create birthday this year in user's timezone
        $nextBirthdayStart = Carbon::create(null, $this->birthdate->format('m'), $this->birthdate->format('d'), 0,0,0,$this->birthdate->tz());
        $nextBirthdayEnd = Carbon::create(null, $this->birthdate->format('m'), $this->birthdate->format('d'), 23,59,59,$this->birthdate->tz());

        if ($nextBirthdayEnd->isPast()) { //if birthday has already passed, use next year
            $nextBirthdayStart->addYear();
        }
        return $nextBirthdayStart;
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
        return ($this->getEndDate()->format('Y-m-d') == $this->nextBirthday->format('Y-m-d'));
    }


    /**
     * returns Carbon interval between two dates
     * Default to birthdate this year
     * Default to $this->enddate if no 2nd date specified
     * @return \Carbon\CarbonInterval
     */
    public function getInterval(Carbon $startDate = null, Carbon $endDate = null) {
        $startDate = !$startDate ? $this->nextBirthday : $startDate;
        $endDate = !$endDate ? $this->getEndDate() : $endDate;

        return  $startDate->diffAsCarbonInterval($endDate);
    }

    public function getIntervalUntilTomorrow() {
        $now = Carbon::now($this->birthdate->tz());
        $tomorrow = Carbon::create(null, null, null, 0, 0, 0, $this->birthdate->tz());
        $tomorrow->addDay();
        return $this->getInterval($now, $tomorrow);
    }

    /**
     * returns human-readable message for interval until birthday
     * @param $name
     */
    public function getIntervalMessage($name) {
        $message = $name;
        $message .= ' is '. $this->birthdate->diffInYears($this->nextBirthday). ' years old ';


        if ($this->isBirthdayToday()) {

            $interval = $this->getIntervalUntilTomorrow();

            $message .= 'today.';
            $message .= ' Birthday ends in ';
            if ($interval->h > 0) {
                $message .= $interval->h. ' hours ';
            } else {
                $message .= $interval->i. ' minutes ';
            }
        } else {
            $interval = $this->getInterval($this->getEndDate(), $this->nextBirthday);

            $message .= 'in ' .$interval->m. ' months, '. $interval->d. ' days ';

        }
        $message .= 'in '. $this->birthdate->tz();
        return $message;
    }


}