   <div class="card ongoing-card">
       <div class="card-body">
           <div class="d-flex justify-content-between align-items-center action-buttons mb-3">
               <span class="card-title">Shared Ride</span>
               {{-- cancel button --}}
               <button class="btn">Cancel <i class="fa fa-times-circle"></i></button>
           </div>
           <div class="row">
               <div class="col-md-8">
                   <div class="map-img mb-3" id="map"></div>
               </div>
               <div class="col-md-4">
                   {{-- location --}}
                   <div class="row mb-4 location-details">
                       <span class="mb-0">Location details</span>
                       <div class="col-12">
                           <p class="mb-0 text-sm"> <i class="fa fa-paper-plane mr-2"></i>
                               {{ $ride->pickup_location ?? 'Not set' }}</p>
                       </div>
                       {{-- vertical dashed line --}}
                       <div class="col-12">
                           <div class="dashed-line">
                           </div>
                       </div>

                       <div class="col-12">
                           <p class="mb-0"><i class="fa fa-circle text-danger"></i>
                               {{ $ride->dropoff_location ?? 'Not set' }}</p>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Location and Ride Info -->
           <div class="row">
               <div class="col-md-6 border-right">
                   <h6 class="mb-4">Ride Details</h6>
                   <div class="row">
                       <div class="col-6">
                           <p>Ride Type:</p>
                           <p>Status:</p>
                           <p>Total Fare:</p>
                           <p>Payment:</p>
                       </div>
                       <div class="col-6 text-end">
                           <p>{{ $ride->type ?? 'Not set' }}</p>
                           <p><span class="badge bg-success">
                                   {{ $ride->status ?? 'Not set' }}</span></p>

                           <p>{{ $ride->ride_price ?? 'Not set' }}</p>
                           <p>Mastercard</p>
                       </div>
                   </div>
               </div>
               <div class="col-md-6">
                   <h6>Driver</h6>
                   <div class="d-flex align-items-center gap-4 mt-3">
                       <img src="{{ $driver->profile_image ? Storage::url('images/drivers/' . $driver->profile_image) : asset('images/default.png') }}"
                           alt="Driver" class="driver-profile-img rounded-circle">
                       <p class="mb-0">{{ $driver->name }}</p>
                   </div>
               </div>
           </div>
       </div>
   </div>
