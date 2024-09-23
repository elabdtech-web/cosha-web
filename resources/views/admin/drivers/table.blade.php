<table class="table table-dark table-custom mb-0">
    <thead class="" style="background-color: #393939;">
        <tr class="">
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Gender</th>
            <th scope="col">Date added</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($drivers as $driver)
            <tr>
                <td><img src="{{ isset($driver->profile_image) ? Storage::url('images/drivers/' . $driver->profile_image) : asset('images/default.png') }}"
                        alt="image" class="rounded-circle" width="50" height="50"></td>
                <td>{{ $driver->name }}</td>
                <td>{{ $driver->gender }}</td>
                <td>{{ $driver->created_at }}</td>
                <td>
                    <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-secondary"> <i
                            class="fa fa-edit"></i></a>
                    <a href="{{ route('admin.drivers.destroy', $driver->id) }}" class="btn btn-danger"
                        data-confirm-delete="true"> <i class="fa fa-trash"></i></a>

                    <a href="{{ route('admin.drivers.show', $driver->id) }}" class="btn btn-primary">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
