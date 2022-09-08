<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class GetTest extends TestCase
{
    /**
     * A basic test example. Ensure web service is responding
     *
     * @return void
     */
    public function test_that_base_endpoint_returns_a_successful_response()
    {
        $this->get('/person');
        $this->assertResponseOk();
    }
}
