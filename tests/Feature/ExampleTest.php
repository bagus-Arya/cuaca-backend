<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Device;
use App\Models\DeviceLogs;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Hash;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_machine()
    {
        // Create a user
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Authenticate the user with Sanctum
        Sanctum::actingAs($user, ['*']);

        // Create a device and associated device logs
        $device = Device::factory()->create();
        DeviceLogs::factory()->create([
            'machine_id' => $device->id
        ]);

        // Make a GET request to the /api/device endpoint
        $response = $this->getJson('/api/device');
        
        // Assert the response status code and structure
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'lat',
                        'lng',
                        'suhu',
                        'kecepatan_angin',
                        'tekanan_udara',
                        'kelembaban',
                        'kondisi_baik',
                        'active'
                    ]
                ]
            ]);
    }
}