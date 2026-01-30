<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FaunaFlora')</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/tailwind/tailwind.min.css') }}">
    
    @yield('head')
</head>

<body class="antialiased bg-body text-body font-body">

    {{-- Header --}}
    @include('layouts.header')

    {{-- Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>