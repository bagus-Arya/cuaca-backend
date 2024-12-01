<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeviceLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function getAllHistory(Request $request) {
        $logs = DeviceLogs::orderBy('created_at', 'DESC') -> paginate(10);
        return $logs;
    }

    public function getHistoryByMachineId(Request $request, $id) {
        $logs = DeviceLogs::where('machine_id', $id) -> orderBy('created_at', 'DESC') -> paginate(10);
        return $logs;
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

    public function showRainyConditions(Request $request) {
        $logs = DeviceLogs::where('kelembaban', '>', 80) 
            ->where('suhu', '<', 25)
            ->where('kecepatan_angin', '<', 10)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
    
        return response()->json($logs);
    
    }

    public function createLogs(Request $request) {
        $validate = Validator::make($request -> all(), [
            "id" => "required", 
            "user_id" => "required", 
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
            "user_id" => $request -> user_id, 
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
