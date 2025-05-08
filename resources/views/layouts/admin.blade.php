<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

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