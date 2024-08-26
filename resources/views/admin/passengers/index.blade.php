@extends('admin.layouts.app')

@section('content')
    <!--main content wrapper-->
    <div class="height-100">
        <div class="content ">
            {{-- Heading --}}
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <h3 class="mb-0">Passengers</h3>
                    {{-- Add Passenger --}}
                    <a href="{{ route('admin.passenger.create') }}" class="btn btn-primary btn-sm">Add</a>
                </div>
            </div>
            {{-- End Heading --}}

            {{-- Data Table of Passengers --}}

        </div>
    </div>
@endsection
