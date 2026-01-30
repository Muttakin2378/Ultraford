

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/tailwind/tailwind.min.css') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="antialiased bg-body text-body font-body">

    {{-- SweetAlert Success --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    {{-- SweetAlert Error --}}
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "{{ session('error') }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    {{-- Blade $errors --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Login',
                    text: "{{ $errors->first() }}",
                    timer: 2500,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    <div>
        <section class="relative pt-52 xs:pt-40 pb-16 md:pb-24 lg:pb-52 bg-orange-50 overflow-hidden">
            <a class="absolute top-0 left-0 ml-5 mt-12 inline-block" href="#!">
                {{-- SVG logo --}}
            </a>
            <p class="absolute top-0 right-0 mt-32 xs:mt-12 mr-5">
                <span>Sudah Punya Akun?</span>
                <a class="inline-block font-medium underline hover:text-lime-600" href="{{ route('login') }}">Masuk ke akun anda</a>
            </p>

            <div class="container mx-auto px-4 relative">
                <div class="max-w-sm mx-auto">
                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf
                        <h3 class="text-4xl text-center font-medium mb-10">Register</h3>

                        <label class="block pl-4 mb-1 text-sm font-medium" for="">Nama Lengkap</label>
                        <input type="text" name="name" required
                            placeholder="Masukkan Nama Lengkap Kamu"
                            class="w-full px-4 py-3 mb-6 outline-none ring-offset-0 focus:ring-2 focus:ring-lime-500 shadow rounded-full">

                        <label class="block pl-4 mb-1 text-sm font-medium" for="">Email</label>
                        <input type="email" name="email" required
                            value="{{ old('email') }}"
                            placeholder="Masukkan email kamu"
                            class="w-full px-4 py-3 mb-6 outline-none ring-offset-0 focus:ring-2 focus:ring-lime-500 shadow rounded-full">

                        <label class="block pl-4 mb-1 text-sm font-medium" for="">Password</label>
                        <div class="relative mb-6" x-data="{ visible: false }">
                            <input name="password" required
                                :type="visible ? 'text' : 'password'"
                                placeholder="Masukkan password kamu"
                                class="relative w-full px-4 py-3 outline-none ring-offset-0 focus:ring-2 focus:ring-lime-500 shadow rounded-full">
                            <a href="#!" class="absolute top-1/2 right-0 transform -translate-y-1/2 mr-4"
                                x-on:click.prevent="visible = !visible">
                                {{-- Eye SVG --}}
                            </a>
                        </div>

                        <label class="block pl-4 mb-1 text-sm font-medium" for="">Konfirmasi Password</label>
                        <div class="relative mb-6" x-data="{ visible: false }">
                            <input name="password_confirmation" required
                                :type="visible ? 'text' : 'password'"
                                placeholder="Masukkan password kamu"
                                class="relative w-full px-4 py-3 outline-none ring-offset-0 focus:ring-2 focus:ring-lime-500 shadow rounded-full">
                            <a href="#!" class="absolute top-1/2 right-0 transform -translate-y-1/2 mr-4"
                                x-on:click.prevent="visible = !visible">
                                {{-- Eye SVG --}}
                            </a>
                        </div>


                        <button type="submit"
                            class="inline-flex w-full py-3 px-6 items-center justify-center text-lg font-medium text-white hover:text-teal-900 border border-teal-900 hover:border-lime-500 bg-teal-900 hover:bg-lime-500 rounded-full transition duration-200">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>

</body>

</html>

