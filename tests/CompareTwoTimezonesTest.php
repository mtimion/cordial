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
        $fakePerson = $fakePersonFactory->create(['birthdate'=>$date1->tz('UTC')->format('Y-m-d H:i:s'), 'timezone'=>$date1->tz()]);
        $date2 = Carbon::createFromDate('1997','01','19')->tz('America/New_York');
        $helper = new BirthdayHelper($fakePerson);
        $helper->setEndDate($date2);
        $this->assertFalse($helper->isBirthdayToday());

    }

}
