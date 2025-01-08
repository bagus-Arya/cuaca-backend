<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTGroup;

class NTCreateGroupController extends Controller
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
            "group_nm" => "required",
            "addr" => "required",
        ]);

        NTGroup::create($validate);

        return redirect()
            ->route('nthome')
            ->with('successMessage', 'Berhasil manambah data group');
    }
}
