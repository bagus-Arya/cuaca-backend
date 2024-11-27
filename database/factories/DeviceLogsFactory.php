<?php

namespace Database\Factories;

use App\Models\DeviceLogs;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceLogsFactory extends Factory
{
    protected $model = DeviceLogs::class;

    public function definition()
    {
        return [
            'machine_id' => null,
            'lat' => $this->faker->randomFloat(6, -90, 90),
            'lng' => $this->faker->randomFloat(6, -180, 180),
            'suhu' => $this->faker->randomFloat(2, 20, 40),
            'kecepatan_angin' => $this->faker->randomFloat(2, 0, 100),
            'tekanan_udara' => $this->faker->randomFloat(2, 900, 1100),
            'kelembaban' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}