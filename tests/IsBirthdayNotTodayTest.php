<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;
use Database\Factories\PersonFactory;

class IsBirthdayNotTodayTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_if_birthday_is_not_today()
    {
        $fakePersonFactory = new PersonFactory();

        $birthday = Carbon::createFromDate(1975, 1, 5)->tz('America/New_York'); //today's date in 1975

        $fakePerson = $fakePersonFactory->create(['birthdate'=>$birthday->format('Y-m-d'), 'timezone'=>$birthday->tz()]);

        $today = Carbon::createFromDate(null, 1, 10)->tz('America/New_York'); //this year, january 10th
        $birthdayHelper = new BirthdayHelper($fakePerson);
        $birthdayHelper->setEndDate($today);

        $this->assertFalse($birthdayHelper->isBirthdayToday());
    }
}
