<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/prs.qa.v1+json'
        ])->post(url('user.store'),[
            'email'=>'admin@admin.com',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
    }
}
