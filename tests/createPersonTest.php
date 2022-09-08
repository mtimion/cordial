<?php

namespace Tests;



class createPersonTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_create_person_via_api()
    {
        $personData = ['name' => 'Alexander Hamilton', 'birthdate' => '1923-05-06', 'timezone'=>'America/New_York'];

        $request = $this->post('/person', $personData);
        $this->assertTrue($request->response->json());

    }

}
