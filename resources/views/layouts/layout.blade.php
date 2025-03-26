<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="bg-black">

    <div class="">
        @yield('content')       
    </div>
    <script src="{{ asset('node_modules/preline/dist/preline.js') }}"></script>
</body>
</html>