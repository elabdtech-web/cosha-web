@extends('admin.layouts.app')

@section('content')
    <div class="container my-2">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Passengers <span class="text-muted">/ details</span></h4>
            <div class="action-buttons">
                <button class="btn me-2">Edit <i class="fa fa-edit text-success"></i></button>
                <button class="btn ">Delete <i class="fa fa-trash text-danger"></i></button>
            </div>
        </div>
        <!-- Main Section -->
        <div class="row">
            <!-- User Info Section -->
            <div class="col-md-4">
                <div class="card shared-card p-4 mb-2">
                    <img src="{{ asset('images/sample/profile.png') }}" alt="User Photo" class="profile-img d-block">
                    <div class="profile-section mt-2 p-3">
                        <span class="text-muted">Name *</span>
                        <p class="mb-3">Youjiro Hanma</p>
                        <span class="text-muted">Gender*</span>
                        <p class="mb-3">Male</p>
                        <span class="text-muted">Phone no *</span>
                        <p class="mb-3">0435 45690440</p>
                        <span class="text-muted">Address *</span>
                        <p class="">Boston meat club street 29/1, closed end</p>
                    </div>
                </div>
            </div>
            <!-- Ride Details Section -->
            <div class="col-md-8">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <span> <strong>Ride Details</strong></span>
                    </div>
                </div>
                <!-- Ride Details Tabs -->
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item">
                        <button class="tab-btn active" onclick="showSection('ongoing')">Ongoing</button>
                    </li>
                    <li class="nav-item">
                        <button class="tab-btn" onclick="showSection('completed')">Completed</button>
                    </li>
                    <li class="nav-item">
                        <button class="tab-btn" onclick="showSection('canceled')">Canceled</button>
                    </li>
                </ul>
                <!-- Ride Detail Sections -->
                <div id="ongoing-section" class="table-section active-table">
                    @include('admin.passengers.partials.shared-rides')
                </div>

                <div id="completed-section" class="table-section">
                    @include('admin.passengers.partials.completed')
                </div>
                <div id="canceled-section" class="table-section">
                    @include('admin.passengers.partials.canceled')
                </div>
            </div>
        </div>
    </div>
    <script>
        function showSection(section) {
            // Hide all sections
            document.getElementById('ongoing-section').classList.remove('active-table');
            document.getElementById('completed-section').classList.remove('active-table');
            document.getElementById('canceled-section').classList.remove('active-table');

            // Show the selected section
            document.getElementById(section + '-section').classList.add('active-table');

            // Remove active class from all buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(button => button.classList.remove('active'));

            // Add active class to the clicked button
            event.target.classList.add('active');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
@endsection
