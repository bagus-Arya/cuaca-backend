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
                        <h1 class="mb-3">Data Device </h1>
                        <h6 class="mb-3">Nama Anggota : 
                            <span><b>{{$staff_nm}}</b></span> 
                        </h6>

                        <form method="post" action="{{ route('nt-devices') }}">
                            @csrf
                            <div class="form-group">
                                <label for="role">Device List</label>
                                <select name="host_id" id="host_id" class="form-control">
                                    <option value="">Select Device</option>
                                    @foreach($devices as $device)
                                        <option value="{{ $device->id }}">{{ $device->host_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="group_staff_fishermans_id" id="userGID" value={{$userGID}}>
                  
                            <div class="flex">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('nthome') }}" class="btn btn-danger">Batal</a>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <table id="hostTable" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">No</th>
                                    <th>Nama Device</th>
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
            var id = $('#userGID').val();
            $('#hostTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('nt-show-devices') }}?id=" + id,
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'n',
                        name: 'n'
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
