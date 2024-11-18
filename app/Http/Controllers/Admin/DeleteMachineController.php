<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeleteMachineController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Device $machine)
    {
        Device::where('id', $machine -> id) -> delete();

        return redirect()
            -> route('machine')
            -> with('Berhasil menghapus data');
    }
}
