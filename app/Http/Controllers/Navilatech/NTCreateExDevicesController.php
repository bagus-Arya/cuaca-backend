<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTExDevices;

class NTCreateExDevicesController extends Controller
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
        ]);

        NTExDevices::create($validate);

        return redirect()
            ->route('nt-dvc')
            ->with('successMessage', 'Berhasil manambah data group');
    }
}
