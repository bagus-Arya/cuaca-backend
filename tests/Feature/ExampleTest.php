<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Device;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function testMachine()
    {
        // Create a device in the database
        $device = Device::factory()->create([
            'name' => 'Test Device',
            'status' => 'active',
        ]);

        // Send a GET request to the /api/device endpoint
        $response = $this->get('/api/device');

        // Assert that the response has a 200 status code
        $response->assertStatus(200);

        // Assert that the response structure is as expected
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'machine_id',
                    'suhu',
                ],
            ],
        ]);

        // Optionally, assert that the response contains the created device
        $response->assertJsonFragment([
            'name' => 'Test Device',
            'status' => 'active',
        ]);
    }
}