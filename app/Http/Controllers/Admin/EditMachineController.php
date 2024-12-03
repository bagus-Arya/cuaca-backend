<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class EditMachineController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Device $machine)
    {
        $validate = $request -> validate([
            "lat" => "required",
            "lng" => "required",
            "place_name" => "required",
        ]);

        Device::where('id', $machine -> id) -> update($validate);
        return redirect()
            -> route('machine')
            ->with('successMessage', 'Berhasil mengubah data');
    }
}
