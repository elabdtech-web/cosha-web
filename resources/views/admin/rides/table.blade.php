<table class="table table-dark table-custom mb-0">
    <thead class="" style="background-color: #393939">
        <tr class="">
            <th scope="col">Ride type</th>
            <th scope="col">Passenger</th>
            <th scope="col">Driver</th>
            <th scope="col">Ride Fare</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rides as $ride)
            <tr>
                <td>{{ $ride->type }}</td>
                <td>{{ $ride->passenger->name }}</td>
                <td>{{ $ride->driver->name ?? 'N/A' }}</td>
                <td>{{ $ride->ride_price }}</td>
                <td>{{ $ride->created_at->format('d-m-Y') }}</td>
                <td>
                    <span class="badge {{ $ride->getStatusBadge() }}">
                        {{ ucfirst($ride->status) }}
                    </span>
                </td>
                <td><a href="{{ route('admin.rides.show', $ride->id) }}" class="btn btn-primary btn-sm">View</a></td>
            </tr>
        @empty
            <tr>
                <td colspan="6">No data found</td>
            </tr>
        @endforelse
    </tbody>
</table>
