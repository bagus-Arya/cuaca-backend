<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSosLog;
use Illuminate\Support\Facades\Validator;

class SosMapsController extends Controller
{
    public function createSos(Request $request) {
        $validate = Validator::make($request -> all(), [
            "lat" => "required",  
            "lng" => "required", 
            "host_id" => "required"
        ]);

        if ($validate -> fails()) {
            return response([
                "status" => 'false', 
                "message" => $validate -> errors()
            ], 400);
        }

        $data = [
            "lat" => $request -> lat, 
            "lng" => $request -> lng,
            "host_id" => $request -> host_id
        ];

        UserSosLog::create($data);

        return response([
            'status' => 'true', 
            'message' => 'Data saved successfully'
        ], 200);
    }
}