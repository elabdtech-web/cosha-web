<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cosha') }}</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('images/logo/favicon.ico') }}">

    {{-- Load fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    {{-- Include bootstrap --}}

    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">

    {{-- Include custom styles --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    <div id="app">
        {{-- Include navbar --}}
        @include('frontend.includes.navbar')

        {{-- Include main content --}}
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
