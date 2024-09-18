{{-- Create Passenger --}}
@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                {{-- Heading --}}
                <h4 class="mb-0">Create Reward</h4>

                {{-- Form --}}
                <form action="{{ route('admin.drivers.store') }}" method="POST">
                    @csrf
                    @include('admin.rewards.form')
                </form>
            </div>
        </div>
    </div>
@endSection
