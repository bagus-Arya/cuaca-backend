<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSosLog;
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
}