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
            $predictions[] = [
                'date' => $date,
                'predicted_suhu' => $averageSuhu,
                'predicted_kecepatan_angin' => $averageKecepatanAngin,
                'predicted_tekanan_udara' => $averageTekananUdara,
                'predicted_kelembaban' => $averageKelembaban,
            ];
        }
    
        return response()->json(['data' => $predictions]);
    }

    public function evaluateWeatherConditions()
    {
        $data = DeviceLogs::orderBy('created_at', 'DESC')->get();

        $weatherConditions = [];
        $dailyData = [];

        foreach ($data as $log) {
    
            $date = \Carbon\Carbon::parse($log->created_at)->toDateString();

            if (!isset($dailyData[$date])) {
                $dailyData[$date] = [
                    'total_suhu' => 0,
                    'total_kelembaban' => 0,
                    'total_kecepatan_angin' => 0,
                    'count' => 0,
                ];
            }

            $dailyData[$date]['total_suhu'] += $log->suhu;
            $dailyData[$date]['total_kelembaban'] += $log->kelembaban;
            $dailyData[$date]['total_kecepatan_angin'] += $log->kecepatan_angin;
            $dailyData[$date]['count']++;

            if ($log->suhu < 23 && $log->kelembaban > 1013 && $log->kecepatan_angin > 10) {
                $condition = 'Kondisi Cuaca Buruk'; 
            } elseif ($log->suhu > 26 && $log->kelembaban < 93 && $log->kecepatan_angin < 10) {
                $condition = 'Kondisi Cuaca Baik'; 
            } else {
                $condition = 'Kondisi Tidak Diketahui'; 
            }

            $weatherConditions[] = [
                'id' => $log->id,
                'machine_id' => $log->machine_id,
                'suhu' => $log->suhu,
                'kelembaban' => $log->kelembaban,
                'kecepatan_angin' => $log->kecepatan_angin,
                'condition' => $condition,
                'created_at' => $log->created_at,
            ];
    }

    $dailyAverages = [];
    foreach ($dailyData as $date => $values) {
        $dailyAverages[$date] = [
            'average_suhu' => $values['total_suhu'] / $values['count'],
            'average_kelembaban' => $values['total_kelembaban'] / $values['count'],
            'average_kecepatan_angin' => $values['total_kecepatan_angin'] / $values['count'],
        ];
    }

    return response()->json([
        'weather_conditions' => $weatherConditions,
        'daily_averages' => $dailyAverages,
    ]);
}

    public function showRainyConditions()
    {

        $data = DeviceLogs::orderBy('created_at', 'DESC')->get();
    

        $rainyConditions = $data->filter(function ($log) {
            return $log->kelembaban > 80; 
        });
    
        return response()->json(['rainy_conditions' => $rainyConditions]);
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
