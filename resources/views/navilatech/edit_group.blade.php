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
                        <h1 class="mb-3">Edit Group Data</h1>
                        <form method="post" action="{{ route('edit-group', $group->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="lat">Nama Kelompok</label>
                                <input type="text" name="group_nm" class="form-control" id="group_nm" value="{{$group->group_nm}}">
                              </div>
                            <div class="form-group">
                                <label for="lng">Alamat</label>
                                <input type="text" name="addr" class="form-control" id="addr" value="{{$group->addr}}">
                              </div>
                            <div class="flex">
                              <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('nthome') }}" class="btn btn-danger">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
