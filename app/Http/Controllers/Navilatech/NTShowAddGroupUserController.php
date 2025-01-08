<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTGroup;

class NTShowAddGroupUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, NTGroup $group)
    {
        return view('navilatech.add_group_staff',
            ["group_nm" => $group -> group_nm,"groupId" => $group -> id]
        );
    }
}
