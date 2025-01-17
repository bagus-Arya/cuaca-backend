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
    public function createDarurat(Request $request) {
        $validate = Validator::make($request -> all(), [
            "lat" => "required", 
            "lng" => "required",
            "group_staff_fishermans_id" => "required", 
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
            "group_staff_fishermans_id" => $request -> group_staff_fishermans_id,
            "group_staff_fishermans_id" => $request -> host_id
        ];

        UserSosLog::create($data);

        return response([
            'status' => 'true', 
            'message' => 'Data saved successfully'
        ], 200);
    }

    public function createMachine(Request $request) {
        $validate = Validator::make($request -> all(), [
            "host_id" => "required", 
            "lat" => "required", 
            "lng" => "required",
            "temp" => "required",
            "humidity" => "required", 
            "pressure" => "required"
        ]);

        if ($validate -> fails()) {
            return response([
                "status" => 'false', 
                "message" => $validate -> errors()
            ], 400);
        }

        $data = [
            "host_id" => $request -> host_id,
            "lat" => $request -> lat, 
            "lng" => $request -> lng,
            "temp" => $request -> temp, 
            "humidity" => $request -> humidity,
            "pressure" => $request -> pressure
        ];

        NTMachine::create($data);

        return response([
            'status' => 'true', 
            'message' => 'Data saved successfully'
        ], 200);
    }
}
