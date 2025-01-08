<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ShowUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = User::select('id', 'name', 'email', 'role') -> get();
        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('action', function ($d) {
                return 
                '<a href="'.route('show-edit-user', ["user" => $d -> id]).'" id='. $d -> id.'style="cursor:pointer;" class="btn btn-xs btn-outline-warning editKomponen"><i class="fa fa-pencil"></i> </a>
                <a href='.route('delete-user-data', ["user" => $d -> id]).' onclick="return confirm("Yakin ingin menghapus data?")" style="cursor:pointer;" id='.$d -> id.' class="btn btn-xs btn-outline-danger hapusKomponen"><i class="fa fa-trash"></i> </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
