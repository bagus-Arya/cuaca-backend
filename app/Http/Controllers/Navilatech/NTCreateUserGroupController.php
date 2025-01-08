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
        // dd($request);
        $validate = $request -> validate([
            "staff_nm" => "required",
            "email" => "required",
            "addr" => "required",
            "no_hp" => "required",
            "role" => "required",
            "password" => "required",
            "group_fishermans_id" => "required",
        ]);
        
        $validate["password"] = bcrypt($validate["password"]);
        NTGroupUsers::create($validate);

        return redirect()
            ->route('nthome')
            ->with('successMessage', 'Berhasil manambah data group');
    
    }

    private function generateRandomString($length = 32) {
        // Generate random bytes
        $bytes = random_bytes($length);
        
        // Convert to hexadecimal representation
        return bin2hex($bytes);
    }
}
