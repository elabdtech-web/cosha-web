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
                           <p class="mb-0 text-sm"> <i class="fa fa-paper-plane mr-2"></i> 2972 Westheimer Rd. Santa
                               Ana, Illinois 85486</p>
                       </div>
                       {{-- vertical dashed line --}}
                       <div class="col-12">
                           <div class="dashed-line">
                           </div>
                       </div>

                       <div class="col-12">
                           <p class="mb-0"><i class="fa fa-circle text-danger"></i> 2972 Westheimer Rd. Santa Ana,
                               Illinois
                               85486</p>
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
                           <p>{{ $passenger->rides->first()->type ?? 'Not set' }}</p>
                           <p><span
                                   class="badge {{ $passenger->rides->first()->getStatusBadge() ?? 'badge-secondary' }}">{{ ucfirst($passenger->rides->first()->status) }}</span>
                           </p>
                           <p>${{ $passenger->rides->first()->ride_price }}</p>
                           <p>Mastercard</p>
                       </div>
                   </div>
               </div>
               @if ($passenger->rides->first()->driver_id != null)
                   <div class="col-md-6">
                       <h6>Driver</h6>
                       <div class="d-flex align-items-center gap-4 mt-3">
                           <img src="{{ $passenger->rides->first()->driver->profile_image ? Storage::url('images/drivers/' . $passenger->rides->first()->driver->profile_image) : $passenger->rides->first()->driver->profile_image }}"
                               alt="Driver" class="driver-profile-img rounded-circle">
                           <p class="mb-0">{{ $passenger->rides->first()->driver->name }}</p>
                           <button class="btn btn-primary-outline btn-sm">View Profile</button>
                       </div>
                   </div>
               @else
                   <div class="col-md-6">
                       <h6>Driver</h6>
                       <div class="d-flex align-items-center gap-4 mt-3">
                           <span>Not set</span>
                       </div>
                   </div>
               @endif
           </div>
       </div>
   </div>
