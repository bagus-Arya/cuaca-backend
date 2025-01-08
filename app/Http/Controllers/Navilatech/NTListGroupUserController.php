<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use App\Models\NTGroupUsers;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NTListGroupUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $id = $request->get('id');

        $user = NTGroupUsers::select('id', 'staff_nm', 'email', 'addr', 'no_hp', 'role') 
        ->with(['groupUsers'])
        ->where('group_fishermans_id', $id)
        ->orderBy('created_at', 'DESC') -> get();
        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('action', function ($d) {
                return 
                '
                <a href="'.route('show-edit-user', ["user" => $d -> id]).'" id='. $d -> id.'style="cursor:pointer;" class="btn btn-xs btn-outline-success viewKomponen">Device Saya <i class="fa fa-book"></i> </a>
                <a href="'.route('show-edit-user', ["user" => $d -> id]).'" id='. $d -> id.'style="cursor:pointer;" class="btn btn-xs btn-outline-warning editKomponen">Edit <i class="fa fa-pencil"></i> </a>
                <a href='.route('delete-user-data', ["user" => $d -> id]).' onclick="return confirm("Yakin ingin menghapus data?")" style="cursor:pointer;" id='.$d -> id.' class="btn btn-xs btn-outline-danger hapusKomponen">Hapus <i class="fa fa-trash"></i> </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
