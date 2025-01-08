@extends('template')

@section('header')
    <title>Sistem Monitoring | Machine Log</title>
@endsection

@section('content')
<div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <table id="dtmtable" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">No</th>
                                    <th>Host</th>
                                    <th>Lat</th>
                                    <th>Lng</th>
                                    <th>Suhu</th>
                                    <th>Kelembaban</th>
                                    <th>Tekanan Udara</th>
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
            $('#dtmtable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('nt-dt-mlogs') }}",
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
                    {
                        data: 'temp',
                        name: 'temp'
                    },
                    {
                        data: 'humidity',
                        name: 'humidity'
                    },
                    {
                        data: 'pressure',
                        name: 'pressure'
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