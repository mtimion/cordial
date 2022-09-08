<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;
use Database\Factories\PersonFactory;

class IsBirthdayNotTodayTest extends TestCase
{
    /**
     * Ensure that two dates do not register as the same date
     *
     * @return void
     */

    public function test_if_birthday_is_not_today()
    {
        $fakePersonFactory = new PersonFactory();

        $birthday = Carbon::create(1975, 1, 5, 0, 0, 0, 'America/New_York'); //today's date in 1975

        $fakePerson = $fakePersonFactory->create(['birthdate'=>$birthday->format('Y-m-d H:i:s'), 'timezone'=>'America/New_York']);

        $today = Carbon::create(null, 1, 10, 0, 0, 0, 'America/New_York'); //this year, january 10th
        $birthdayHelper = new BirthdayHelper($fakePerson);
        $birthdayHelper->setEndDate($today);

        $this->assertFalse($birthdayHelper->isBirthdayToday());
    }
}
