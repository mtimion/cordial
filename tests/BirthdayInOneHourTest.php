<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;
use Database\Factories\PersonFactory;

class BirthdayInOneHourTest extends TestCase
{
    /**
     * dates are one hour apart.
     *
     * @return void
     */
    public function test_if_birthday_in_one_hour_is_today()
    {
        $fakePersonFactory = new PersonFactory();
        $birthday = Carbon::create('1997',01,2, 0, 0, 0, 'America/New_York');

        $fakePerson = $fakePersonFactory->create(['birthdate'=>$birthday->tz('UTC')->format('Y-m-d H:i:s'), 'timezone'=>'America/New_York']);

        $birthdayHelper = new BirthdayHelper($fakePerson);
        $endDate = Carbon::create(null, 1, 1, 23, 00, 00, 'America/New_York'); //one hour before birthdate
        $birthdayHelper->setEndDate($endDate);
        $this->assertFalse($birthdayHelper->isBirthdayToday());
    }

}
