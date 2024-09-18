<div class="container mt-5">
    <!-- Personal Details Section -->
    <div class="form-section">
        <h5 class="mb-4">Personal details</h5>
        <div class="row">
            <div class="col-md-3">
                <div class="upload-image-box">
                    <span>Image</span>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control  text-light" id="name"
                            placeholder="Enter username">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select  text-light" id="gender">
                            <option selected>Select gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control  text-light" id="email" placeholder="Enter email">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone number</label>
                        <input type="text" class="form-control  text-light" id="phone"
                            placeholder="Enter phone no.">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control text-light" id="age" placeholder="Enter age">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="passenger" class="form-label">Preferred passenger</label>
                        <select class="form-select  text-light" id="passenger">
                            <option selected>Select preferred passenger</option>
                            <option value="1">Passenger 1</option>
                            <option value="2">Passenger 2</option>
                        </select>
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
                <div class="upload-image-box">
                    <span>Upload image</span>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="vehicleName" class="form-label">Vehicle</label>
                        <input type="text" class="form-control  text-light" id="vehicleName"
                            placeholder="Enter vehicle name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="vehicleType" class="form-label">Vehicle type</label>
                        <select class="form-select text-light" id="vehicleType">
                            <option selected>Select type</option>
                            <option value="1">Sedan</option>
                            <option value="2">SUV</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="make" class="form-label">Make</label>
                        <select class="form-select  text-light" id="make">
                            <option selected>Select vehicle make</option>
                            <option value="toyota">Toyota</option>
                            <option value="honda">Honda</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="model" class="form-label">Model</label>
                        <input type="text" class="form-control  text-light" id="model" placeholder="Enter model">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="regNumber" class="form-label">Reg number</label>
                        <input type="text" class="form-control  text-light" id="regNumber"
                            placeholder="Enter Reg no.">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="docUpload" class="form-label">Upload Doc here</label>
                        <input type="file" class="form-control text-light" id="docUpload" accept=".pdf">
                        <small class="text-muted">PDF file, less than 5MB</small>
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
            <span>Driving license</span>
            <div class="col-md-6 mb-3">
                <div class="upload-image-box">
                    <span>Upload image</span>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="upload-image-box">
                    <span>Upload image</span>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="age" class="form-label">Name</label>
                <input type="text" class="form-control text-light" id="age" placeholder="Enter name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Father name</label>
                <input type="text" class="form-control text-light" id="phone"
                    placeholder="Enter father name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="age" class="form-label">CNIC number</label>
                <input type="text" class="form-control text-light" id="age"
                    placeholder="Enter cnic number">
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Expiry date</label>
                <input type="date" class="form-control text-light" id="phone">
            </div>
            <span class="mb-2">CNIC copy</span>
            <div class="col-md-6 mb-3">
                <div class="upload-image-box">
                    <span>Upload image</span>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="upload-image-box">
                    <span>Upload image</span>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="age" class="form-label">Given ame</label>
                <input type="text" class="form-control text-light" id="age" placeholder="Enter Given name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Surname</label>
                <input type="text" class="form-control text-light" id="phone"
                    placeholder="Enter father name">
            </div>
            <div class="col-md-6 mb-3">
                <label for="age" class="form-label">Document number</label>
                <input type="text" class="form-control text-light" id="age"
                    placeholder="Enter cnic number">
            </div>
            <div class="col-md-6 mb-3">
                <label for="phone" class="form-label">Expiry date</label>
                <input type="date" class="form-control text-light" id="phone">
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="float-end">
        <button type="submit" class="btn btn-primary">Add now</button>
    </div>
</div>
