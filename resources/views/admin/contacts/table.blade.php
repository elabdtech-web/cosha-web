<table class="table table-dark table-custom mb-0">
    <thead class="" style="background-color: #393939;">
        <tr class="">
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Date added</th>
            <th scope="col">Message</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($requests as $request)
            <tr>
                <td>{{ $request->name }}</td>
                <td>{{ $request->email }}</td>
                <td>{{ $request->created_at }}</td>
                <td>{{ $request->message }}</td>
                <td>
                    {{-- <a href="{{ route('admin.drivers.edit', $driver->id) }}" class="btn btn-secondary"> <i
                            class="fa fa-edit"></i></a>
                    <a href="{{ route('admin.drivers.destroy', $driver->id) }}" class="btn btn-danger"
                        data-confirm-delete="true"> <i class="fa fa-trash"></i></a> --}}

                    <a href="#" class="btn btn-primary">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
