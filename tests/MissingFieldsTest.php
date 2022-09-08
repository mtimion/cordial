<?php

namespace Tests;

use App\Classes\BirthdayHelper;
use Carbon\Carbon;

class MissingFieldsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_missing_name()
    {

        $response = $this->post('/person', ['name' => '', 'birthdate' => '1923-01-24', 'timezone'=>'America/New_York']);

        $this->assertArrayHasKey('name', $response->response->json());

    }

    public function test_missing_date()
    {

        $response = $this->post('/person', ['name' => 'Firstname Lastname', 'birthdate' => '', 'timezone'=>'America/New_York']);

        $this->assertArrayHasKey('birthdate', $response->response->json());


    }

    public function test_missing_timezone()
    {

        $response = $this->post('/person', ['name' => 'Firstname Lastname', 'birthdate' => '1923-01-02', 'timezone'=>'']);

        $this->assertArrayHasKey('timezone', $response->response->json());


    }

}
