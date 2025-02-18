<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserSosLog;
use App\Models\NTMachine;
use Illuminate\Support\Facades\Validator;

class NTMainController extends Controller
{
    public function verifyAccessToken(){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // If authentication fails, check the group_user table
        $groupUser  = \DB::table('group_staff_fishermans')->where('email', $validate['email'])->first();
        $tokengroup = $user->createToken('auth_token')->plainTextToken;

        if ($groupUser  && Hash::check($validate['password'], $groupUser ->password)) {
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $tokengroup,
                'user' => $groupUser
            ], 200);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function createMachine(Request $request) {

        $rawData = json_decode(file_get_contents("php://input"), true);

        if (!$rawData) {
            $rawData = $request->all();
        }
        $validate = Validator::make($rawData, [
            "host_id" => "required",
            "lat" => "required",
            "lng" => "required",
            "temp" => "required",
            "humidity" => "required",
            "pressure" => "required"
        ]);
        if ($validate->fails()) {
            return response([
                "status" => 'false',
                "message" => $validate->errors()
            ], 400);
        }

        $data = [
            "host_id" => $rawData['host_id'],
            "lat" => $rawData['lat'],
            "lng" => $rawData['lng'],
            "temp" => $rawData['temp'],
            "humidity" => $rawData['humidity'],
            "pressure" => $rawData['pressure']
        ];

        try {
            $machine = NTMachine::where('host_id', $request->host_id)->first();
    
            if ($machine) {
                $machine->update($data);
                return response([
                    'status' => 'true', 
                    'message' => 'Data updated successfully'
                ], 200);
            } else {
                $data['host_id'] = $request->host_id;
                NTMachine::create($data);
                return response([
                    'status' => 'true', 
                    'message' => 'Data saved successfully'
                ], 200);
            }
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'message' => 'Failed to save Data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getGroupData(Request $request)
    {
        $staffId = $request->user()->id;
        
        $staffData = NTGroupStaffFisherman::with(['group', 'devices'])
            ->where('id', $staffId)
            ->first();

        if (!$staffData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Staff data not found'
            ], 404);
        }

        $response = [
            'staff_id' => $staffData->id,
            'staff_name' => $staffData->name,
            'group' => [
                'id' => $staffData->group->id,
                'name' => $staffData->group->name
            ],
            'devices' => $staffData->devices->map(function($device) {
                return [
                    'device_id' => $device->id,
                    'host_id' => $device->host_id,
                    'status' => $device->status
                ];
            })
        ];

        return response()->json([
            'status' => 'success',
            'data' => $response
        ], 200);
    }

    public function getAllMachines() {
        $machines = NTMachine::all();

        if ($machines->isEmpty()) {
            return response([
                'status' => 'false',
                'message' => 'No data found'
            ], 404);
        }

        return response([
            'status' => 'true',
            'data' => $machines
        ], 200);
    }
}
