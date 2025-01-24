<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTGroupUsers;

class NTCreateUserGroupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Validate the incoming request
        $validate = $request->validate([
            "staff_nm" => "required|string|max:255",
            "email" => "required|email|unique:group_staff_fishermans,email",
            "addr" => "required|string|max:255",
            "no_hp" => "required|string|max:15", 
            "role" => "required|string|max:50", 
            "password" => "required", 
            "group_fishermans_id" => "required|integer", 
        ]);
        
        $validate["password"] = bcrypt($validate["password"]);
        
        NTGroupUsers::create($validate);
    
        return redirect()
            ->route('nthome')
            ->with('successMessage', 'Berhasil menambah data group');
    }

    private function generateRandomString($length = 32) {
        // Generate random bytes
        $bytes = random_bytes($length);
        
        // Convert to hexadecimal representation
        return bin2hex($bytes);
    }
}
