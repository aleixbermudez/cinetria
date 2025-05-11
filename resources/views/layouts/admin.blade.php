<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href={{ asset('style.css') }}>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.0.24/dist/tailwind.min.css" rel="stylesheet">



    <!-- Otros metadatos -->
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <title>Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="">
    <div>
        @include('components.dashboard.sidebar')
    </div>
    

    <div class="">
        @yield('content')       
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>