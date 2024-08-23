<div class="sidebar show" id="side-bar">
    <nav class="nav">
        <div class="nav_logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo/logo.png') }}" width="150" alt="logo">
            </a>
        </div>
        <div class="nav_list">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}" class="nav_item active">
                <i class='fa fa-home nav_icon'></i>
                <span class="nav_name">Dashboard</span>
            </a>
            {{-- Users --}}
            <a href="#" class="nav_item">
                <i class='fa fa-user nav_icon'></i>
                <span class="nav_name">Users</span>
            </a>
            {{-- Drivers --}}
            <a href="#" class="nav_item">
                <i class='fa fa-user nav_icon'></i>
                <span class="nav_name">Drivers</span>
            </a>
            {{-- Rides --}}
            <a href="#" class="nav_item">
                <i class='fa fa-bus nav_icon'></i>
                <span class="nav_name">Rides</span>
            </a>
            {{-- Wallet --}}
            <a href="#" class="nav_item">
                <i class='fa fa-wallet nav_icon'></i>
                <span class="nav_name">Wallet</span>
            </a>
            {{-- Rewards --}}
            <a href="#" class="nav_item">
                <i class='fa fa-gift nav_icon'></i>
                <span class="nav_name">Rewards</span>
            </a>
            {{-- Seprator --}}
            <hr>
            {{-- Settings --}}
            <a href="#" class="nav_item">
                <i class='fa fa-cog nav_icon'></i>
                <span class="nav_name">Settings</span>
            </a>
            {{-- SignOut --}}
            <a href="#" class="nav_item">
                <i class="fa fa-file nav_icon"></i>
                <span class="nav_name">SignOut</span>
            </a>
        </div>
    </nav>
</div>
