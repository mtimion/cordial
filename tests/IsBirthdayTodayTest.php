<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;
use Database\Factories\PersonFactory;

class IsBirthdayTodayTest extends TestCase
{
    /**
     * Make sure that a birthdate today is recognized as today.
     *
     * @return void
     */
    public function test_if_birthday_is_today()
    {
        $fakePersonFactory = new PersonFactory();

        $birthday = Carbon::create(1975, null, null, 0, 0, 0, 'America/New_York'); //today's date in 1975
        $fakePerson = $fakePersonFactory->create(['birthdate'=>$birthday->tz('UTC')->format('Y-m-d H:i:s'), 'timezone'=>'America/New_York']);

        $birthdayHelper = new BirthdayHelper($fakePerson);
        $this->assertTrue($birthdayHelper->isBirthdayToday());
    }

}
