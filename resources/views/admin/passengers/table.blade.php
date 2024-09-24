<table class="table table-dark table-custom mb-0">
    <thead>
        <tr>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Address</th>
            <th scope="col">Date Added</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($passengers as $passenger)
            <tr>
                <td><img src="{{ isset($passenger->profile_image) ? Storage::url('images/passengers/' . $passenger->profile_image) : asset('images/default.png') }}"
                        class="img-fluid rounded-circle" width="40" alt="Profile"></td>
                <td>{{ $passenger->name }}</td>
                <td>{{ $passenger->gender }}</td>
                <td>{{ $passenger->phone }}</td>
                <td>{{ $passenger->created_at }}</td>
                <td><a href="{{ route('admin.passengers.show', $passenger->id) }}"
                        class="btn btn-primary btn-sm">View</a></td>
            </tr>
        @endforeach
        <!-- Additional rows can be added below -->

    </tbody>
</table>
