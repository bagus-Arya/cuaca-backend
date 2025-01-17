<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DFMachineLogs;
use Illuminate\Support\Facades\Validator;

class DFMachineLogsController extends Controller
{
    public function postLogs(Request $request) {
        $validate = Validator::make($request -> all(), [
            "machine_ID" => "required", 
            "temp" => "required", 
            "humid" => "required",
            "weight" => "required",
            "light" => "required"
        ]);

        if ($validate -> fails()) {
            return response([
                "status" => 'false', 
                "message" => $validate -> errors()
            ], 400);
        }

        $data = [
            "machine_ID" => $request -> machine_ID,
            "temp" => $request -> temp, 
            "humid" => $request -> humid,
            "weight" => $request -> weight, 
            "light" => $request -> light
        ];

        DFMachineLogs::create($data);

        return response([
            'status' => 'true', 
            'message' => 'Data saved successfully'
        ], 200);
    }

    public function getSingleMachineLogs(Request $request) {
        $data = DFMachineLogs::orderBy('created_at', 'DESC') -> get();
        return response([
            'status' => 'true',
            'message' => 'Data retrieved successfully',
            'data' => $data
        ], 200);
    }
}
