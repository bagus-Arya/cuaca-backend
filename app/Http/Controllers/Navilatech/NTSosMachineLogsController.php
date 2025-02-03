<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use App\Models\UserSosLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NTSosMachineLogsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $logs = UserSosLog::select('host_id', 'lat', 'lng', 'created_at')
        ->orderBy('created_at', 'asc') 
        ->get();
    
    return DataTables::of($logs)
        ->addIndexColumn() 
        ->make(true);
    }
}
