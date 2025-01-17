<?php

namespace App\Http\Controllers\DryFitech;

use App\Http\Controllers\Controller;
use App\Models\DFMachineLogs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GetDftMachineController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $logs = DFMachineLogs::orderBy('created_at', 'DESC') -> limit(500);
        return DataTables::of($logs)
            ->addIndexColumn()
            ->make(true);
    }
}
