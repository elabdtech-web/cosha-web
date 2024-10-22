@extends('admin.layouts.app')

@section('content')
    <!--main content wrapper-->
    <div class="vh-100">
        <div class="content p-3">
            {{-- Heading --}}
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Drivers</h4>
                    {{-- Add Passenger --}}
                    <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary btn-sm">Add new</a>
                </div>
            </div>
            {{-- End Heading --}}

            {{-- Table --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        @include('admin.drivers.table')
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $drivers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
