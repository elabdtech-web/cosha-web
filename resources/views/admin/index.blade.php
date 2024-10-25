@extends('admin.layouts.app')

@section('content')
    <!--main content wrapper-->
    <div class="vh-100">
        <div class="content p-3">
            {{-- Heading --}}
            <div class="row">
                <div class="col-md-12">
                    <p>Hello Admin</p>
                </div>
            </div>
            {{-- Statistics --}}
            <section class="statistics">
                <div class="row">
                    {{-- Total Drivers --}}
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="icon mb-3">
                                    <i class="fa fa-car fa-2x p-3 text-primary"></i>
                                </div>
                                <h5 class="mb-1">Total Drivers</h5>
                                <h2 class="text-white mb-0">{{ $data['total_drivers'] }}</h2>
                            </div>
                        </div>
                    </div>
                    {{-- Driver Requests --}}
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="icon mb-3">
                                    <i class="fa fa-question fa-2x p-3 text-warning"></i>
                                </div>
                                <h5 class="mb-1">Driver Requests</h5>
                                <h2 class="text-white mb-0">{{ $data['driver_requests'] }}</h2>
                            </div>
                        </div>
                    </div>
                    {{-- Completed Rides --}}
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="icon mb-3">
                                    <i class="fa fa-users fa-2x p-3 text-success"></i>
                                </div>
                                <h5 class="mb-1">Completed Rides</h5>
                                <h2 class="text-white mb-0">{{ $data['completed_rides'] }}</h2>
                            </div>
                        </div>
                    </div>
                    {{-- Ongoing Rides --}}
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <div class="icon mb-3">
                                    <i class="fa fa-users fa-2x p-3 text-primary"></i>
                                </div>
                                <h5 class="mb-1">Ongoing Rides</h5>
                                <h2 class="text-white mb-0">{{ $data['ongoing_rides'] }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {{-- Recent --}}
            <section class="recent">
                <div class="row">
                    {{-- <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Recent Activities</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="icon">
                                        <i class="fa fa-car text-primary"></i>
                                    </div>
                                    <p>New shared ride started started</p>
                                    <p class="ml-auto">Today, 2:27 AM</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="icon">
                                        <i class="fa fa-user text-primary"></i>
                                    </div>
                                    <p>New user just joined cosha now</p>
                                    <p class="ml-auto">Yesterday, 2:27 AM</p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Active Drivers</h5>
                            </div>
                            <div class="card-body">
                                <table class="table text-white">
                                    <thead>
                                        <tr>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($latestDrivers as $item)
                                            <tr>
                                                <th scope="row"><img
                                                        src="{{ isset($item->profile_image) ? Storage::url('images/drivers/' . $item->profile_image) : asset('images/default.png') }}"
                                                        alt="image" class="rounded-circle" width="50" height="50">
                                                </th>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td><a href="{{ route('admin.drivers.show', $item->id) }}"
                                                        class="btn btn-primary btn-sm">View</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{-- End Active Drivers --}}
                </div>
            </section>
            {{-- End Recent --}}
        </div>
    </div>

    <script type="module">
        Echo.channel("channel-name")
            .listen('TestEvent', (e) => {
                console.log(e)
            })
    </script>
@endsection
