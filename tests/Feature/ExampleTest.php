<?php
 
namespace Tests\Feature;
 
use Tests\TestCase;
 
class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_interacting_with_headers()
    {
        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->post('/updateCart', ['name' => 'Sally']);
 
        $response->assertStatus(201);
    }
}