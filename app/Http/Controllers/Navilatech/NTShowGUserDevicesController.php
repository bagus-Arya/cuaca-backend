<?php

namespace App\Http\Controllers\Navilatech;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NTDevice;
use Yajra\DataTables\DataTables;

class NTShowGUserDevicesController extends Controller
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

        $user = NTDevice::select('id', 'host_id') 
        ->with(['machineLog'])
        ->where('group_staff_fishermans_id', $id)
        ->orderBy('created_at', 'DESC') -> get();
        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('machine_log', function ($d) {
                return $d->machineLog ? $d->machineLog->host_id : '-';
            })
            ->addColumn('action', function ($d) {
                return 
                '<a href='.route('delete-user-data', ["user" => $d -> id]).' onclick="return confirm("Yakin ingin menghapus data?")" style="cursor:pointer;" id='.$d -> id.' class="btn btn-xs btn-outline-danger hapusKomponen">Hapus <i class="fa fa-trash"></i> </a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}