<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Machine;
use Illuminate\Http\Request;

class CreateMachineController extends Controller
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
            "lat" => "required",
            "lng" => "required",
        ]);

        $validate["suhu"] = 0;
        $validate["kecepatan_angin"] = 0;
        $validate["tekanan_udara"] = 0;
        $validate["kelembaban"] = 0;
        $validate["kondisi_baik"] = true;
        $validate["active"] = 0;

        Device::create($validate);

        return redirect()
            ->route('machine')
            ->with('successMessage', 'Berhasil menambah data');

    }
}
