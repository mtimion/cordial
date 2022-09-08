<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;

class MissingFieldsTest extends TestCase
{
    /**
     * Validate that a request with a missing name returns an error
     *
     * @return void
     */
    public function test_missing_name()
    {

        $response = $this->post('/person', ['name' => '', 'birthdate' => '1923-01-24', 'timezone'=>'America/New_York']);

        $this->assertArrayHasKey('name', $response->response->json());

    }

    /**
     * Ensure that a request without a birthdate returns an error
     */
    public function test_missing_date()
    {

        $response = $this->post('/person', ['name' => 'Firstname Lastname', 'birthdate' => '', 'timezone'=>'America/New_York']);

        $this->assertArrayHasKey('birthdate', $response->response->json());


    }

    /**
     * Ensure a request withtout a timezone returns an error
     */
    public function test_missing_timezone()
    {

        $response = $this->post('/person', ['name' => 'Firstname Lastname', 'birthdate' => '1923-01-02', 'timezone'=>'']);

        $this->assertArrayHasKey('timezone', $response->response->json());


    }

}
