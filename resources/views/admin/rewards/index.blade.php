@extends('admin.layouts.app')

@section('content')
    <!--main content wrapper-->
    <div class="vh-100">
        <div class="content p-3">
            {{-- Heading --}}
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Rewards</h4>
                    {{-- Add Wallet --}}
                    <a href="{{ route('admin.rewards.create') }}" class="btn btn-primary btn-sm">Add new</a>
                </div>
            </div>
            {{-- Table --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        @include('admin.rewards.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
