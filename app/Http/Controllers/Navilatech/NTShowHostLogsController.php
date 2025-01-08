<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NTShowHostLogsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return view('navilatech.machine_logs');
    }
}
