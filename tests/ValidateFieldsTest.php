<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;

class ValidateFieldsTest extends TestCase
{
    /**
     * Ensure an invalid Birthdate throws an error
     */

    public function test_invalid_date()
    {

        $response = $this->post('/person', ['name' => 'Firstname Lastname', 'birthdate' => 'Honda', 'timezone'=>'America/New_York']);

        $this->assertArrayHasKey('birthdate', $response->response->json());


    }

    /**
     * Ensure an invalid timezone throws an error.
     */
    public function test_invalid_timezone()
    {

        $response = $this->post('/person', ['name' => 'Firstname Lastname', 'birthdate' => '1923-01-02', 'timezone'=>'Chicago']);

        $this->assertArrayHasKey('timezone', $response->response->json());


    }

}
