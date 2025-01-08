<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginAuthController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validate = $request -> validate([
            "email" => "required",
            "password" => "required",
        ]);

        if(Auth::attempt($validate)) {
            $request -> session() -> regenerate();
            return redirect() -> route('home');
        }

        // If authentication fails, check the group_user table
        $groupUser  = \DB::table('group_staff_fishermans')->where('email', $validate['email'])->first();

        if ($groupUser  && Hash::check($validate['password'], $groupUser ->password)) {
            // If the password matches, log the user in
            Auth::loginUsingId($groupUser ->id);
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        return redirect()
            -> route('show-login')
            -> with('errorMessage', 'Email dan password tidak sesuai');
    }
    
}
