<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ultrafort')</title>
    <link rel="icon" href="{{ asset('favicon.png') }}">
    @vite('resources/css/app.css')

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>




    @yield('head')
</head>

<body>


    {{-- Header --}}
    @include('layouts.header')

    {{-- Content --}}
    <main class="flex-grow pt-22">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('layouts.footer')


    @if(session('success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="translate-y-[-20px] opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition transform ease-in duration-300"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-[-20px] opacity-0"
        class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded shadow-lg min-w-[250px] font-semibold z-50">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 5000)"
        x-show="show"
        x-transition:enter="transition transform ease-out duration-300"
        x-transition:enter-start="translate-y-[-20px] opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition transform ease-in duration-300"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-[-20px] opacity-0"
        class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded shadow-lg min-w-[250px] font-semibold z-50">
        {{ session('error') }}
    </div>
    @endif

    @stack('scripts')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>





</body>

</html>