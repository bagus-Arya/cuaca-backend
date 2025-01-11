@extends('template')

@section('header')
    <title>Sistem Monitoring | Machine Log</title>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h6><b>Machine SOS</b></h6>
                </div>
                <div class="card-body">
                    <table id="sosMtable" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="30" class="text-center">No</th>
                                <th>ID</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6><b>Device SOS</b></h6>
                </div>
                <div class="card-body">
                    <table id="sosDtable" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="30" class="text-center">No</th>
                                <th>ID</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
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
            $('#sosMtable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('machine-darurat-logs') }}",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'host_id',
                        name: 'host_id'
                    },
                    {
                        data: 'lat',
                        name: 'lat'
                    },
                    {
                        data: 'lng',
                        name: 'lng'
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
        $(document).ready(function() {
            $('#sosDtable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('device-darurat-logs') }}",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'group_staff_fishermans_id',
                        name: 'group_staff_fishermans_id'
                    },
                    {
                        data: 'lat',
                        name: 'lat'
                    },
                    {
                        data: 'lng',
                        name: 'lng'
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