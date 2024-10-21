 <div class="card p-4">
     <h5 class="card-title">Canceled Rides</h5>
     <table class="table table-dark table-custom mb-0">
         <thead>
             <tr>
                 <th>Ride Type</th>
                 <th>Passengers</th>
                 <th>Ride Fare</th>
                 <th>Date</th>
                 <th>Status</th>
                 <th>Action</th>
             </tr>
         </thead>
         <tbody>
             @forelse ($cancelledRide as $item)
                 <tr>
                     <td>{{ $item->type }}</td>
                     <td>
                         {{ $item->passenger->count() }}
                     </td>
                     <td>
                         {{ $item->ride_price }}
                     </td>
                     <td>
                         {{ $item->created_at->format('d-m-Y') }}
                     </td>
                     <td>
                         <span class="badge {{ $item->getStatusBadge() }}">
                             {{ ucfirst($item->status) }}
                         </span>
                     </td>
                     <td>
                         <a href="{{ route('admin.rides.show', $item->id) }}" class="btn btn-primary-outline btn-sm">
                             View
                         </a>
                     </td>
                 </tr>
             @empty
                 <tr>
                     <td colspan="6" class="text-center">No Cancel Rides</td>
                 </tr>
             @endforelse
         </tbody>
     </table>
 </div>
