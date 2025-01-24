<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NTGroupUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validate->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validate->errors()
            ], 400);
        }
    
        // Get validated data
        $validatedData = $validate->validated();
    
        // Try regular users first
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user
            ], 200);
        }
    
        // Try group staff users
        $groupUser  = \DB::table('group_staff_fishermans')
            ->where('email', $validatedData['email'])
            ->first();
    
        // Check if the group user exists
        if (!$groupUser ) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }
    
        // Find the NTGroupUsers by the groupUser 's id
        $user = NTGroupUsers::find($groupUser ->id);
    
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User  not found in NTGroupUsers'
            ], 404);
        }
    
        // Load the group name
        $group = $user->group; // This will use the relationship defined earlier
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $groupUser ->id,
                'name' => $groupUser ->staff_nm,
                'email' => $groupUser ->email,
                'role' => 'staff',
                'group_id' => $groupUser ->group_fishermans_id,
                'group_name' => $group ? $group->group_nm : null // Return group name
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out',
            'input' => ['data'=> $groupUser]
        ], 200);
    }
}