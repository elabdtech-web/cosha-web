@extends('admin.layouts.app')

@section('content')
    <!--main content wrapper-->
    <div class="vh-100">
        <div class="content p-3">
            {{-- Heading --}}
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Passengers</h3>
                    {{-- Add Passenger --}}
                </div>
            </div>

            {{-- Table --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        @include('admin.passengers.table')
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $passengers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
