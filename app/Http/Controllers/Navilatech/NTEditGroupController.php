<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTGroup;

class NTEditGroupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, NTGroup $group)
    {
        $validate = $request -> validate([
            "group_nm" => "required",
            "addr" => "required",
        ]);

        $group->update($validate);
        return redirect()
            -> route('nthome')
            ->with('successMessage', 'Berhasil mengubah data');
    }
}
