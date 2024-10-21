@extends('admin.layouts.app')

@section('content')
    <!--main content wrapper-->
    <div class="vh-100">
        <div class="content p-3">
            {{-- Heading --}}
            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-0">Rides</h4>
                </div>
            </div>
            {{-- Table --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        @include('admin.rides.table')
                    </div>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $rides->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
