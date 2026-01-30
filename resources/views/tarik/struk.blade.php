<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Penarikan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">

<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
    <div class="text-center mb-6">
        <h1 class="text-xl font-bold">STRUK PENARIKAN SALDO</h1>
        <p class="text-sm text-gray-500">Bukti transaksi penarikan</p>
    </div>

    <div class="space-y-3 text-sm">
        <div class="flex justify-between">
            <span class="text-gray-500">Kode Penarikan</span>
            <span class="font-medium">{{ $penarikan->kode_penarikan }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Nama User</span>
            <span>{{ $user->name }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Bank / E-Wallet</span>
            <span>{{ $penarikan->tujuan }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">No Rekening</span>
            <span>{{ $penarikan->rekening }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Nominal</span>
            <span class="font-semibold">
                Rp {{ number_format($penarikan->nominal, 0, ',', '.') }}
            </span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Tanggal</span>
            <span>{{ $penarikan->tanggal_penarikan }}</span>
        </div>

        <div class="flex justify-between">
            <span class="text-gray-500">Status</span>
            <span class="px-2 py-1 rounded text-xs
                @if($penarikan->status == 'success') bg-green-100 text-green-700
                @elseif($penarikan->status == 'pending') bg-yellow-100 text-yellow-700
                @else bg-red-100 text-red-700
                @endif">
                {{ ucfirst($penarikan->status) }}
            </span>
        </div>
    </div>

    <hr class="my-5">

    <div class="text-center text-xs text-gray-500">
        Terima kasih telah menggunakan layanan kami
    </div>

    <div class="mt-6 flex gap-3">
        <button onclick="window.print()"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
            Cetak Struk
        </button>

        <a href="{{ url()->previous() }}"
           class="w-full text-center border py-2 rounded-lg">
            Kembali
        </a>
    </div>
</div>

</body>
</html>
