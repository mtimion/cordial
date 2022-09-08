<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;
use Database\Factories\PersonFactory;

class IsBirthdayTodayTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_if_birthday_is_today()
    {
        $fakePersonFactory = new PersonFactory();

        $birthday = Carbon::createFromDate(1975, null, null)->tz('America/New_York'); //today's date in 1975
        $fakePerson = $fakePersonFactory->create(['birthdate'=>$birthday->tz('UTC')->format('Y-m-d H:i:s'), 'timezone'=>$birthday->tz()]);

        $birthdayHelper = new BirthdayHelper($fakePerson);
        $this->assertTrue($birthdayHelper->isBirthdayToday());
    }

}
