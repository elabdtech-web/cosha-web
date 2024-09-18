@extends('admin.layouts.app')

@section('content')
    <!--main content wrapper-->
    <div class="vh-100">
        <div class="container mt-3">
            <h4 class="mb-3">Wallet</h4>
            <div class="balance-card d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <span class="wallet-icon">💼</span>
                    <div>
                        <p class="mb-1">Main balance</p>
                        <p class="balance-amount">$664,579.99</p>
                    </div>
                </div>
                <button class="btn-withdraw">Withdraw</button>
            </div>
        </div>
        <div class="content p-3">
            {{-- Heading --}}
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end align-items-center">
                    {{-- Add Wallet --}}
                    <a href="{{ route('admin.wallet.create') }}" data-bs-toggle="modal" data-bs-target="#walletFormModal"
                        class="btn btn-primary btn-sm">Add new</a>
                </div>
            </div>
            {{-- Table --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        @include('admin.wallets.table')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="walletFormModal" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark">
                <div class="modal-body">
                    @include('admin.wallets.form')
                </div>
            </div>
        </div>
    </div>
@endsection
