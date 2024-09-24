{{-- Navbar --}}
<nav class="navbar navbar-expand-lg bg-dark navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo/logo.png') }}" alt="Cosha logo" width="100">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                </li>
                {{-- Services --}}
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                {{-- About --}}
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                {{-- Contact --}}
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
            <div class="d-flex">
                @auth
                    {{-- If role is admin --}}
                    @if (Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary" role="button">Dashboard</a>
                    @else
                        <a href="{{ route('home') }}" class="btn btn-primary" role="button">Dashboard</a>
                    @endif
                @else
                    <a href="{{ route('admin.login') }}" class="btn btn-primary" role="button">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
