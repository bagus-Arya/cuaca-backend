@extends('template')

@section('header')
    <title>Sistem Monitoring | Machine</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-3">User  Data</h1>
                    <form method="post" action="#">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Username</label>
                            <input value="{{ $singleUser ->name }}" type="text" name="name" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="lng">Email</label>
                            <input value="{{ $singleUser ->email }}" type="email" name="email" class="form-control" id="email">
                        </div>
                        <div class="flex">
                            <button type="submit" class="btn btn-primary">Edit</button>
                            <a href="{{ route('home') }}" class="btn btn-danger">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="mb-3">User  Devices</h1>
                    <div class="row">

                        <!-- Child Card 1 -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    Device List
                                </div>
                                <div class="card-body">
                                    <ul id="deviceList" class="list-group">
                                        @foreach($selectedDevice as $selectedDevices)
                                            <li class="list-group-item">
                                                {{ $selectedDevices->device->place_name }}
                                                <button class="btn btn-sm btn-danger float-right" onclick="#">Remove</button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Child Card 2 -->
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    Available Devices
                                </div>
                                <div class="card-body">
                                    <div class="device-list">
                                        <ul id="availableDevices" class="list-group">
                                            @foreach($deviceMachine as $device)
                                                <li class="list-group-item">
                                                    {{ $device -> place_name }}
                                                    <button class="btn btn-sm btn-primary float-right" onclick="addDevice('{{ $device -> id }}')">Add</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')

<!-- Bootstrap JS (CDN) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function addDevice(deviceId) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        console.log("Device ID to add:", deviceId); // Debugging line

        // Create a new list item for the device
        const deviceList = document.getElementById('deviceList');
        if (!deviceList) {
            console.error("Device list element not found!");
            return; // Exit if the device list is not found
        }

        const userId = {{ $singleUser -> id }}; 

        const formData = new FormData();
        formData.append('user_id', userId);
        formData.append('device_id', deviceId);

        fetch('/user/store-user-device', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        .then(response => {
            console.log('Response:', response);
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => console.log(data))
        .catch(error => console.error('Error:', error));
    }
</script>

@endsection