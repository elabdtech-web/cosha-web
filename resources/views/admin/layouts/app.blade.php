<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('images/logo/favicon.ico') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cosha') }} Admin</title>

    {{-- Load fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    {{-- Load Font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

    {{-- Include bootstrap --}}

    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">

    {{-- Include custom styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body class="admin-body">
    <div class="bg-dark vh-100">

        {{-- If auth then load navbar & sidebar --}}
        @auth
            {{-- Navbar --}}
            @include('admin.includes.navbar')

            {{-- Sidebar --}}
            @include('admin.includes.sidebar')
        @endauth

        <main id="body-pd" class="body-pd m-3">
            @yield('content')
        </main>
    </div>

    {{-- JS Files here --}}
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    @auth
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                // Toggle sidebar
                $("#sidebarToggle").on('click', function() {
                    // header
                    $("#header").toggleClass("toggle");
                    // side-bar
                    $("#side-bar").toggleClass("show");
                    // body-pd
                    $("#body-pd").toggleClass("body-pd");

                })
            });
        </script>
    @endauth
</body>

</html>
