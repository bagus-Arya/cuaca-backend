<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class EditUserController extends Controller
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
            "name" => "required",
            "email" => "required",
        ]);

        User::where('id', $user -> id) -> update($validate);
        return redirect()
            -> route('home')
            ->with('successMessage', 'Berhasil mengubah data');
    
    }
}
