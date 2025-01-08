<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use App\Models\NTGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NTShowGroupController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = NTGroup::select('id', 'group_nm', 'addr') -> get();
        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('action', function ($d) {
                return 
                '
                <a href="'.route('nt-show-group-user', ["group" => $d -> id]).'" id='. $d -> id.'style="cursor:pointer;" class="btn btn-xs btn-outline-success showStaffKomponen">Anggota <i class="fa fa-book"></i> </a>
                <a href="'.route('show-edit-group', ["group" => $d -> id]).'" id='. $d -> id.'style="cursor:pointer;" class="btn btn-xs btn-outline-warning editKomponen">Edit <i class="fa fa-pencil"></i> </a>
                <a href='.route('show-edit-group', ["group" => $d -> id]).' onclick="return confirm("Yakin ingin menghapus data?")" style="cursor:pointer;" id='.$d -> id.' class="btn btn-xs btn-outline-danger hapusKomponen">Hapus <i class="fa fa-trash"></i> </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
