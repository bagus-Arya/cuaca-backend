<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeviceLogs;
use App\Models\UserDevices;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function getAllHistory(Request $request) {
        $logs = DeviceLogs::orderBy('created_at', 'DESC') -> paginate(10);
        return $logs;
    }

        
    // get all data
    public function getHistoryByMachineId(Request $request, $machineId) {
        $logs = UserDevices::with(['device.deviceLogs'])
                        ->where('device_id', $machineId)
                        ->orderBy('created_at', 'DESC')
                        ->paginate(10);
            
        return $logs;
    }

    public function getUserDevices(Request $request, $userId) {
        // Fetch user devices with related user and device information
        $logs = UserDevices::with(['user', 'device.deviceLogs' => function($query) {
            $query->orderBy('created_at', 'DESC'); 
        }])
        ->where('user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->get();
    
        // Check if logs are empty
        if ($logs->isEmpty()) {
            return response()->json([
                'data' => [],
            ], 200);
        }

        $timeThreshold = now()->subMinutes(2);
            
        // Map the logs to include the status and format the response
        $formattedLogs = $logs->map(function ($log) use ($timeThreshold) {
            
            $latestLog = $log->device->deviceLogs->first();
            $status = $latestLog->created_at >= $timeThreshold ? 'online' : 'offline';

            return [
                'status' => $status,
                'id' => $log->id,
                'device_id' => $log->device_id,
                'user_id' => $log->user_id,
                's' => $latestLog->created_at,
                'b' => $timeThreshold,
                'user' => [
                    'id' => $log->user->id,
                    'name' => $log->user->name,
                    'email' => $log->user->email,
                    'role' => $log->user->role,
                ],
                'device' => [
                    'id' => $log->device->id,
                    'place_name' => $log->device->place_name,
                    'logs' => $latestLog,
                ],
            ];
        });

        return response()->json([
            'data' => $formattedLogs
        ], 200);
    }

    public function predictThreeDays(Request $request, $machineId)
    {
        $data = DeviceLogs::with(['device'])->where('machine_id', $machineId)->orderBy('created_at', 'DESC')->take(10)->get();

        $latestData = $data->first();

        $suhuData = [];
        $kecepatanAnginData = [];
        $tekananUdaraData = [];
        $kelembabanData = [];

        foreach ($data as $log) {
            $suhuData[] = $log->suhu;
            $kecepatanAnginData[] = $log->kecepatan_angin;
            $tekananUdaraData[] = $log->tekanan_udara;
            $kelembabanData[] = $log->kelembaban;
        }

        $averageSuhu = array_sum($suhuData) / count($suhuData);
        $averageKecepatanAngin = array_sum($kecepatanAnginData) / count($kecepatanAnginData);
        $averageTekananUdara = array_sum($tekananUdaraData) / count($tekananUdaraData);
        $averageKelembaban = array_sum($kelembabanData) / count($kelembabanData);

        $predictions = [];
        $alpha = 0.3; // Smoothing factor

        // Suhu predictions
        $suhuPrediction = [];
        $suhuPrediction[0] = $averageSuhu;
        for ($i = 1; $i < 4; $i++) {
            if (count($suhuData) > 0) {
                $suhuPrediction[$i] = $alpha * end($suhuData) + (1 - $alpha) * ($suhuPrediction[$i - 1]);
            }
        }
        // Kecepatan Angin predictions
        $kecepatanAnginPrediction = [];
        $kecepatanAnginPrediction[0] = $averageKecepatanAngin;
        for ($i = 1; $i < 4; $i++) {
            if (count($kecepatanAnginData) > 0) {
                $kecepatanAnginPrediction[$i] = $alpha * end($kecepatanAnginData) + (1 - $alpha) * ($kecepatanAnginPrediction[$i - 1]);
            }
        }
        // Tekanan Udara predictions
        $tekananUdaraPrediction = [];
        $tekananUdaraPrediction[0] = $averageTekananUdara;
        for ($i = 1; $i < 4; $i++) {
            if (count($tekananUdaraData) > 0) {
                $tekananUdaraPrediction[$i] = $alpha * end($tekananUdaraData) + (1 - $alpha) * ($tekananUdaraPrediction[$i - 1]);
            }
        }
        // Kelembaban predictions
        $kelembabanPrediction = [];
        $kelembabanPrediction[0] = $averageKelembaban;
        for ($i = 1; $i < 4; $i++) {
            if (count($kelembabanData) > 0) {
                $kelembabanPrediction[$i] = $alpha * end($kelembabanData) + (1 - $alpha) * ($kelembabanPrediction[$i - 1]);
            }
        }
        // predictions
        $predictions[] = [
            'date' => now()->addDay(1)->toDateString(),
            'predicted_suhu' => round($suhuPrediction[1], 2),
            'predicted_kecepatan_angin' => round($kecepatanAnginPrediction[1], 2),
            'predicted_tekanan_udara' => round($tekananUdaraPrediction[1], 2),
            'predicted_kelembaban' => round($kelembabanPrediction[1], 2),
        ];

        $predictions[] = [
            'date' => now()->addDay(2)->toDateString(),
            'predicted_suhu' => round($suhuPrediction[2], 2),
            'predicted_kecepatan_angin' => round($kecepatanAnginPrediction[2], 2),
            'predicted_tekanan_udara' => round($tekananUdaraPrediction[2], 2),
            'predicted_kelembaban' => round($kelembabanPrediction[2], 2),
        ];

        $predictions[] = [
            'date' => now()->addDay(3)->toDateString(),
            'predicted_suhu' => round($suhuPrediction[3], 2),
            'predicted_kecepatan_angin' => round($kecepatanAnginPrediction[3], 2),
            'predicted_tekanan_udara' => round($tekananUdaraPrediction[3], 2),
            'predicted_kelembaban' => round($kelembabanPrediction[3], 2),
        ];

        // Condition predictions
        for ($i = 1; $i <= 3; $i++) {
            $date = now()->addDay($i)->toDateString();
            if ($tekananUdaraPrediction[$i] <= 990 && $kelembabanPrediction[$i] >= 90 && $kecepatanAnginPrediction[$i] >= 15) {
                $condition = 'Cuaca Buruk'; 
            } elseif ($tekananUdaraPrediction[$i] >= 990 && $kelembabanPrediction[$i] <= 89 && $kecepatanAnginPrediction[$i] <= 14) {
                $condition = 'Cuaca Baik'; 
            } else {
                $condition = 'Tidak Diketahui'; 
            }

            $predictions[] = [
                'date' => $date,
                'condition' => $condition,
            ];
        }
    
        return response()->json([
            'latest' => $latestData,
            'data' => $predictions
        ],200);
    }

    public function predictOneWeek()
    {
        $data = DeviceLogs::orderBy('created_at', 'DESC')->take(10)->get();

        $suhuSum = 0;
        $kecepatanAnginSum = 0;
        $tekananUdaraSum = 0;
        $kelembabanSum = 0;
        $count = count($data);

        foreach ($data as $log) {
            $suhuSum += $log->suhu;
            $kecepatanAnginSum += $log->kecepatan_angin;
            $tekananUdaraSum += $log->tekanan_udara;
            $kelembabanSum += $log->kelembaban;
        }

        $averageSuhu = $count > 0 ? $suhuSum / $count : 0;
        $averageKecepatanAngin = $count > 0 ? $kecepatanAnginSum / $count : 0;
        $averageTekananUdara = $count > 0 ? $tekananUdaraSum / $count : 0;
        $averageKelembaban = $count > 0 ? $kelembabanSum / $count : 0;

        $predictions = [];
        for ($i = 0; $i <= 7; $i++) {
            $date = now()->addDays($i)->toDateString();

            if ($averageSuhu < 23 && $averageKelembaban > 1013 && $averageKecepatanAngin > 10) {
                $condition = 'Kondisi Cuaca Buruk'; 
            } elseif ($averageSuhu > 26 && $averageKelembaban < 93 && $averageKecepatanAngin < 10) {
                $condition = 'Kondisi Cuaca Baik'; 
            } else {
                $condition = 'Kondisi Tidak Diketahui'; 
            }

            $predictions[] = [
                'date' => $date,
                'predicted_suhu' => $averageSuhu,
                'predicted_kecepatan_angin' => $averageKecepatanAngin,
                'predicted_tekanan_udara' => $averageTekananUdara,
                'predicted_kelembaban' => $averageKelembaban,
                'condition' => $condition, // Include the condition in the prediction
            ];
        }

        return response()->json(['data' => $predictions]);
    }

    public function evaluateWeatherConditions()
    {
        $latestLog = DeviceLogs::orderBy('created_at', 'DESC')->first();

        $weatherConditions = [];
        $dailyData = [];

        if ($latestLog) {
            $condition = '';

            if ($latestLog->suhu < 23 && $latestLog->kelembaban > 1013 && $latestLog->kecepatan_angin > 10) {
                $condition = 'Kondisi Cuaca Buruk'; 
            } elseif ($latestLog->suhu > 26 && $latestLog->kelembaban < 93 && $latestLog->kecepatan_angin < 10) {
                $condition = 'Kondisi Cuaca Baik'; 
            } else {
                $condition = 'Kondisi Tidak Diketahui'; 
            }

            $weatherConditions[] = [
                'id' => $latestLog->id,
                'machine_id' => $latestLog->machine_id,
                'suhu' => $latestLog->suhu,
                'kelembaban' => $latestLog->kelembaban,
                'kecepatan_angin' => $latestLog->kecepatan_angin,
                'condition' => $condition,
                'created_at' => $latestLog->created_at,
            ];
        }

        $data = DeviceLogs::where('created_at', '>=', \Carbon\Carbon::now()->subWeek())->orderBy('created_at', 'DESC')->get();

        $dailyData = [];

        foreach ($data as $log) {
            $date = \Carbon\Carbon::parse($log->created_at)->toDateString();

            if (!isset($dailyData[$date])) {
                $dailyData[$date] = [
                    'total_suhu' => 0,
                    'total_kecepatan_angin' => 0,
                    'count' => 0,
                ];
            }

            $dailyData[$date]['total_suhu'] += $log->suhu;
            $dailyData[$date]['total_kecepatan_angin'] += $log->kecepatan_angin;
            $dailyData[$date]['count']++;
        }

        $dailyAverages = [];
        foreach ($dailyData as $values) {
            $dailyAverages[] = [
                'average_suhu' => $values['count'] > 0 ? $values['total_suhu'] / $values['count'] : 0,
                'average_kecepatan_angin' => $values['count'] > 0 ? $values['total_kecepatan_angin'] / $values['count'] : 0,
            ];
        }

        $predictedWeather = [];
        $today = \Carbon\Carbon::now()->startOfDay();

        for ($i = 1; $i <= 7; $i++) {
            $predictedDate = $today->copy()->addDays($i);
            $predictedWeather[] = [
                'date' => $predictedDate->toDateString(),
                'predicted_average_suhu' => array_sum(array_column($dailyAverages, 'average_suhu')) / count($dailyAverages),
                'predicted_average_kecepatan_angin' => array_sum(array_column($dailyAverages, 'average_kecepatan_angin')) / count($dailyAverages),
            ];
        }

        return response()->json([
            'weather_conditions' => $weatherConditions,
            'daily_averages' => $predictedWeather,
        ]);
    }

    public function showRainyConditions(Request $request, $machineId) {
        $logs = DeviceLogs::where('machine_id', '=', $machineId)
            ->where('kelembaban', '<=', 990) 
            ->where('tekanan_udara', '>=', 80)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    
        return response()->json($logs);
    
    }

    public function createLogs(Request $request) {
        $validate = Validator::make($request -> all(), [
            "id" => "required",  
            "lat" => "required", 
            "lng" => "required", 
            "suhu" => "required", 
            "kecepatan_angin" => "required", 
            "tekanan_udara" => "required", 
            "kelembaban" => "required", 
            "kondisi_baik" => "required"
        ]);

        if ($validate -> fails()) {
            return response([
                "status" => 'false', 
                "message" => $validate -> errors()
            ], 400);
        }

        $data = [
            "machine_id" => $request -> id,
            "lat" => $request -> lat, 
            "lng" => $request -> lng, 
            "suhu" => $request -> suhu, 
            "kecepatan_angin" => $request -> kecepatan_angin, 
            "tekanan_udara" => $request -> tekanan_udara, 
            "kelembaban" => $request -> kelembaban, 
            "kondisi_baik" => $request -> kondisi_baik 
        ];

        DeviceLogs::create($data);

        return response([
            'status' => 'true', 
            'message' => 'Data saved successfully'
        ], 200);
    }
}
