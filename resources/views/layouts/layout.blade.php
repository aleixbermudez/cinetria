<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body class="">

    @include('components.navbar')

    <div class="">
        @yield('content')       
    </div>
    
    <script src="{{ asset('node_modules/preline/dist/preline.js') }}"></script>

    <div class="mt-20">
        @include('components.footer')
    </div>

</body>
</html>