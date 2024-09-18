 <div class="card p-4">
     <h5 class="card-title">Canceled Rides</h5>
     <table class="table table-dark table-custom mb-0">
         <thead>
             <tr>
                 <th>Ride Type</th>
                 <th>Status</th>
                 <th>Total Fare</th>
                 <th>Driver</th>
                 <th>Action</th>
             </tr>
         </thead>
         <tbody>
             <tr>
                 <td>Solo, One-time</td>
                 <td>Canceled</td>
                 <td>$0.00</td>
                 <td>John Doe</td>
                 <td>
                     <a href="#" class="btn btn-primary-outline btn-sm" data-bs-toggle="modal"
                         data-bs-target="#cancelModal">
                         View
                     </a>
                 </td>
             </tr>

         </tbody>
     </table>
 </div>


 <div class="modal fade" id="cancelModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content bg-dark">
             <div class="modal-body">
                 <div class="row">
                     <div class="col-md-8">
                         <div class="map-img mb-3" id="map"></div>
                     </div>
                     <div class="col-md-4">
                         {{-- location --}}
                         <div class="row mb-4 location-details">
                             <span class="mb-0">Location details</span>
                             <div class="col-12">
                                 <p class="mb-0 text-sm"> <i class="fa fa-paper-plane mr-2"></i> 2972 Westheimer Rd.
                                     Santa
                                     Ana, Illinois 85486</p>
                             </div>
                             {{-- vertical dashed line --}}
                             <div class="col-12">
                                 <div class="dashed-line">
                                 </div>
                             </div>

                             <div class="col-12">
                                 <p class="mb-0"><i class="fa fa-circle text-danger"></i> 2972 Westheimer Rd. Santa
                                     Ana,
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
                         {{-- passenger --}}
                         <h6 class="mb-4">Passenger</h6>
                         <div class="d-flex align-items-center gap-4 mt-3">
                             <img src="{{ asset('images/sample/profile.png') }}" alt="Passenger"
                                 class="driver-profile-img rounded-circle">
                             <p class="mb-0">Passenger</p>
                         </div>
                     </div>
                     <div class="col-md-4">
                         <h6>Driver</h6>
                         <div class="d-flex align-items-center gap-4 mt-3">
                             <img src="{{ asset('images/sample/profile.png') }}" alt="Driver"
                                 class="driver-profile-img rounded-circle">
                             <p class="mb-0">Driver</p>
                             <button class="btn btn-primary-outline btn-sm">View</button>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
