<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTDevice;

class NTGUserDevicesController extends Controller
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
            "host_id" => "required",
            "group_staff_fishermans_id" => "required",
        ]);

        NTDevice::create($validate);

        return redirect()
            ->route('nthome')
            ->with('successMessage', 'Berhasil manambah data group');
    }
}
