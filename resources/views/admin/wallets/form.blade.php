<div class="container mt-5">
    <!-- Personal Details Section -->
    <div class="form-section">
        <h5 class="mb-4">Add new bonus</h5>
        <div class="row">
            <div class="col-md-12">
                <div class="upload-image-box-wallet">
                    <span>Image</span>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Title</label>
                        <input type="text" class="form-control  text-light" id="name"
                            placeholder="Enter bonus name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="text" class="form-label">description</label>
                        <input type="text" class="form-control  text-light" id="description"
                            placeholder="Enter bonus description">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Ride type</label>
                        <select class="form-select text-light" id="gender">
                            <option selected>Select ride</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="passenger" class="form-label">Bonus</label>
                        <select class="form-select  text-light" id="passenger">
                            <option selected>Select bonus</option>
                            <option value="1">Passenger 1</option>
                            <option value="2">Passenger 2</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="passenger" class="form-label">Applicable when</label>
                        <select class="form-select  text-light" id="passenger">
                            <option selected>Select no of rides</option>
                            <option value="1">Passenger 1</option>
                            <option value="2">Passenger 2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="float-end">
        <button type="submit" class="btn btn-primary btn-md">Add now</button>
    </div>
</div>