{{-- Create Passenger --}}
@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- Heading --}}
            <h3 class="mb-0">Create Passenger</h3>

            {{-- Form --}}
            <form action="{{ route('admin.passenger.store') }}" method="POST">
                @csrf
                @include('admin.passengers.form')
            </form>
        </div>
    </div>
@endSection
