  <div class="modal fade" id="vehicleDetailModal" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content bg-dark">
              <div class="modal-body">
                  <h6 class="mb-3">Vehicle Details</h6>
                  <div class="row">
                      <div class="col-md-6">
                          <img src="{{ isset($driver->vehicles->vehicle_image) ? Storage::url('images/drivers/' . $driver->vehicles->vehicle_image) : asset('images/default.png') }}"
                              width="300" alt="Vehicle Image">
                      </div>
                      <div class="col-md-6">
                          <div class="row">
                              <div class="col-md-6">
                                  <span class="text-muted">Vehicle *</span>
                                  <p class="mb-3">{{ $driver->vehicles->vehicle_name ?? 'N/A' }}</p>
                                  <span class="text-muted">Model*</span>
                                  <p class="mb-3">{{ $driver->vehicles->model ?? 'N/A' }}</p>
                              </div>
                              <div class="col-md-6">
                                  <span class="text-muted">Vehicle Type *</span>
                                  <p class="mb-3">{{ $driver->vehicles->type ?? 'N/A' }}</p>
                                  <span class="text-muted">Make*</span>
                                  <p class="mb-3">{{ $driver->vehicles->make ?? 'N/A' }}</p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row mt-3">
                      <div class="col-md-6">
                          <img src="{{ isset($driver->identity_document->front_image) ? Storage::url('images/drivers/' . $driver->identity_document->front_image) : asset('images/default.png') }}"
                              width="200" alt="Document Image">
                      </div>
                      <div class="col-md-6">
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  {{-- Document Details --}}
  <div class="modal fade" id="documentDetailModal" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content bg-dark">
              <div class="modal-body">
                  <div class="d-flex justify-content-between mb-2">
                      <span>Driving License</span>
                      <span class="text-primary"> Download <i class="fa fa-arrow-down text-primary"></i></span>
                  </div>
                  <div class="row mt-3">
                      <div class="col-md-6">
                          <img src="{{ isset($driver->identity_document->front_image) ? Storage::url('images/drivers/' . $driver->identity_document->front_image) : asset('images/default.png') }}"
                              width="300" alt="Vehicle Image">
                      </div>
                      <div class="col-md-6">
                          <div class="row">
                              <div class="col-md-6">
                                  <span class="text-muted">Name *</span>
                                  <p class="mb-3">{{ $driver->name ?? 'N/A' }}</p>
                                  <span class="text-muted">Expiry Date*</span>
                                  <p class="mb-3">{{ $driver->license->expiry_date ?? 'N/A' }}</p>
                              </div>
                              <div class="col-md-6">
                                  <span class="text-muted">Father Name *</span>
                                  <p class="mb-3">{{ $driver->identity_document->father_name ?? 'N/A' }}</p>
                                  <span class="text-muted">CNIC*</span>
                                  <p class="mb-3">{{ $driver->identity_document->cnic_number ?? 'N/A' }}</p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="row mt-3">
                      <div class="d-flex justify-content-between mb-2">
                          <span>CNIC</span>
                          <span class="text-primary"> Download <i class="fa fa-arrow-down text-primary"></i></span>
                      </div>

                      <div class="col-md-6">
                          <img src="{{ isset($driver->identity_document->cnic_copy_front) ? Storage::url('images/drivers/' . $driver->identity_document->cnic_copy_front) : asset('images/default.png') }}"
                              width="300" alt="Vehicle Image">
                      </div>
                      <div class="col-md-6">
                          <div class="row">
                              <div class="col-md-6">
                                  <span class="text-muted">Name *</span>
                                  <p class="mb-3">{{ $driver->name ?? 'N/A' }}</p>
                                  <span class="text-muted">Father name*</span>
                                  <p class="mb-3">{{ $driver->identity_document->father_name ?? 'N/A' }}</p>
                              </div>
                              <div class="col-md-6">
                                  <span class="text-muted">Issue date *</span>
                                  <p class="mb-3">{{ $driver->license->issued_date ?? 'N/A' }}</p>
                                  <span class="text-muted">Expiry date*</span>
                                  <p class="mb-3">{{ $driver->license->expiry_date ?? 'N/A' }}</p>
                              </div>
                              <div class="col-md-6">
                                  <span class="text-muted">CNIC No *</span>
                                  <p class="mb-3">{{ $driver->identity_document->cnic_number ?? 'N/A' }}</p>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
