<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserDevices;

class RemoveUserDeviceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        
        $request->validate([
            'id' => 'required',
        ]);
        $userDevice = UserDevices::where('id', $request->id)->first();
        $userDevice->delete();
        return redirect()
            ->route('home')
            ->with('successMessage', 'Berhasil menghapus data');
    }
}
