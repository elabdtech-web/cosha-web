@extends('admin.layouts.app')

@section('content')
    <div class="">
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
                    <div id="ongoing-section" class="table-section active-table vh-100">
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
                        {{-- Privacy and Policy Form --}}
                        <form action="{{ route('admin.privacy.update') }}" class="" method="POST">
                            @csrf
                            <div class="row g-3">
                                <!-- Privacy and Policy Field -->
                                <div class="col-md-12">
                                    <label for="privacy_policy" class="form-label">Privacy and Policy</label>
                                    <textarea id="summernote1" name="privacy_policy">{{ $privacyPolicy->content ?? '' }}</textarea>
                                </div>
                            </div>
                            <!-- Save Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2">Save Changes</button>
                            </div>
                        </form>

                        {{-- Terms and Conditions Form --}}
                        <form action="{{ route('admin.terms.update') }}" method="POST" class="mt-5">
                            @csrf
                            <div class="row g-3">
                                <!-- Terms and Conditions Field -->
                                <div class="col-md-12">
                                    <label for="terms_conditions" class="form-label">Terms and Conditions</label>
                                    <textarea id="summernote2" name="terms_conditions">{!! $termsCondition->content ?? '' !!}</textarea>
                                </div>
                            </div>
                            <!-- Save Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2">Save Changes</button>
                            </div>
                        </form>

                        {{-- Help and Support Form  --}}
                        <form action="{{ route('admin.help.update') }}" method="POST" class="mt-5">
                            @csrf
                            <div class="row g-3">
                                <!-- Help and Support Field -->
                                <div class="col-md-12">
                                    <label for="help_support" class="form-label">Help and Support</label>
                                    <textarea id="summernote3" name="help_support">{!! $helpSupport->content ?? '' !!}</textarea>
                                </div>
                            </div>
                            <!-- Save Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2">Save Changes</button>
                            </div>
                        </form>

                        {{-- About Us Form --}}
                        <form action="{{ route('admin.about.update') }}" method="POST" class="mt-5">
                            @csrf
                            <div class="row g-3">
                                <!-- About Us Field -->
                                <div class="col-md-12">
                                    <label for="about_us" class="form-label">About Us</label>
                                    <textarea id="summernote4" name="about_us">{!! $aboutUs->content ?? '' !!}</textarea>
                                </div>
                            </div>
                            <!-- Save Button -->
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary px-4 py-2 mb-2">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $('#summernote1').summernote({
            placeholder: 'Enter Privacy and Policy content...',
            tabsize: 2,
            height: 100,
        });

        $('#summernote2').summernote({
            placeholder: 'Enter Terms and Conditions content...',
            tabsize: 2,
            height: 100,
        });

        $('#summernote3').summernote({
            placeholder: 'Enter Help and Support content...',
            tabsize: 2,
            height: 100,
        });

        $('#summernote4').summernote({
            placeholder: 'Enter About Us content...',
            tabsize: 2,
            height: 100,
        });

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
