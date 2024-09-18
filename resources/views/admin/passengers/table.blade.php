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
        <tr>
            <td><img src="https://via.placeholder.com/50" class="img-fluid rounded" alt="Profile"></td>
            <td>Aaron Chapman</td>
            <td>Male</td>
            <td>1234 Elm Street, New York, NY</td>
            <td>2023-09-15</td>
            <td><a href="{{ route('admin.passengers.show', 1) }}" class="btn btn-primary btn-sm">View</a></td>
        </tr>
        <!-- Additional rows can be added below -->
        <tr>
            <td><img src="https://via.placeholder.com/50" class="img-fluid rounded" alt="Profile"></td>
            <td>Jane Doe</td>
            <td>Female</td>
            <td>5678 Oak Avenue, San Francisco, CA</td>
            <td>2024-09-12</td>
            <td><a href="{{ route('admin.passengers.show', 2) }}" class="btn btn-primary btn-sm">View</a></td>
        </tr>
    </tbody>
</table>
