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
                        <h1 class="mb-3">Daftar Device </h1>

                        <form method="post" action="{{ route('nt-ex-dvc') }}">
                            @csrf
                            
                            <div class="form-group">
                                <label for="lat">Host ID</label>
                                <input type="text" name="host_id" class="form-control" id="host_id">
                            </div>
                            <div class="flex">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('nt-dvc') }}" class="btn btn-danger">Batal</a>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <table id="grouptable" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="30" class="text-center">No</th>
                                    <th>Host ID</th>
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
                    url: "{{ route('nt-dtdvc') }}",
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
