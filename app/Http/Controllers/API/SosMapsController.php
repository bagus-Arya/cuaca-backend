<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSosLog;
use App\Models\NTDetailSosLogs;
use Illuminate\Support\Facades\Validator;

class SosMapsController extends Controller
{
    public function createSos(Request $request) {
        // Get raw POST data and decode it
        $rawData = json_decode(file_get_contents("php://input"), true);
        
        if (!$rawData) {
            $rawData = $request->all();
        }
    
        $validate = Validator::make($rawData, [
            "lat" => "required|numeric",
            "lng" => "required|numeric",
            "host_id" => "required"
        ]);
    
        if ($validate->fails()) {
            return response([
                "success" => false,
                "message" => "Validation failed",
                "errors" => $validate->errors()
            ], 400);
        }
    
        $data = [
            "lat" => $rawData['lat'],
            "lng" => $rawData['lng'],
            "host_id" => $rawData['host_id']
        ];
    
        try {
            UserSosLog::create($data);
            
            return response([
                'success' => true,
                'message' => 'SOS location saved successfully'
            ], 200);
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'message' => 'Failed to save SOS location',
                'error' => $e->getMessage()
            ], 500);
        }
    }    
    public function createUserSos(Request $request, $userId) 
    {
        $validate = Validator::make($request->all(), [
            "lat" => "required|numeric", 
            "lng" => "required|numeric", 
            "group_staff_fishermans_id" => "required"
        ]);
    
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors()
            ], 400);
        }
    
        $data = [
            "lat" => $request->lat, 
            "lng" => $request->lng,
            "group_staff_fishermans_id" => $userId,
        ];
    
        NTDetailSosLogs::create($data);
    
        return response()->json([
            'status' => true, 
            'message' => 'Data saved successfully'
        ], 200);
    }  
    public function getAllSosLogs(Request $request) {
        $data = NTDetailSosLogs::with('groupUser')
        ->orderBy('created_at', 'desc') 
        ->get();

        $transformedData = $data->map(function ($log) {
            return [
                'lat' => $log->lat,
                'lng' => $log->lng,
                'group_staff_fishermans_id' => $log->group_staff_fishermans_id,
                'staff_nm' => $log->groupUser  ? $log->groupUser ->staff_nm : null,
            ];
        });
        
        return response([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $transformedData
        ], 200);
    }
    public function getAllSosMachine(Request $request) {
        $data = UserSosLog::with('device')
        ->orderBy('created_at', 'desc') 
        ->get();
    
        $transformedData = $data->map(function ($log) {
            return [
                'lat' => $log->lat,
                'lng' => $log->lng,
                'host_id' => $log->device ? $log->device->id : null,
                'machine_name' => $log->device ? $log->device->host_id : null,
            ];
        });
        
        return response([
            'success' => true,
            'message' => 'Data retrieved successfully',
            'data' => $transformedData
        ], 200);

    }  
}