<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTGroupUsers;
use App\Models\NTExDevices;

class NTGroupUserDeviceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, NTGroupUsers $group)
    {
        $devices = NTExDevices::select('id','host_id')->get();

        return view('navilatech.add_devices_staff', [
            "staff_nm" => $group->staff_nm,
            "userGID" => $group->id,
            "devices" => $devices,
        ]);
    }
}
