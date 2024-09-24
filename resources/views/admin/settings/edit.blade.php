@extends('admin.layouts.app')

@section('content')
    <div class="vh-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{-- Heading --}}
                    <h4 class="mb-0">Settings</h4>
                    <ul class="nav nav-pills mb-3 mt-4">
                        <li class="nav-item">
                            <button class="tab-btn active" onclick="showSection('ongoing')">Personal Settings</button>
                        </li>
                        <li class="nav-item">
                            <button class="tab-btn" onclick="showSection('completed')">General Settings</button>
                        </li>
                    </ul>
                    <!-- Ride Detail Sections -->
                    <div id="ongoing-section" class="table-section active-table">
                        <div class="container d-flex justify-content-center mt-5">
                            <div class="col-12 col-md-8 col-lg-6 card p-4 shadow-sm rounded form-section">
                                <!-- Profile Image Section -->
                                <form action="{{ route('admin.profile.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="text-center mb-4">
                                        <img id="image_img"
                                            src="{{ isset($user->admin->profile_image) ? Storage::url('images/profile/' . $user->admin->profile_image) : asset('images/default.png') }}"
                                            alt="image" class="rounded-circle shadow"
                                            style="width: 100px; height: 100px;"
                                            onclick="document.getElementById('image').click()">

                                        <input type="file" name="profile_image" id="image" class="d-none"
                                            accept="image/*">

                                    </div>
                                    <!-- Form Section -->
                                    <div class="row g-3">
                                        <!-- Email Field -->
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control text-light" id="email"
                                                name="email" value="{{ Auth::user()->email }}" placeholder="Enter email">
                                        </div>

                                        <!-- Password Field -->
                                        <div class="col-md-6">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control text-light" id="password"
                                                name="password" placeholder="Enter password">
                                        </div>
                                    </div>

                                    <!-- Save Button -->
                                    <div class="mt-4 text-center">
                                        <button type="submit" class="btn btn-primary px-4 py-2">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="completed-section" class="table-section">
                        Status
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSection(section) {
            // Hide all sections
            document.getElementById('ongoing-section').classList.remove('active-table');
            document.getElementById('completed-section').classList.remove('active-table');

            // Show the selected section
            document.getElementById(section + '-section').classList.add('active-table');

            // Remove active class from all buttons
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(button => button.classList.remove('active'));

            // Add active class to the clicked button
            event.target.classList.add('active');
        }

        document.querySelector('#image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file.');
                event.target.value = null;
                return;
            }

            const reader = new FileReader();
            reader.onload = (event) => {
                document.querySelector('#image_img').src = event.target.result;
            }

            reader.readAsDataURL(file);
        });
    </script>
@endSection
