<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
<body class="bg-light">
    <div class="container-fluid p-0">
        <div class="row g-0 vh-100">
            <!-- Left Side: Image (Visible on MD screens and up) -->
            <div class="col-md-6 d-none d-md-block">
                <img src="{{ asset('assets/images/bgauth.png') }}" 
                     class="img-fluid vh-100 w-100" 
                     style="object-fit: cover;" 
                     alt="Login Background">
            </div>

            <!-- Right Side: Login Card -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-white">
                <div class="p-5 w-100" style="max-width: 450px;">
                    <!-- Logo -->
                    <div class="text-center mb-4">
                        <img height="80" src="{{ asset('assets/images/logoclt.png') }}" alt="Logo">
                    </div>

                    <!-- Card wrapper for the $slot -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
