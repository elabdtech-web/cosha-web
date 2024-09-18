{{-- Create Passenger --}}
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- Heading --}}
                <h3 class="mb-0">Create Drivers</h3>

                {{-- Form --}}
                <form action="{{ route('admin.drivers.store') }}" method="POST">
                    @csrf
                    @include('admin.drivers.form')
                </form>
            </div>
        </div>
    </div>
@endSection
