@extends('template')

@section('header')
    <title>Sistem Monitoring | Dashboard</title>
@endsection

@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mb-3">Data Anggota </h1>
                        <h6 class="mb-3">Kelompok Nelayan : 
                            <span><b>{{$group_nm}}</b></span> 
                        </h6>

                        <form method="post" action="{{ route('nt-store-groups') }}">
                            @csrf
                            
                            <div class="form-group">
                                <label for="lat">Nama Anggota</label>
                                <input type="text" name="staff_nm" class="form-control" id="group_nm">
                            </div>
                            <div class="form-group">
                                <label for="lat">Email</label>
                                <input type="text" name="email" class="form-control" id="email">
                            </div>
                            <div class="form-group">
                                <label for="lng">Alamat</label>
                                <input type="text" name="addr" class="form-control" id="addr">
                            </div>
                            <div class="form-group">
                                <label for="lng">No HP</label>
                                <input type="text" name="no_hp" class="form-control" id="no_hp">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="">Select Role</option>
                                    <option value="ketua">Ketua</option>
                                    <option value="anggota">Anggota</option>
                                    <option value="pic">PIC</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="lng">Password</label>
                                <input type="text" name="password" class="form-control" id="password">
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="group_fishermans_id" id="group_fishermans_id" value={{$groupId}}>
                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('nthome') }}" class="btn btn-danger">Batal</a>
                            </div>
                        </form>
                    </div>
                    <input type="hidden" id="groupID" value={{$groupId}}>

                    <div class="card-footer">
                        <table id="grouptable" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">No</th>
                                    <th>Nama Anggota</th>
                                    <th>Email</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var id = $('#groupID').val();
            $('#grouptable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('nt-group-data') }}?id=" + id,
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'staff_nm',
                        name: 'staff_nm'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'addr',
                        name: 'addr'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                order: [
                    [1, 'asc']
                ],
                oLanguage: {
                    sProcessing: "Memuat Data.."
                },
                fnCreatedRow: function(row, data, index) {
                    $('td', row).eq(0).html(index + 1);
                },
            });
        });
    </script>
@endsection
