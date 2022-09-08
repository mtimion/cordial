<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;
use Database\Factories\PersonFactory;

class CompareTwoTimezones extends TestCase
{
    /**
     * This test will give two identical dates with different timezones and make sure they do not register as true.
     *
     *
     * @return void
     */

    public function test_different_timezones()
    {
        $fakePersonFactory = new PersonFactory();
        $date1 = Carbon::createFromDate('1997','01','19')->tz('America/Los_Angeles');
        $fakePerson = $fakePersonFactory->create(['birthdate'=>$date1->tz('UTC')->format('Y-m-d H:i:s'), 'timezone'=>'America/Los_Angeles']);
        $date2 = Carbon::createFromDate('1997','01','19')->tz('America/New_York');
        $helper = new BirthdayHelper($fakePerson);
        $helper->setEndDate($date2);
        $this->assertFalse($helper->isBirthdayToday());
    }

    /**
     * This will test if the same date represented across two time zones will register as the same birthdate.
     * Midnight on Jan 19 in New York should be the same as 9pm on Jan 18 in Los Angeles
     */
    public function test_same_date_different_timezones()
    {
        $fakePersonFactory = new PersonFactory();
        $date1 = Carbon::create('1997','01','19', 0, 0, 0, 'America/New_York');
        $fakePerson = $fakePersonFactory->create(['birthdate'=>$date1->tz('UTC')->format('Y-m-d H:i:s'), 'timezone'=>'America/New_York']);
        $date2 = Carbon::create(null,'01','18', 21, 0, 0, 'America/Los_Angeles');

        $helper = new BirthdayHelper($fakePerson);
        $helper->setEndDate($date2);
        $this->assertTrue($helper->isBirthdayToday());
    }

}
