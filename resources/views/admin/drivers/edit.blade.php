{{-- Create Passenger --}}
@extends('admin.layouts.app')

@section('content')
    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{-- Heading --}}
                    <h3 class="mb-0">Edit Drivers</h3>
                    {{-- Form --}}
                    <form action="{{ route('admin.drivers.update', $driver->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('admin.drivers.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endSection
