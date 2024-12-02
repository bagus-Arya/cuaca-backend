<?php

namespace App\Http\Controllers;
use App\Models\Device;
use App\Models\User;
use App\Models\UserDevices;
use Illuminate\Http\Request;

class ShowEditUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, User $user)
    {
        $userId = $user -> id;
        // Get all devices
        $allDevices = Device::all();
    
        $selectedDevices = UserDevices::with('device')->where('user_id', $user->id)->get();

        // Get selected devices for the user
        $selectedDevicesId = $selectedDevices->pluck('device_id')->toArray();
        $availableDevices = $allDevices->whereNotIn('id', $selectedDevicesId);
    
        return view('edit_user', [
            'singleUser' => $user, 
            'deviceMachine' => $availableDevices, 
            'selectedDevice' => $selectedDevices,
        ]);
    }
}
