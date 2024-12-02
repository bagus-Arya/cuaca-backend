<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDevices;

class CreateUserDeviceController extends Controller
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
            "device_id" => "required",
            "user_id" => "required",
        ]);

        UserDevices::create($validate);

        return redirect()
            ->back()
            ->with('successMessage', 'Berhasil manambah data Device');
    }
}
