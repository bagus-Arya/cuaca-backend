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

    public function predictOneWeek(){
        $data = DeviceLogs::orderBy('created_at', 'DESC') -> paginate(10);
        return $data;
    }

    public function rainHistory(){
        // 
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
