<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use App\Models\NTMachine;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NTdtHostLogsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $logs = NTMachine::select('host_id','lat', 'lng', 'temp', 'humidity', 'pressure') -> get();
        return DataTables::of($logs)
                ->addIndexColumn()
                ->make(true);
    }
}
