<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use App\Models\NTDetailSosLogs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NTSosDeviceLogsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $logs = NTDetailSosLogs::select('group_staff_fishermans_id','lat', 'lng')
        ->orderBy('created_at', 'asc') 
        ->get();
        
        return DataTables::of($logs)
            ->addIndexColumn() 
            ->make(true);
    }
}
