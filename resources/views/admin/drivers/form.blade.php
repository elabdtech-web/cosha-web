<div class="container mt-5">
    <!-- Personal Details Section -->
    <div class="form-section">
        <h5 class="mb-4">Personal details</h5>
        <div class="row">
            {{-- if any error show here --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <div class="col-md-3">
                <div class="">
                    <img id="image_img"
                        src="{{ isset($driver) && $driver->profile_image ? Storage::url('images/drivers/' . $driver->profile_image) : asset('images/default.png') }}"
                        alt="image" class="upload-image-box" onclick="document.getElementById('image').click()">
                    <input type="file" name="profile_image" id="image" class="d-none" accept="image/*">
                    {{-- show error --}}
                    @error('profile_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control text-light"
                            value="{{ old('name', isset($driver) ? $driver->name : '') }}" name="name" id="name"
                            required placeholder="Enter name">
                        {{-- show error --}}
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    @if (!isset($driver))
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Email</label>
                            <input type="email" class="form-control text-light" value="{{ old('email') }}"
                                name="email" id="email" required placeholder="Enter email">
                            {{-- show error --}}
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    @if (!isset($driver))
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control text-light" value="{{ old('password') }}"
                                name="password" id="password" placeholder="Enter password">
                            {{-- show error --}}
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" class="form-select text-light" id="gender" required>
                            <option selected>Select gender</option>
                            <option value="male"
                                {{ old('gender') == 'male' || (isset($driver) && $driver->gender == 'male') ? 'selected' : '' }}>
                                Male</option>
                            <option value="female"
                                {{ old('gender') == 'female' || (isset($driver) && $driver->gender == 'female') ? 'selected' : '' }}>
                                Female</option>
                        </select>
                        {{-- show error --}}
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone number</label>
                        <input type="text" name="phone" class="form-control text-light" id="phone"
                            placeholder="Enter phone no."
                            value="{{ old('phone', isset($driver) ? $driver->phone : '') }}" required>
                        {{-- show error --}}
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" name="age" class="form-control text-light" id="age"
                            placeholder="Enter age" value="{{ old('age', isset($driver) ? $driver->age : '') }}"
                            required>
                        {{-- show error --}}
                        @error('age')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="passenger" class="form-label">Preferred passenger</label>
                        <select name="preffered_passenger" class="form-select  text-light" id="passenger" required>
                            <option selected>Select preferred passenger</option>
                            <option value="1"
                                {{ old('preffered_passenger') == '1' || (isset($driver) && $driver->preffered_passenger == '1') ? 'selected' : '' }}>
                                Passenger 1</option>
                            <option value="2"
                                {{ old('preffered_passenger') == '2' || (isset($driver) && $driver->preffered_passenger == '2') ? 'selected' : '' }}>
                                Passenger 2</option>
                        </select>
                        {{-- show error --}}
                        @error('preffered_passenger')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vehicle Details Section -->
    <div class="form-section">
        <h5>Vehicle details</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="">
                    <img id="vehicle_image_img_preview"
                        src="{{ isset($driver) && $driver->vehicles->vehicle_image ? Storage::url('images/drivers/' . $driver->vehicles->vehicle_image) : asset('images/default.png') }}"
                        alt="image" class="upload-image-box"
                        onclick="document.getElementById('vehicle_image').click()">
                    <input type="file" name="vehicle_image" id="vehicle_image" class="d-none" accept="image/*">
                    {{-- show error --}}
                    @error('vehicle_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="vehicleName" class="form-label">Vehicle</label>
                        <input type="text" class="form-control text-light" id="vehicleName" name="vehicle_name"
                            placeholder="Enter vehicle name"
                            value="{{ old('vehicle_name', isset($driver) ? $driver->vehicles->vehicle_name : '') }}"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="vehicleType" class="form-label">Vehicle type</label>
                        <select class="form-select text-light" name="type" id="vehicleType" required>
                            <option selected>Select type</option>
                            <option value="1"
                                {{ old('type') == '1' || (isset($driver) && $driver->vehicles->type == '1') ? 'selected' : '' }}>
                                Sedan</option>
                            <option value="2"
                                {{ old('type') == '2' || (isset($driver) && $driver->vehicles->type == '2') ? 'selected' : '' }}>
                                SUV</option>
                        </select>
                        {{-- show error --}}
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="make" class="form-label">Make</label>
                        <select name="make" class="form-select text-light" id="make" required>
                            <option selected>Select vehicle make</option>
                            <option value="toyota"
                                {{ old('make') == 'toyota' || (isset($driver) && $driver->vehicles->make == 'toyota') ? 'selected' : '' }}>
                                Toyota</option>
                            <option value="honda"
                                {{ old('make') == 'honda' || (isset($driver) && $driver->vehicles->make == 'honda') ? 'selected' : '' }}>
                                Honda</option>
                        </select>
                        {{-- show error --}}
                        @error('make')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" name="model" class="form-control text-light" id="model"
                            placeholder="Enter model"
                            value="{{ old('model', isset($driver) ? $driver->vehicles->model : '') }}" required>
                        {{-- show error --}}
                        @error('model')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="regNumber" class="form-label">Reg number</label>
                        <input type="text" class="form-control text-light" name="registration_no" id="regNumber"
                            placeholder="Enter Reg no."
                            value="{{ old('registration_no', isset($driver) ? $driver->vehicles->registration_no : '') }}"
                            required>
                        {{-- show error --}}
                        @error('registration_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="docUpload" class="form-label">Upload Doc here</label>
                        <input type="file" name="vehicle_document" class="form-control text-light" id="docUpload"
                            accept=".pdf">
                        <small class="text-muted">PDF file, less than 5MB</small>

                        {{-- Show the existing PDF if available --}}
                        @if (!empty($driver->vehicles->vehicle_document))
                            <div class="mt-2">
                                <a href="{{ asset('storage/images/drivers/' . $driver->vehicles->vehicle_document) }}"
                                    target="_blank">
                                    View existing document
                                </a>
                            </div>
                        @endif

                        {{-- Show error --}}
                        @error('vehicle_document')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Documents Section -->
    <div class="form-section">
        <h5>Documents</h5>
        <div class="row">
            {{-- driving license --}}
            <span class="mb-3">Driving license</span>
            <div class="col-md-6 mb-3">
                <div class="">
                    <span>Upload image Back Image</span>
                    <div class="mt-2">
                        <img id="document_image_front_preview"
                            src="{{ isset($driver->identity_document->front_image) ? Storage::url('images/drivers/' . $driver->identity_document->front_image) : asset('images/default.png') }}"
                            alt="image" class="upload-image-box"
                            onclick="document.getElementById('document_image_front').click()">
                        <input type="file" name="front_image" id="document_image_front" class="d-none"
                            accept="image/*">
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="">
                    <span>Upload image Front Image</span>
                    <div class="mt-2">
                        <img id="document_image_back_preview"
                            src="{{ isset($driver->identity_document->back_image) ? Storage::url('images/drivers/' . $driver->identity_document->back_image) : asset('images/default.png') }}"
                            alt="image" class="upload-image-box"
                            onclick="document.getElementById('document_image_back').click()">
                        <input type="file" name="back_image" id="document_image_back" class="d-none"
                            accept="image/*">
                        {{-- show error --}}
                        @error('back_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">License number</label>
                <input type="text" class="form-control text-light" name="license_no"
                    value="{{ old('license_no', isset($driver) ? $driver->license->license_no : '') }}"
                    placeholder="Enter license number" required>
                {{-- show error --}}
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control text-light" name="driver_name"
                    value="{{ old('driver_name', isset($driver) ? $driver->name : '') }}"
                    placeholder="Enter driver name" required>
                {{-- show error --}}
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Father name</label>
                <input type="text" class="form-control text-light" id="phone"
                    value="{{ old('father_name', isset($driver) ? $driver->identity_document->father_name : '') }}"
                    name="father_name" placeholder="Enter father name" required>
                {{-- show error --}}
                @error('father_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="age" class="form-label">CNIC number</label>
                <input type="text" class="form-control text-light" id="age" name="cnic_number"
                    value="{{ old('cnic_number', isset($driver) ? $driver->identity_document->cnic_number : '') }}"
                    placeholder="Enter cnic number" required>
                {{-- show error --}}
                @error('cnic')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Issue date</label>
                <input type="date" class="form-control text-light" name="issued_date" id="phone"
                    value="{{ old('issued_date', isset($driver) ? $driver->license->issued_date : '') }}" required>
                {{-- show error --}}
                @error('issued_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Expiry date</label>
                <input type="date" class="form-control text-light" name="expiry_date" id="phone"
                    value="{{ old('expiry_date', isset($driver) ? $driver->license->expiry_date : '') }}" required>
                {{-- show error --}}
                @error('expiry_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <span class="mb-2">CNIC copy</span>
            <div class="col-md-6 mb-3">
                <div class="">
                    <span>Upload image</span>
                    <div class="mt-2">
                        <img id="cnic_copy_image_front_preview"
                            src="{{ isset($driver->identity_document->cnic_copy_front) ? Storage::url('images/drivers/' . $driver->identity_document->cnic_copy_front) : asset('images/default.png') }}"
                            alt="image" class="upload-image-box"
                            onclick="document.getElementById('cnic_copy_image_front').click()">
                        <input type="file" name="cnic_copy_front" id="cnic_copy_image_front" class="d-none"
                            accept="image/*">
                        {{-- show error --}}
                        @error('cnic_copy_front')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="">
                    <span>Upload image</span>
                    <div class="mt-2">
                        <img id="cnic_copy_back_preview"
                            src="{{ isset($driver->identity_document->cnic_copy_back) ? Storage::url('images/drivers/' . $driver->identity_document->cnic_copy_back) : asset('images/default.png') }}"
                            alt="image" class="upload-image-box"
                            onclick="document.getElementById('cnic_copy_back').click()">
                        <input type="file" name="cnic_copy_back" id="cnic_copy_back" class="d-none"
                            accept="image/*">
                        {{-- show error --}}
                        @error('cnic_copy_back')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="age" class="form-label">Given name</label>
                <input type="text" class="form-control text-light" name="given_name"
                    value="{{ old('given_name', isset($driver) ? $driver->identity_document->given_name : '') }}"
                    placeholder="Enter Given name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Surname</label>
                <input type="text" class="form-control text-light"
                    value="{{ old('surname', isset($driver) ? $driver->identity_document->surname : '') }}"
                    name="surname" id="phone" placeholder="Enter surname" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="age" class="form-label">Document number</label>
                <input type="text" class="form-control text-light"
                    value="{{ old('document_number', isset($driver) ? $driver->identity_document->document_number : '') }}"
                    name="document_number" placeholder="Enter document number" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Expiry date</label>
                <input type="date" name="expiry_date" class="form-control text-light"
                    value="{{ old('expiry_date', isset($driver) ? $driver->identity_document->expiry_date : '') }}""
                    id="phone">
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="float-end">
        <button type="submit" class="btn btn-primary">
            {{ isset($driver) ? 'Update' : 'Add' }}
        </button>
    </div>
</div>

<script>
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

    // vheicle image
    document.querySelector('#vehicle_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            event.target.value = null;
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            document.querySelector('#vehicle_image_img_preview').src = event.target.result;
        }

        reader.readAsDataURL(file);
    });


    document.querySelector('#document_image_front').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            event.target.value = null;
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            document.querySelector('#document_image_front_preview').src = event.target.result;
        }

        reader.readAsDataURL(file);
    });


    document.querySelector('#document_image_back').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            event.target.value = null;
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            document.querySelector('#document_image_back_preview').src = event.target.result;
        }

        reader.readAsDataURL(file);
    });

    document.querySelector('#cnic_copy_image_front').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            event.target.value = null;
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            document.querySelector('#cnic_copy_image_front_preview').src = event.target.result;
        }

        reader.readAsDataURL(file);
    });


    document.querySelector('#cnic_copy_back').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file.');
            event.target.value = null;
            return;
        }

        const reader = new FileReader();
        reader.onload = (event) => {
            document.querySelector('#cnic_copy_back_preview').src = event.target.result;
        }

        reader.readAsDataURL(file);
    });
</script>
