<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DentMax')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-b from-[#3E92CC] to-[#62B6CB] min-h-screen flex flex-col justify-between">
    @include('partials.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.footer')
</body>

</html>