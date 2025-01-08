<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTExDevices;
use Yajra\DataTables\DataTables;

class NTShowExDevicesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = NTExDevices::select('id', 'host_id') -> get();
        return DataTables::of($user)
            ->addIndexColumn()
            ->make(true);
    }
}
