<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;
use Database\Factories\PersonFactory;

class CompareTwoTimezones extends TestCase
{
    /**
     * This will test if the same date represented across two time zones will register as the same birthdate.
     * Midnight on Jan 19 in New York should be the same as 9pm on Jan 18 in Los Angeles
     */
    public function test_same_date_different_timezones()
    {
        $fakePersonFactory = new PersonFactory();

        $date1 = Carbon::create('1997', null, null , 0, 0, 0, 'America/New_York');
        $date1->addWeek();

        $fakePerson = $fakePersonFactory->create(['birthdate'=>$date1->tz('UTC')->format('Y-m-d H:i:s'), 'timezone'=>'America/New_York']);

        $date2 = Carbon::create(null, null, null , 0, 0, 0, 'America/New_York');
        $date2->addWeek();
        $date2->setTimezone('America/Los_Angeles');

        $helper = new BirthdayHelper($fakePerson);
        $helper->setEndDate($date2);
        $this->assertTrue($helper->isBirthdayToday());
    }

}
