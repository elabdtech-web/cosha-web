@extends('admin.layouts.app')

@section('content')
    <div class="container my-2">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Rides <span class="text-muted">/ details</span></h4>
            <div class="action-buttons">
                <button class="btn ">Delete <i class="fa fa-trash text-danger"></i></button>
            </div>
        </div>
        <!-- Main Section -->
        <div class="row">
            <div class="col-md-12">
                <div id="ongoing-section" class="table-section active-table">
                    <div class="card ongoing-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="map-img mb-3" id="map"></div>
                                </div>
                                <div class="col-md-4">
                                    {{-- location --}}
                                    <div class="row mb-4 location-details">
                                        <span class="mb-0">Location details</span>
                                        <div class="col-12">
                                            <p class="mb-0 text-sm"> <i class="fa fa-paper-plane mr-2"></i> 2972 Westheimer
                                                Rd. Santa
                                                Ana, Illinois 85486</p>
                                        </div>
                                        {{-- vertical dashed line --}}
                                        <div class="col-12">
                                            <div class="dashed-line">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <p class="mb-0"><i class="fa fa-circle text-danger"></i> 2972 Westheimer Rd.
                                                Santa Ana,
                                                Illinois
                                                85486</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Location and Ride Info -->
                            <div class="row">
                                <div class="col-md-4 border-right">
                                    <h6 class="mb-4">Ride Details</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <p>Ride Type:</p>
                                            <p>Status:</p>
                                            <p>Total Fare:</p>
                                            <p>Fare / head:</p>
                                            <p>Payment:</p>
                                        </div>
                                        <div class="col-6 text-end">
                                            <p>Daily ride</p>
                                            <p><span class="text-success">Ongoing</span></p>
                                            <p>$20.00</p>
                                            <p>$5.00</p>
                                            <p>Mastercard</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 border-right">
                                    <h6>Passengers</h6>
                                    <div class="d-flex align-items-center gap-4 mt-3">
                                        <img src="{{ asset('images/sample/profile.png') }}" alt="Driver"
                                            class="driver-profile-img rounded-circle">
                                        <p class="mb-0">Harry Potters</p>
                                        <button class="btn btn-primary-outline btn-sm">View Profile</button>
                                    </div>
                                    <div class="d-flex align-items-center gap-4 mt-3">
                                        <img src="{{ asset('images/sample/profile.png') }}" alt="Driver"
                                            class="driver-profile-img rounded-circle">
                                        <p class="mb-0">Harry Potters</p>
                                        <button class="btn btn-primary-outline btn-sm">View Profile</button>
                                    </div>
                                    <div class="d-flex align-items-center gap-4 mt-3">
                                        <img src="{{ asset('images/sample/profile.png') }}" alt="Driver"
                                            class="driver-profile-img rounded-circle">
                                        <p class="mb-0">Harry Potters</p>
                                        <button class="btn btn-primary-outline btn-sm">View Profile</button>
                                    </div>
                                    <div class="d-flex align-items-center gap-4 mt-3">
                                        <img src="{{ asset('images/sample/profile.png') }}" alt="Driver"
                                            class="driver-profile-img rounded-circle">
                                        <p class="mb-0">Harry Potters</p>
                                        <button class="btn btn-primary-outline btn-sm">View Profile</button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6>Driver</h6>
                                    <div class="d-flex align-items-center gap-4 mt-3">
                                        <img src="{{ asset('images/sample/profile.png') }}" alt="Driver"
                                            class="driver-profile-img rounded-circle">
                                        <p class="mb-0">Harry Potters</p>
                                        <button class="btn btn-primary-outline btn-sm">View Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
@endsection